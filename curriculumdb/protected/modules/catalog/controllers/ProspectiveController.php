<?php
/**
 * short class description.
 * Extended class description
 * 
 * @author curriculum
 * @package modules.catalog.controllers
 */
class ProspectiveController extends Controller
{
	public function actionCreate()
	{
        $dgu = new CurrDgu;
        $major = new CurrMajor;
        $course = new CurrCourse;
        $set = new CurrSet;
        $group = new CurrGroup;
        $minor = new CurrMinor;
        $certificate = new CurrCertificate;
        $model = new Catalog;       
        
        
		$this->render('create',array( 'model'=>$model ,
                                        'dgu'=>$dgu, 
                                        'major'=>$major, 
                                        'course'=>$course, 
                                        'set'=>$set, 
                                        'group'=>$group,
                                        'minor'=>$minor, 
                                        'certificate'=>$certificate),false, true);

	}

    /*CATALOG FUNCTIONS*/

    public function actionGetLastCatalogID()
    {
        $max = Yii::app()->db->createCommand()->select('max(id) as max')->from('catalog')->queryScalar();

        $max = intval($max);
        $max++;

        $return = $_GET;
        $return["catalogId"] = $max;

        echo json_encode($return);

    }

    public function actionInsertNewCatalog()
    {
        $name = $_GET["name"];
        $description = $_GET["description"];
        $term = $_GET["term"];
        $year = $_GET["year"];
        $activated = 0;
        $isProspective = 1;
        $isProposed = 0;
        $date = new DateTime();
        $timestamp = $date->format('Y-m-d H:i:s');

        $creator = Yii::app()->user->id;

        $creatorID = $creator;

        $catalog = new Catalog();

        $catalog->name = $name;
        $catalog->description = $description;
        $catalog->term = $term;
        $catalog->year = $year;
        $catalog->activated = $activated;
        $catalog->isProspective = $isProspective;
        $catalog->creatorId = $creatorID;
        $catalog->isProposed = $isProposed;
        $catalog->creationDate = $timestamp;
        $catalog->save();
    }

    public function actionProposeProspectiveCatalog()
    {
        $catalogID = $_GET["catalogID"];
        $name = $_GET["name"];
        $description = $_GET["description"];
        $term = $_GET["term"];
        $year = $_GET["year"];
        $creatorID = $_GET["user"];
        $activated = 0;
        $isProspective = 0;
        $isProposed = 1;
        $date = new DateTime();
        $timestamp = $date->format('Y-m-d H:i:s');


        $catalog = Catalog::model()->findByPk($catalogID);
        $catalog->name = $name;
        $catalog->description = $description;
        $catalog->term = $term;
        $catalog->year = $year;
        $catalog->activated = $activated;
        $catalog->isProspective = $isProspective;
        $catalog->creatorId = $creatorID;
        $catalog->isProposed = $isProposed;
        $catalog->creationDate = $timestamp;
        $catalog->update();
    }

    public function actionLoadProspectiveCatalogInfo()
    {
        $catalog = new Catalog();
        $user = $_GET["user"];
        $isProspective = 1;

        $return = $_GET;

        $existCatalog = $catalog->find('creatorID=:creatorID AND isProspective=:isProspective', array(':creatorID' => $user, ':isProspective' => $isProspective));

        if ($existCatalog) {
            $return["myname"] = $existCatalog->getAttribute('name');
            $return["mydescription"] = $existCatalog->getAttribute('description');
            $return["myterm"] = $existCatalog->getAttribute('term');
            $return["myyear"] = $existCatalog->getAttribute('year');
            $return["myexist"] = 'yes';
            $return["myid"] = $existCatalog->getAttribute('id');
        } else {
            $return["myexist"] = 'no';
        }

        echo json_encode($return);
    }

    public function actionProposeCatalogFromView()
    {
        $catalogId = $_GET["catno"];

        $catalog = Catalog::model()->findByPk($catalogId);
        $activated = 0;
        $isProspective = 0;
        $isProposed = 1;
        $date = new DateTime();
        $timestamp = $date->format('Y-m-d H:i:s');
        $catalog->activated = $activated;
        $catalog->isProspective = $isProspective;
        $catalog->isProposed = $isProposed;
        $catalog->creationDate = $timestamp;
        $catalog->update();
    }

    public function actionAcceptCatalog()
    {
        $catalogId = $_GET["catno"];
/*
        $catActive = Catalog::model()->find('activated=:activated', array(':activated'=>1));
        $catActive->activated = 0;
        $catActive->update();
*/
        $catalog = Catalog::model()->findByPk($catalogId);
        $activated = 1;
        $isProspective = 0;
        $isProposed = 0;
        $catalog->activated = $activated;
        $catalog->isProspective = $isProspective;
        $catalog->isProposed = $isProposed;
        $catalog->update();
    }

    public function actionRejectCatalog()
    {
        $catalogId = $_GET["catno"];

        $catalog = Catalog::model()->findByPk($catalogId);
        $activated = 0;
        $isProspective = 1;
        $isProposed = 0;
        $catalog->activated = $activated;
        $catalog->isProspective = $isProspective;
        $catalog->isProposed = $isProposed;
        $catalog->update();
    }
    /*end catalog functions*/


    private function updateTrackGroupTable($trackId, $catalogNumber)
    {
        $trackByGroupTable = new CurrTrackByGroup();
        $currTrack = new CurrTrack();
        //$catNeeded = $currTrack->find('id=:id', array(':id'=>$trackId))->getAttribute('catalog_id');
        $catNeeded = $this->getCatalogForTrack($trackId);
        $rels = $trackByGroupTable->findAll('track_id=:track_id AND catalog_id=:catalog_id', array(':track_id'=>$trackId, ':catalog_id'=>$catNeeded));
        foreach($rels as $r)
        {
            $groupId = $r->getAttribute('$group_id');
            $tableTrackGroup = new CurrGroupBySet();
            $exist = $tableTrackGroup->find('group_id=:group_id AND catalog_id=:catalog_id AND track_id=:track_id', array(':track_id'=>$trackId, ':catalog_id'=>$catalogNumber, ':group_id'=>$groupId));
            if ( !$exist )
            {
                $tableTrackGroup = new CurrTrackByGroup();
                $tableTrackGroup->track_id = $trackId;
                $tableTrackGroup->group_id = $groupId;
                $tableTrackGroup->catalog_id = $catalogNumber;
                $tableTrackGroup->save();

                //updates set by course tables
                $this->updateGroupSetTable($groupId, $catalogNumber );
            }
        }
    }

    private function updateGroupSetTable($groupId, $catalogNumber)
    {
        $groupBySetTable = new CurrGroupBySet();
        $currGroup = new CurrGroup();
        //$catNeeded = $currGroup->find('id=:id', array(':id'=>$groupId))->getAttribute('catalog_id');
        $catNeeded = $this->getCatalogForGroup($groupId);
        $rels = $groupBySetTable->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$groupId, ':catalog_id'=>$catNeeded));
        foreach($rels as $r)
        {
            $setId = $r->getAttribute('set_id');
            $tableGroupSet = new CurrGroupBySet();
            $exist = $tableGroupSet->find('group_id=:group_id AND catalog_id=:catalog_id AND set_id=:set_id', array(':group_id'=>$groupId, ':catalog_id'=>$catalogNumber, ':set_id'=>$setId));
            if ( !$exist )
            {
                $tableGroupSet = new CurrGroupBySet();
                $tableGroupSet->set_id = $setId;
                $tableGroupSet->group_id = $groupId;
                $tableGroupSet->catalog_id = $catalogNumber;
                $tableGroupSet->save();

                //updates set by course tables
                $this->updateSetByCourseTable($setId, $catalogNumber );
            }
        }
    }

    private function updateSetByCourseTable($setid, $catalogNumber)
    {
        $setByCourseTable = new CurrSetByCourse();
        $currSet = new CurrSet();
        //$catNeeded = $currSet->find('id=:id', array(':id'=>$setid))->getAttribute('catalog_id');
        $catNeeded = $this->getCatalogForSet($setid);
        $rels = $setByCourseTable->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setid, ':catalog_id'=>$catNeeded));
        foreach($rels as $r)
        {
            $courseId = $r->getAttribute('course_id');
            $tableSetCourse = new CurrSetByCourse();
            $exist = $tableSetCourse->find('set_id=:set_id AND catalog_id=:catalog_id AND course_id=:course_id', array(':set_id'=>$setid, ':catalog_id'=>$catalogNumber, ':course_id'=>$courseId));
            if ( !$exist )
            {
                $tableSetCourse = new CurrSetByCourse();
                $tableSetCourse->set_id = $setid;
                $tableSetCourse->course_id = $courseId;
                $tableSetCourse->catalog_id = $catalogNumber;
                $tableSetCourse->save();
            }
        }
    }

    private function saveNewTrackGroupRelation($groupName, $trackIdentifierID, $catalogID)
    {
        $groupModel = new CurrGroup();
        $trackGroupModel = new CurrTrackByGroup();
        $myGroup = $groupModel->find('name=:name', array(':name'=>$groupName));
        $groupIdentifierID = $myGroup->getAttribute('id');

        $exist = $trackGroupModel->find('track_id=:track_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':track_id' => $trackIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

        if ( !$exist )
        {
            $trackGroupModel = new CurrTrackByGroup();
            $trackGroupModel->group_id = $groupIdentifierID;
            $trackGroupModel->track_id = $trackIdentifierID;
            $trackGroupModel->catalog_id = $catalogID;
            $trackGroupModel->save();

            $this->updateGroupSetTable($groupIdentifierID, $catalogID);
        }
    }

    private function saveNewMinorGroupRelation($groupName, $minorIdentifierID, $catalogID)
    {
        $groupModel = new CurrGroup();
        $minorGroupModel = new CurrMinorGroup();
        $myGroup = $groupModel->find('name=:name', array(':name'=>$groupName));
        $groupIdentifierID = $myGroup->getAttribute('id');

        $exist = $minorGroupModel->find('minor_id=:minor_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':minor_id' => $minorIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

        if ( !$exist )
        {
            $trackGroupModel = new CurrMinorGroup();
            $trackGroupModel->group_id = $groupIdentifierID;
            $trackGroupModel->minor_id = $minorIdentifierID;
            $trackGroupModel->catalog_id = $catalogID;
            $trackGroupModel->save();

            $this->updateGroupSetTable($groupIdentifierID, $catalogID);
        }
    }

    private function saveNewCertificateGroupRelation($groupName, $certificateIdentifierID, $catalogID)
    {
        $groupModel = new CurrGroup();
        $certificateGroupModel = new CurrCertificateGroup();
        $myGroup = $groupModel->find('name=:name', array(':name'=>$groupName));
        $groupIdentifierID = $myGroup->getAttribute('id');

        $exist = $certificateGroupModel->find('certificate_id=:certificate_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':certificate_id' => $certificateIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

        if ( !$exist )
        {
            $trackGroupModel = new CurrCertificateGroup();
            $trackGroupModel->group_id = $groupIdentifierID;
            $trackGroupModel->certificate_id = $certificateIdentifierID;
            $trackGroupModel->catalog_id = $catalogID;
            $trackGroupModel->save();

            $this->updateGroupSetTable($groupIdentifierID, $catalogID);
        }
    }

    private function saveNewGroupSetRelation($setName, $groupIdentifierID, $catalogID)
    {
        $setModel = new CurrSet();
        $groupSetModel = new CurrGroupBySet();
        $mySet = $setModel->find('name=:name', array(':name'=>$setName));
        $setIdentifierID = $mySet->getAttribute('id');

        $exist = $groupSetModel->find('set_id=:set_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':set_id' => $setIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

        if ( !$exist )
        {
            $groupSetModel = new CurrGroupBySet();
            $groupSetModel->group_id = $groupIdentifierID;
            $groupSetModel->set_id = $setIdentifierID;
            $groupSetModel->catalog_id = $catalogID;
            $groupSetModel->save();

            $this->updateSetByCourseTable($setIdentifierID, $catalogID);
        }
    }

    private function saveNewSetCourseRelation($courseName, $setIdentifierID, $catalogID )
    {
        $courseModel = new CurrCourse();
        $setCourseModel = new CurrSetByCourse();
        $myCourse = $courseModel->find('name=:name', array(':name'=>$courseName));
        $courseIdentifierID = $myCourse->getAttribute('id');

        $exist = $setCourseModel->find('set_id=:set_id AND course_id=:course_id AND catalog_id=:catalog_id', array(':set_id' => $setIdentifierID, ':course_id' => $courseIdentifierID, ':catalog_id' => $catalogID));

        if ( !$exist )
        {
            $setCourseModel = new CurrSetByCourse();
            $setCourseModel->course_id = $courseIdentifierID;
            $setCourseModel->set_id = $setIdentifierID;
            $setCourseModel->catalog_id = $catalogID;
            $setCourseModel->save();
        }
    }

    //gets the latest catalog active for the set
    private function getCatalogForSet($setIdentifierID)
    {
        $hisSet = new HisSet();
        $catNeeded = 0;
        $theseVersions = $hisSet->findAll('identifier_id=:identifier_id', array(':identifier_id'=>$setIdentifierID));
        foreach($theseVersions as $version)
        {
            $currentActive = $catNeeded;
            $currentCat = $version->getAttribute('catalog_id');
            if (  $currentCat > $currentActive)
            {
                $catNeeded = $currentCat;
            }
            else
            {
                $catNeeded = $currentActive;
            }
        }
        return $catNeeded;
    }

    //gets the latest catalog active for the group
    private function getCatalogForGroup($groupIdentifierID)
    {
        $hisGroup = new HisGroup();
        $catNeeded = 0;
        $theseVersions = $hisGroup->findAll('identifier_id=:identifier_id', array(':identifier_id'=>$groupIdentifierID));
        foreach($theseVersions as $version)
        {
            $currentActive = $catNeeded;
            $currentCat = $version->getAttribute('catalog_id');
            if (  $currentCat > $currentActive)
            {
                $catNeeded = $currentCat;
            }
            else
            {
                $catNeeded = $currentActive;
            }
        }
        return $catNeeded;
    }

    private function getCatalogForTrack($trackIdentifierID)
    {
        $hisTrack = new HisTrack();
        $catNeeded = 0;
        $theseVersions = $hisTrack->findAll('identifier_id=:identifier_id', array(':identifier_id'=>$trackIdentifierID));
        foreach($theseVersions as $version)
        {
            $currentActive = $catNeeded;
            $currentCat = $version->getAttribute('catalog_id');
            if (  $currentCat > $currentActive)
            {
                $catNeeded = $currentCat;
            }
            else
            {
                $catNeeded = $currentActive;
            }
        }
        return $catNeeded;
    }

    private function getCatalogForMinor($minorIdentifierID)
    {
        $hisMinor = new HisMinor();
        $catNeeded = 0;
        $theseVersions = $hisMinor->findAll('identifier_id=:identifier_id', array(':identifier_id'=>$minorIdentifierID));
        foreach($theseVersions as $version)
        {
            $currentActive = $catNeeded;
            $currentCat = $version->getAttribute('catalog_id');
            if (  $currentCat > $currentActive)
            {
                $catNeeded = $currentCat;
            }
            else
            {
                $catNeeded = $currentActive;
            }
        }
        return $catNeeded;
    }

    private function getCatalogForCertificate($certificateIdentifierID)
    {
        $hisCertificate = new HisCertificate();
        $catNeeded = 0;
        $theseVersions = $hisCertificate->findAll('identifier_id=:identifier_id', array(':identifier_id'=>$certificateIdentifierID));
        foreach($theseVersions as $version)
        {
            $currentActive = $catNeeded;
            $currentCat = $version->getAttribute('catalog_id');
            if (  $currentCat > $currentActive)
            {
                $catNeeded = $currentCat;
            }
            else
            {
                $catNeeded = $currentActive;
            }
        }
        return $catNeeded;
    }


    /*MAJOR functions*/
    public function actionAddTrackMajor()
    {
        $major = new CurrMajor();
        $track = new CurrTrack();
        $majorByTrack = new CurrMajorByTrack();

        $myMajor = $_GET['major'];
        $myTrack = $_GET['track'];
        $catalogId = $_GET['catalogId'];


        $majorID = $major->find('name=:name', array(':name'=>$myMajor));
        $trackID = $track->find('name=:name', array(':name'=>$myTrack));


        $mIDs = $majorID->getAttribute('id');
        $tIDs = $trackID->getAttribute('id');

        $majorByTrack->major_id = $mIDs;
        $majorByTrack->track_id = $tIDs;
        $majorByTrack->catalog_id = $catalogId;
        $majorByTrack->save();

        $this->updateTrackGroupTable($tIDs, $catalogId);

    }

    public function actionRetrieveMajorFields()
    {
        $major = new CurrMajor();
        $majorInfo = new HisMajor();

        //name of course being passed
        $myMajor = $_GET['mymajor'];

        $mID = $major->find('name=:name', array(':name'=>$myMajor));

        //get id of the course
        $myMajorID = $mID->getAttribute('id');

        //get info for course from db based on id
        $sInfo = $majorInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myMajorID));

        $return = $_GET;

        //get name of the prefix id
        $return["myMajorDescription"] = $sInfo->getAttribute('description');                 //eg COP

        echo json_encode($return);
    }

    public function actionSaveNewMajor()
    {
        $majorModel = new CurrMajor();
        $majorTrackModel = new CurrMajorByTrack();
        $majorInfoModel = new HisMajor();
        $trackModel = new CurrTrack();
        $dguModel = new CurrDgu();

        $major = $_GET['name'];
        $description = $_GET['description'];
        $novals = $_GET['novals'];
        $catalogID = $_GET['catalogID'];
        $dgu = $_GET['dgu'];

        //save new set in currcertificate
        $majorModel->name = $major;
        $majorModel->catalog_id = $catalogID;
        $majorModel->save();

        //get id of the track inserted in the table
        $myMajor = $majorModel->find('name=:name', array(':name'=>$major));
        $majorIdentifierID = $myMajor->getAttribute('id');

        $myDgu = $dguModel->find('name=:name', array(':name'=>$dgu));
        $dguIdentifierID = $myDgu->getAttribute('id');

        $majorInfoModel->description = $description;
        $majorInfoModel->identifier_id = $majorIdentifierID;
        $majorInfoModel->catalog_id = $catalogID;
        $majorInfoModel->dgu_id = $dguIdentifierID;
        $majorInfoModel->majorType_id = 1;
        $majorInfoModel->save();

        //insert each relation if needed to be inserted
        for ( $i = 0; $i < $novals; $i++)
        {
            $track = $_GET['element'.$i];
            $myTrack = $trackModel->find('name=:name', array(':name'=>$track));
            $trackIdentifierID = $myTrack->getAttribute('id');

            $exist = $majorTrackModel->find('major_id=:major_id AND track_id=:track_id AND catalog_id=:catalog_id', array(':major_id' => $majorIdentifierID, ':track_id' => $trackIdentifierID, ':catalog_id' => $catalogID));

            if ( !$exist )
            {
                $majorTrackModel = new CurrMajorByTrack();
                $majorTrackModel->track_id = $trackIdentifierID;
                $majorTrackModel->major_id = $majorIdentifierID;
                $majorTrackModel->catalog_id = $catalogID;
                $majorTrackModel->save();
            }
            continue;
        }
    }

    public function actionUpdateMajor()
    {
        $majorModel = new CurrMajor();
        $majorInfoModel = new HisMajor();

        $major = $_GET['name'];
        $description = $_GET['description'];
        $catalogID = $_GET['catalogID'];
        $dgu = 1;
        $type = 1;

        //get id from currtrack table
        $myMajor = $majorModel->find('name=:name', array(':name' => $major));
        $majorIdentifierID = $myMajor->getAttribute('id');

        $exist = $majorInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $majorIdentifierID));

        if ($exist) {
            HisMajor::model()->updateByPk($exist->getAttribute('id'), array(
                'description' => $description,
                'identifier_id' => $majorIdentifierID,
                'catalog_id' => $catalogID,
                'dgu_id' => $majorIdentifierID,
                'majorType_id' => $catalogID,
            ));
        } else {
            $majorInfoModel->description = $description;
            $majorInfoModel->identifier_id = $majorIdentifierID;
            $majorInfoModel->catalog_id = $catalogID;
            $majorInfoModel->majorType_id = $type;
            $majorInfoModel->dgu_id = $dgu;
            $majorInfoModel->save();
        }
    }

    public function actionRemoveTrackMajor()
    {
        $major = new CurrMajor();
        $track = new CurrTrack();
        $majorByTrack = new CurrMajorByTrack();

        $myMajor = $_GET['major'];
        $myTrack = $_GET['track'];
        $myCatalog = $_GET['catalogId'];


        $majorID = $major->find('name=:name', array(':name'=>$myMajor));
        $trackID = $track->find('name=:name', array(':name'=>$myTrack));


        $mIDs = $majorID->getAttribute('id');
        $tIDs = $trackID->getAttribute('id');

        $command = Yii::app()->db->createCommand();

        $sql='DELETE FROM curr_major_track WHERE major_id=:major_id AND track_id=:track_id AND catalog_id=:catalog_id';
        $params = array(
            "major_id" => $mIDs,
            "track_id" => $tIDs,
            "catalog_id"=>$myCatalog
        );
        $command->setText($sql)->execute($params);
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('RemoveTrackMajor',array('model'=>$model,
            'major'=>$major,
            'track'=>$track,
            'majorByTrack'=>$relMajorTrack),false, true);*/
    }
    /*end major function*/


    /*MINOR functions*/

    public function actionRetrieveMinorFields()
    {
        $minor = new CurrMinor();
        $minorInfo = new HisMinor();

        //name of course being passed
        $myMinor = $_GET['myminor'];

        $mID = $minor->find('name=:name', array(':name'=>$myMinor));

        //get id of the course
        $myMinorID = $mID->getAttribute('id');

        //get info for course from db based on id
        $sInfo = $minorInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myMinorID));

        $return = $_GET;

        //get name of the prefix id
        $return["myMinorDescription"] = $sInfo->getAttribute('description');                 //eg COP
        $return["myMinorMinCredits"] = $sInfo->getAttribute('minCredits');

        echo json_encode($return);
    }

    public function actionSaveNewMinor()
    {
        $minorModel = new CurrMinor();
        $minorGroupModel = new CurrMinorGroup();
        $minorInfoModel = new HisMinor();
        $groupModel = new CurrGroup();

        $minor = $_GET['name'];
        $description = $_GET['description'];
        $novals = $_GET['novals'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //save new set in currcertificate
        $minorModel->name = $minor;
        $minorModel->catalog_id = $catalogID;
        $minorModel->save();

        //get id of the track inserted in the table
        $myMinor = $minorModel->find('name=:name', array(':name'=>$minor));
        $minorIdentifierID = $myMinor->getAttribute('id');

        $minorInfoModel->description = $description;
        $minorInfoModel->minCredits = $mincredits;
        $minorInfoModel->identifier_id = $minorIdentifierID;
        $minorInfoModel->catalog_id = $catalogID;
        $minorInfoModel->save();

        //insert each relation if needed to be inserted
        for ( $i = 0; $i < $novals; $i++)
        {

            $group = $_GET['element'.$i];
            $this->saveNewMinorGroupRelation($group, $minorIdentifierID, $catalogID);
           /* $myGroup = $groupModel->find('name=:name', array(':name'=>$group));
            $groupIdentifierID = $myGroup->getAttribute('id');

            $exist = $minorGroupModel->find('minor_id=:minor_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':minor_id' => $minorIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

            if ( !$exist )
            {
                $minorGroupModel = new CurrMinorGroup();
                $minorGroupModel->group_id = $groupIdentifierID;
                $minorGroupModel->minor_id = $minorIdentifierID;
                $minorGroupModel->catalog_id = $catalogID;
                $minorGroupModel->save();

                $catFlagGroup = false;
                $catNeeded = 0;

                $catalog = new Catalog();
                $allActiveCatalogs = $catalog->findAll('activated=:activated', array(':activated'=>1));
                //get lattest version in which set was active so that it can be copied
                foreach($allActiveCatalogs as $cat)
                {
                    $checkCatId = $cat->getAttribute('id');
                    $historyGroup = new HisGroup();
                    $lastversionGroup = $historyGroup->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id'=>$checkCatId, ':identifier_id'=>$groupIdentifierID));

                    if ( $lastversionGroup && $catFlagGroup == false)
                    {
                        $catFlag = true;
                        $catNeeded = $checkCatId;
                    }
                }

                $GroupRelations = new CurrGroupBySet();
                //find all sets related to the current group val
                $currentGroupRels = $GroupRelations->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$groupIdentifierID, ':catalog_id'=>$catNeeded));
                //for each relation verify if it already exist with prospective catalog id
                foreach($currentGroupRels as $groupRel)
                {
                    $setIdentifierID = $groupRel->getAttribute('set_id');
                    $thisGroupRel = new CurrGroupBySet();
                    $thisGroupRelExist = $thisGroupRel->find('set_id=:set_id AND catalog_id=:catalog_id AND group_id=:group_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':group_id'=>$groupIdentifierID));
                    if(!$thisGroupRelExist)
                    {
                        //save current relation
                        $saveNewGroupRel = new CurrGroupBySet();
                        $saveNewGroupRel->group_id = $groupIdentifierID;
                        $saveNewGroupRel->catalog_id = $catalogID;
                        $saveNewGroupRel->set_id = $setIdentifierID;
                        $saveNewGroupRel->save();

                        //look for relation of set and course and check whethere it exist in the prospective catalog otherwise create a new relation
                        $SetRelations = new CurrSetByCourse();
                        $currentSetRels = $SetRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catNeeded));
                        foreach($currentSetRels as $setRel)
                        {
                            $thisSetRel = new CurrSetByCourse();
                            //check if the relation exist in the prospective catalog
                            $thisSetRelExist = $thisSetRel->find('set_id=:set_id AND catalog_id=:catalog_id AND course_id=:course_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':course_id'=>$setRel->getAttribute('course_id')));
                            if(!$thisSetRelExist)
                            {
                                $saveNewSetRel = new CurrSetByCourse();
                                $saveNewSetRel->course_id = $setRel->getAttribute('course_id');
                                $saveNewSetRel->catalog_id = $catalogID;
                                $saveNewSetRel->set_id = $setIdentifierID;
                                $saveNewSetRel->save();
                            }
                        }
                    }
                }
            }*/
            continue;
        }
    }

    public function actionUpdateMinor()
    {
        $minorModel = new CurrMinor();
        $minorInfoModel = new HisMinor();

        $minor = $_GET['name'];
        $description = $_GET['description'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //get id from currtrack table
        $myMinor = $minorModel->find('name=:name', array(':name' => $minor));
        $minorIdentifierID = $myMinor->getAttribute('id');

        $exist = $minorInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $minorIdentifierID));

        if ($exist) {
            HisMinor::model()->updateByPk($exist->getAttribute('id'), array(
                'minCredits' => $mincredits,
                'description' => $description,
                'identifier_id' => $minorIdentifierID,
                'catalog_id' => $catalogID,
            ));
        } else {
            $minorInfoModel->description = $description;
            $minorInfoModel->minCredits = $mincredits;
            $minorInfoModel->identifier_id = $minorIdentifierID;
            $minorInfoModel->catalog_id = $catalogID;
            $minorInfoModel->save();
        }
        $haveMinorRelation = new CurrMinorGroup();
        $myMinorRelations = $haveMinorRelation->findAll('minor_id=:minor_id AND catalog_id=:catalog_id', array(':minor_id'=>$minorIdentifierID, ':catalog_id'=>$catalogID));

        if ( !$myMinorRelations)
        {
            $catalog = new Catalog();
            $allCatalogs = $catalog->findAll('activated=:activated', array(':activated' => 1));
            $lastactiveCatalog = 0;
            //checks for the last active catalog
            foreach ($allCatalogs as $active) {
                $lastactiveCatalog = $active->getAttribute('id');
            }

            $trackRelation = new CurrMinorGroup();
            $theseTrackRelations = $trackRelation->findAll('minor_id=:minor_id AND catalog_id=:catalog_id', array(':minor_id' => $minorIdentifierID, ':catalog_id' => $lastactiveCatalog));
            foreach($theseTrackRelations as $trackrel)
            {
                $newRelation = new CurrMinorGroup();
                $newRelation->group_id = $trackrel->group_id;
                $newRelation->minor_id = $trackrel->minor_id;
                $newRelation->catalog_id = $catalogID;
                $newRelation->save();

                $haveGroupRelation = new CurrGroupBySet();
                $myGroupRelation = $haveGroupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$trackrel->group_id, ':catalog_id'=>$catalogID));

                if(!$myGroupRelation)
                {
                    $groupRelation = new CurrGroupBySet();
                    $theseGroupRelations = $groupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id' => $trackrel->group_id, ':catalog_id' => $lastactiveCatalog));
                    foreach ($theseGroupRelations as $relation) {
                        $newRelation = new CurrGroupBySet();
                        $newRelation->group_id = $relation->group_id;
                        $newRelation->set_id = $relation->set_id;
                        $newRelation->catalog_id = $catalogID;
                        $newRelation->save();

                        //for each set pertaining to the group update it too
                        $setRelations = new CurrSetByCourse();
                        $mySetRelations = $setRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$relation->set_id, ':catalog_id'=>$catalogID));
                        //if user has not changes in the set copy current active to user prospective catalog
                        if ( !$mySetRelations) {
                            //copy current relations to the table

                            $relations = new CurrSetByCourse();
                            $theseRelations = $relations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id' => $relation->set_id, ':catalog_id' => $lastactiveCatalog));
                            //copy relations of the active catalog to prospective catalog
                            foreach ($theseRelations as $relationSet) {
                                $newRelation = new CurrSetByCourse();
                                $newRelation->course_id = $relationSet->course_id;
                                $newRelation->set_id = $relationSet->set_id;
                                $newRelation->catalog_id = $catalogID;
                                $newRelation->save();
                            }
                        }

                    }
                }
            }
        }
    }

    public function actionRemoveGroupMinor()
    {
        $minor = new CurrMinor();
        $group = new CurrGroup();
        $trackByGroup = new CurrTrackByGroup();

        $myMinor = $_GET['minor'];
        $myGroup = $_GET['group'];
        $myCatalogId = $_GET['catalogId'];


        $minorID = $minor->find('name=:name', array(':name'=>$myMinor));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $mIDs = $minorID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_minor_group WHERE minor_id=:minor_id AND group_id=:group_id AND catalog_id=:catalog_id';
        $params = array(
            "minor_id" => $mIDs,
            "group_id" => $gIDs,
            "catalog_id"=>$myCatalogId
        );
        $command->setText($sql)->execute($params);
    }

    public function actionAddGroupMinor()
    {
        $group = new CurrGroup();
        $minor = new CurrMinor();
        $minorByGroup = new CurrMinorGroup();

        $myMinor = $_GET['minor'];
        $myGroup = $_GET['group'];
        $myCatalogId = $_GET['catalogId'];

        $minorID = $minor->find('name=:name', array(':name'=>$myMinor));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $tIDs = $minorID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $minorByGroup->minor_id = $tIDs;
        $minorByGroup->group_id = $gIDs;
        $minorByGroup->catalog_id = $myCatalogId;
        $minorByGroup->save();

        $this->updateGroupSetTable($gIDs, $myCatalogId);
    }


    /*end minor function*/


    /*CERTIFICATE functions*/

    public function actionRetrieveCertificateFields()
    {
        $certificate = new CurrCertificate();
        $certificateInfo = new HisCertificate();

        //name of course being passed
        $myCertificate = $_GET['mycertificate'];

        $cID = $certificate->find('name=:name', array(':name'=>$myCertificate));

        //get id of the course
        $myCertificateID = $cID->getAttribute('id');

        //get info for course from db based on id
        $cInfo = $certificateInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myCertificateID));

        $return = $_GET;

        //get name of the prefix id
        $return["myCertificateDescription"] = $cInfo->getAttribute('description');                 //eg COP
        $return["myCertificateMinCredits"] = $cInfo->getAttribute('minCredits');

        echo json_encode($return);
    }

    public function actionSaveNewCertificate()
    {
        $certificateModel = new CurrCertificate();
        $certificateGroupModel = new CurrCertificateGroup();
        $certificateInfoModel = new HisCertificate();
        $groupModel = new CurrGroup();

        $certificate = $_GET['name'];
        $description = $_GET['description'];
        $novals = $_GET['novals'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //save new set in currcertificate
        $certificateModel->name = $certificate;
        $certificateModel->catalog_id = $catalogID;
        $certificateModel->save();

        //get id of the track inserted in the table
        $myCertificate = $certificateModel->find('name=:name', array(':name'=>$certificate));
        $certificateIdentifierID = $myCertificate->getAttribute('id');

        $certificateInfoModel->description = $description;
        $certificateInfoModel->minCredits = $mincredits;
        $certificateInfoModel->identifier_id = $certificateIdentifierID;
        $certificateInfoModel->catalog_id = $catalogID;
        $certificateInfoModel->save();

        //insert each relation if needed to be inserted
        for ( $i = 0; $i < $novals; $i++)
        {

            $group = $_GET['element'.$i];
            $this->saveNewCertificateGroupRelation($group, $certificateIdentifierID, $catalogID);
            /*$myGroup = $groupModel->find('name=:name', array(':name'=>$group));
            $groupIdentifierID = $myGroup->getAttribute('id');

            $exist = $certificateGroupModel->find('certificate_id=:certificate_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':certificate_id' => $certificateIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

            if ( !$exist )
            {
                $certificateGroupModel = new CurrCertificateGroup();
                $certificateGroupModel->group_id = $groupIdentifierID;
                $certificateGroupModel->certificate_id = $certificateIdentifierID;
                $certificateGroupModel->catalog_id = $catalogID;
                $certificateGroupModel->save();

                $catFlagGroup = false;
                $catNeeded = 0;

                $catalog = new Catalog();
                $allActiveCatalogs = $catalog->findAll('activated=:activated', array(':activated'=>1));
                //get lattest version in which set was active so that it can be copied
                foreach($allActiveCatalogs as $cat)
                {
                    $checkCatId = $cat->getAttribute('id');
                    $historyGroup = new HisGroup();
                    $lastversionGroup = $historyGroup->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id'=>$checkCatId, ':identifier_id'=>$groupIdentifierID));

                    if ( $lastversionGroup && $catFlagGroup == false)
                    {
                        $catFlag = true;
                        $catNeeded = $checkCatId;
                    }
                }

                $GroupRelations = new CurrGroupBySet();
                //find all sets related to the current group val
                $currentGroupRels = $GroupRelations->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$groupIdentifierID, ':catalog_id'=>$catNeeded));
                //for each relation verify if it already exist with prospective catalog id
                foreach($currentGroupRels as $groupRel)
                {
                    $setIdentifierID = $groupRel->getAttribute('set_id');
                    $thisGroupRel = new CurrGroupBySet();
                    $thisGroupRelExist = $thisGroupRel->find('set_id=:set_id AND catalog_id=:catalog_id AND group_id=:group_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':group_id'=>$groupIdentifierID));
                    if(!$thisGroupRelExist)
                    {
                        //save current relation
                        $saveNewGroupRel = new CurrGroupBySet();
                        $saveNewGroupRel->group_id = $groupIdentifierID;
                        $saveNewGroupRel->catalog_id = $catalogID;
                        $saveNewGroupRel->set_id = $setIdentifierID;
                        $saveNewGroupRel->save();

                        //look for relation of set and course and check whethere it exist in the prospective catalog otherwise create a new relation
                        $SetRelations = new CurrSetByCourse();
                        $currentSetRels = $SetRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catNeeded));
                        foreach($currentSetRels as $setRel)
                        {
                            $thisSetRel = new CurrSetByCourse();
                            //check if the relation exist in the prospective catalog
                            $thisSetRelExist = $thisSetRel->find('set_id=:set_id AND catalog_id=:catalog_id AND course_id=:course_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':course_id'=>$setRel->getAttribute('course_id')));
                            if(!$thisSetRelExist)
                            {
                                $saveNewSetRel = new CurrSetByCourse();
                                $saveNewSetRel->course_id = $setRel->getAttribute('course_id');
                                $saveNewSetRel->catalog_id = $catalogID;
                                $saveNewSetRel->set_id = $setIdentifierID;
                                $saveNewSetRel->save();
                            }
                        }
                    }
                }
            }*/
            continue;
        }
    }

    public function actionUpdateCertificate()
    {
        $certificateModel = new CurrCertificate();
        $certificateInfoModel = new HisCertificate();

        $certificate = $_GET['name'];
        $description = $_GET['description'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //get id from currtrack table
        $myCertificate = $certificateModel->find('name=:name', array(':name' => $certificate));
        $certificateIdentifierID = $myCertificate->getAttribute('id');

        $exist = $certificateInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $certificateIdentifierID));

        if ($exist) {
            HisCertificate::model()->updateByPk($exist->getAttribute('id'), array(
                'minCredits' => $mincredits,
                'description' => $description,
                'identifier_id' => $certificateIdentifierID,
                'catalog_id' => $catalogID,
            ));
        } else {
            $certificateInfoModel->description = $description;
            $certificateInfoModel->minCredits = $mincredits;
            $certificateInfoModel->identifier_id = $certificateIdentifierID;
            $certificateInfoModel->catalog_id = $catalogID;
            $certificateInfoModel->save();
        }
        $haveCertificateRelation = new CurrCertificateGroup();
        $myCertificateRelations = $haveCertificateRelation->findAll('certificate_id=:certificate_id AND catalog_id=:catalog_id', array(':certificate_id'=>$certificateIdentifierID, ':catalog_id'=>$catalogID));

        if ( !$myCertificateRelations)
        {
            $catalog = new Catalog();
            $allCatalogs = $catalog->findAll('activated=:activated', array(':activated' => 1));
            $lastactiveCatalog = 0;
            //checks for the last active catalog
            foreach ($allCatalogs as $active) {
                $lastactiveCatalog = $active->getAttribute('id');
            }

            $trackRelation = new CurrCertificateGroup();
            $theseTrackRelations = $trackRelation->findAll('certificate_id=:certificate_id AND catalog_id=:catalog_id', array(':certificate_id' => $certificateIdentifierID, ':catalog_id' => $lastactiveCatalog));
            foreach($theseTrackRelations as $trackrel)
            {
                $newRelation = new CurrCertificateGroup();
                $newRelation->group_id = $trackrel->group_id;
                $newRelation->certificate_id = $trackrel->certificate_id;
                $newRelation->catalog_id = $catalogID;
                $newRelation->save();

                $haveGroupRelation = new CurrGroupBySet();
                $myGroupRelation = $haveGroupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$trackrel->group_id, ':catalog_id'=>$catalogID));

                if(!$myGroupRelation)
                {
                    $groupRelation = new CurrGroupBySet();
                    $theseGroupRelations = $groupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id' => $trackrel->group_id, ':catalog_id' => $lastactiveCatalog));
                    foreach ($theseGroupRelations as $relation) {
                        $newRelation = new CurrGroupBySet();
                        $newRelation->group_id = $relation->group_id;
                        $newRelation->set_id = $relation->set_id;
                        $newRelation->catalog_id = $catalogID;
                        $newRelation->save();

                        //for each set pertaining to the group update it too
                        $setRelations = new CurrSetByCourse();
                        $mySetRelations = $setRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$relation->set_id, ':catalog_id'=>$catalogID));
                        //if user has not changes in the set copy current active to user prospective catalog
                        if ( !$mySetRelations) {
                            //copy current relations to the table

                            $relations = new CurrSetByCourse();
                            $theseRelations = $relations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id' => $relation->set_id, ':catalog_id' => $lastactiveCatalog));
                            //copy relations of the active catalog to prospective catalog
                            foreach ($theseRelations as $relationSet) {
                                $newRelation = new CurrSetByCourse();
                                $newRelation->course_id = $relationSet->course_id;
                                $newRelation->set_id = $relationSet->set_id;
                                $newRelation->catalog_id = $catalogID;
                                $newRelation->save();
                            }
                        }

                    }
                }
            }
        }
    }

    public function actionRemoveGroupCertificate()
    {
        $ceritificate = new CurrCertificate();
        $group = new CurrGroup();
        $certificateByGroup = new CurrCertificateGroup();

        $myCertificate = $_GET['certificate'];
        $myGroup = $_GET['group'];
        $myCatalogId = $_GET['catalogId'];


        $certificateID = $ceritificate->find('name=:name', array(':name'=>$myCertificate));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $cIDs = $certificateID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_certificate_group WHERE certificate_id=:certificate_id AND group_id=:group_id AND catalog_id=:catalog_id';
        $params = array(
            "certificate_id" => $cIDs,
            "group_id" => $gIDs,
            "catalog_id"=>$myCatalogId
        );
        $command->setText($sql)->execute($params);
    }

    public function actionAddGroupCertificate()
    {
        $group = new CurrGroup();
        $certificate = new CurrCertificate();
        $certificateByGroup = new CurrCertificateGroup();

        $myCertificate = $_GET['certificate'];
        $myGroup = $_GET['group'];
        $myCatalogId = $_GET['catalogId'];

        $certificateID = $certificate->find('name=:name', array(':name'=>$myCertificate));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $tIDs = $certificateID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $certificateByGroup->certificate_id = $tIDs;
        $certificateByGroup->group_id = $gIDs;
        $certificateByGroup->catalog_id = $myCatalogId;
        $certificateByGroup->save();

        $this->updateGroupSetTable($gIDs, $myCatalogId);
    }

    /*end certificate function*/


    /*TRACK functions*/
    public function actionAddGroupTrack()
    {
        $track = new CurrTrack();
        $group = new CurrGroup();
        $trackByGroup = new CurrTrackByGroup();

        $myTrack = $_GET['track'];
        $myGroup = $_GET['group'];
        $myCatalogId = $_GET['catalogId'];

        $trackID = $track->find('name=:name', array(':name'=>$myTrack));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $tIDs = $trackID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $trackByGroup->track_id = $tIDs;
        $trackByGroup->group_id = $gIDs;
        $trackByGroup->catalog_id = $myCatalogId;
        $trackByGroup->save();

        $this->updateGroupSetTable($gIDs, $myCatalogId);
    }

    public function actionSaveNewTrack()
    {
        $trackModel = new CurrTrack();
        $trackGroupModel = new CurrTrackByGroup();
        $trackInfoModel = new HisTrack();
        $groupModel = new CurrGroup();

        $track = $_GET['name'];
        $description = $_GET['description'];
        $novals = $_GET['novals'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //save new set in currtrack
        $trackModel->name = $track;
        $trackModel->catalog_id = $catalogID;
        $trackModel->save();

        //get id of the track inserted in the table
        $myTrack = $trackModel->find('name=:name', array(':name'=>$track));
        $trackIdentifierID = $myTrack->getAttribute('id');

        $trackInfoModel->description = $description;
        $trackInfoModel->minCredits = $mincredits;
        $trackInfoModel->identifier_id = $trackIdentifierID;
        $trackInfoModel->catalog_id = $catalogID;
        $trackInfoModel->save();

        //insert each relation if needed to be inserted
        for ( $i = 0; $i < $novals; $i++)
        {
            $group = $_GET['element'.$i];
            //$myGroup = $groupModel->find('name=:name', array(':name'=>$group))->getAttribute('name');
            $this->saveNewTrackGroupRelation($group, $trackIdentifierID, $catalogID);
            /*$groupIdentifierID = $myGroup->getAttribute('id');

            $exist = $trackGroupModel->find('track_id=:track_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':track_id' => $trackIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

            if ( !$exist )
            {
                $trackGroupModel = new CurrTrackByGroup();
                $trackGroupModel->group_id = $groupIdentifierID;
                $trackGroupModel->track_id = $trackIdentifierID;
                $trackGroupModel->catalog_id = $catalogID;
                $trackGroupModel->save();

                $catFlagGroup = false;
                $catNeeded = 0;

                $catalog = new Catalog();
                $allActiveCatalogs = $catalog->findAll('activated=:activated', array(':activated'=>1));
                //get lattest version in which set was active so that it can be copied
                foreach($allActiveCatalogs as $cat)
                {
                    $checkCatId = $cat->getAttribute('id');
                    $historyGroup = new HisGroup();
                    $lastversionGroup = $historyGroup->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id'=>$checkCatId, ':identifier_id'=>$groupIdentifierID));

                    if ( $lastversionGroup && $catFlagGroup == false)
                    {
                        $catFlag = true;
                        $catNeeded = $checkCatId;
                    }
                }

                $GroupRelations = new CurrGroupBySet();
                //find all sets related to the current group val
                $currentGroupRels = $GroupRelations->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$groupIdentifierID, ':catalog_id'=>$catNeeded));
                //for each relation verify if it already exist with prospective catalog id
                foreach($currentGroupRels as $groupRel)
                {
                    $setIdentifierID = $groupRel->getAttribute('set_id');
                    $thisGroupRel = new CurrGroupBySet();
                    $thisGroupRelExist = $thisGroupRel->find('set_id=:set_id AND catalog_id=:catalog_id AND group_id=:group_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':group_id'=>$groupIdentifierID));
                    if(!$thisGroupRelExist)
                    {
                        //save current relation
                        $saveNewGroupRel = new CurrGroupBySet();
                        $saveNewGroupRel->group_id = $groupIdentifierID;
                        $saveNewGroupRel->catalog_id = $catalogID;
                        $saveNewGroupRel->set_id = $setIdentifierID;
                        $saveNewGroupRel->save();

                        //look for relation of set and course and check whethere it exist in the prospective catalog otherwise create a new relation
                        $SetRelations = new CurrSetByCourse();
                        $currentSetRels = $SetRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catNeeded));
                        foreach($currentSetRels as $setRel)
                        {
                            $thisSetRel = new CurrSetByCourse();
                            //check if the relation exist in the prospective catalog
                            $thisSetRelExist = $thisSetRel->find('set_id=:set_id AND catalog_id=:catalog_id AND course_id=:course_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':course_id'=>$setRel->getAttribute('course_id')));
                            if(!$thisSetRelExist)
                            {
                                $saveNewSetRel = new CurrSetByCourse();
                                $saveNewSetRel->course_id = $setRel->getAttribute('course_id');
                                $saveNewSetRel->catalog_id = $catalogID;
                                $saveNewSetRel->set_id = $setIdentifierID;
                                $saveNewSetRel->save();
                            }
                        }
                    }
                }
            }*/
            continue;
        }
    }

    public function actionRemoveGroupTrack()
    {
        $track = new CurrTrack();
        $group = new CurrGroup();
        $trackByGroup = new CurrTrackByGroup();

        $myTrack = $_GET['track'];
        $myGroup = $_GET['group'];
        $myCatalogId = $_GET['catalogId'];


        $trackID = $track->find('name=:name', array(':name'=>$myTrack));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $tIDs = $trackID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_track_group WHERE track_id=:track_id AND group_id=:group_id AND catalog_id=:catalog_id';
        $params = array(
            "track_id" => $tIDs,
            "group_id" => $gIDs,
            "catalog_id"=>$myCatalogId
        );
        $command->setText($sql)->execute($params);
    }

    public function actionRetrieveTrackFields()
    {
        $track = new CurrTrack();
        $trackInfo = new HisTrack();

        //name of course being passed
        $myTrack = $_GET['mytrack'];

        $tID = $track->find('name=:name', array(':name'=>$myTrack));

        //get id of the course
        $myTrackID = $tID->getAttribute('id');

        //get info for course from db based on id
        $tInfo = $trackInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myTrackID));

        $return = $_GET;

        //get name of the prefix id
        $return["myTrackDescription"] = $tInfo->getAttribute('description');                 //eg COP
        $return["myTrackMinCredits"] = $tInfo->getAttribute('minCredits');

        echo json_encode($return);
    }

    public function actionUpdateTrack()
    {
        $trackModel = new CurrTrack();
        $trackInfoModel = new HisTrack();

        $track = $_GET['name'];
        $description = $_GET['description'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //get id from currtrack table
        $myTrack = $trackModel->find('name=:name', array(':name' => $track));
        $trackIdentifierID = $myTrack->getAttribute('id');

        $exist = $trackInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $trackIdentifierID));

        if ($exist) {
            HisTrack::model()->updateByPk($exist->getAttribute('id'), array(
                'minCredits' => $mincredits,
                'description' => $description,
                'identifier_id' => $trackIdentifierID,
                'catalog_id' => $catalogID,
            ));
        } else {
            $trackInfoModel->description = $description;
            $trackInfoModel->minCredits = $mincredits;
            $trackInfoModel->identifier_id = $trackIdentifierID;
            $trackInfoModel->catalog_id = $catalogID;
            $trackInfoModel->save();
        }

        $haveTrackRelation = new CurrTrackByGroup();
        $myTrackRelations = $haveTrackRelation->findAll('track_id=:track_id AND catalog_id=:catalog_id', array(':track_id'=>$trackIdentifierID, ':catalog_id'=>$catalogID));

        if ( !$myTrackRelations)
        {
            $catalog = new Catalog();
            $allCatalogs = $catalog->findAll('activated=:activated', array(':activated' => 1));
            $lastactiveCatalog = 0;
            //checks for the last active catalog
            foreach ($allCatalogs as $active) {
                $lastactiveCatalog = $active->getAttribute('id');
            }

            $trackRelation = new CurrTrackByGroup();
            $theseTrackRelations = $trackRelation->findAll('track_id=:track_id AND catalog_id=:catalog_id', array(':track_id' => $trackIdentifierID, ':catalog_id' => $lastactiveCatalog));
            foreach($theseTrackRelations as $trackrel)
            {
                $newRelation = new CurrTrackByGroup();
                $newRelation->group_id = $trackrel->group_id;
                $newRelation->track_id = $trackrel->track_id;
                $newRelation->catalog_id = $catalogID;
                $newRelation->save();

                $haveGroupRelation = new CurrGroupBySet();
                $myGroupRelation = $haveGroupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$trackrel->group_id, ':catalog_id'=>$catalogID));

                if(!$myGroupRelation)
                {
                    $groupRelation = new CurrGroupBySet();
                    $theseGroupRelations = $groupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id' => $trackrel->group_id, ':catalog_id' => $lastactiveCatalog));
                    foreach ($theseGroupRelations as $relation) {
                        $newRelation = new CurrGroupBySet();
                        $newRelation->group_id = $relation->group_id;
                        $newRelation->set_id = $relation->set_id;
                        $newRelation->catalog_id = $catalogID;
                        $newRelation->save();

                        //for each set pertaining to the group update it too
                        $setRelations = new CurrSetByCourse();
                        $mySetRelations = $setRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$relation->set_id, ':catalog_id'=>$catalogID));
                        //if user has not changes in the set copy current active to user prospective catalog
                        if ( !$mySetRelations) {
                            //copy current relations to the table

                            $relations = new CurrSetByCourse();
                            $theseRelations = $relations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id' => $relation->set_id, ':catalog_id' => $lastactiveCatalog));
                            //copy relations of the active catalog to prospective catalog
                            foreach ($theseRelations as $relationSet) {
                                $newRelation = new CurrSetByCourse();
                                $newRelation->course_id = $relationSet->course_id;
                                $newRelation->set_id = $relationSet->set_id;
                                $newRelation->catalog_id = $catalogID;
                                $newRelation->save();
                            }
                        }

                    }
                }
            }
        }
    }
    /*end track function*/


    /*GROUP functions*/
    public function actionAddSetGroup()
    {
        $set = new CurrSet();
        $group = new CurrGroup();
        $groupBySet = new CurrGroupBySet();

        $mySet = $_GET['set'];
        $myGroup = $_GET['group'];
        $catalogId = $_GET['catalogId'];


        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $sIDs = $setID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $groupBySet->set_id = $sIDs;
        $groupBySet->group_id = $gIDs;
        $groupBySet->catalog_id = $catalogId;
        $groupBySet->save();

        $this->updateSetByCourseTable($sIDs, $catalogId);

    }

    public function actionSaveNewGroup()
    {
        $groupModel = new CurrGroup();
        $groupSetModel = new CurrGroupBySet();
        $groupInfoModel = new HisGroup();
        $setModel = new CurrSet();

        $group = $_GET['name'];
        $description = $_GET['description'];
        $novals = $_GET['novals'];
        $maxcredits = $_GET['maxcredits'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //save new set in currgroup
        $groupModel->name = $group;
        $groupModel->catalog_id = $catalogID;
        $groupModel->save();

        //get id of the set inserted in the table
        $myGroup = $groupModel->find('name=:name', array(':name'=>$group));
        $groupIdentifierID = $myGroup->getAttribute('id');

        $groupInfoModel->description = $description;
        $groupInfoModel->minCredits = $mincredits;
        $groupInfoModel->maxCredits = $maxcredits;
        $groupInfoModel->identifier_id = $groupIdentifierID;
        $groupInfoModel->catalog_id = $catalogID;
        $groupInfoModel->save();

        //insert each relation if needed to be inserted
        for ( $i = 0; $i < $novals; $i++)
        {
            $set = $_GET['element'.$i];
            $this->saveNewGroupSetRelation($set, $groupIdentifierID, $catalogID);
            /*$mySet = $setModel->find('name=:name', array(':name'=>$set));
            $setIdentifierID = $mySet->getAttribute('id');

            $exist = $groupSetModel->find('set_id=:set_id AND group_id=:group_id AND catalog_id=:catalog_id', array(':set_id' => $setIdentifierID, ':group_id' => $groupIdentifierID, ':catalog_id' => $catalogID));

            if ( !$exist )
            {
                $groupSetModel = new CurrGroupBySet();
                $groupSetModel->group_id = $groupIdentifierID;
                $groupSetModel->set_id = $setIdentifierID;
                $groupSetModel->catalog_id = $catalogID;
                $groupSetModel->save();

                $catFlag = false;
                $catNeeded = 0;

                $catalog = new Catalog();
                $allActiveCatalogs = $catalog->findAll('activated=:activated', array(':activated'=>1));
                //get lattest version in which set was active so that it can be copied
                foreach($allActiveCatalogs as $cat)
                {
                    $checkCatId = $cat->getAttribute('id');
                    $historySet = new HisSet();
                    $lastversion = $historySet->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id'=>$checkCatId, ':identifier_id'=>$setIdentifierID));

                    if ( $lastversion && $catFlag == false)
                    {
                        $catFlag = true;
                        $catNeeded = $checkCatId;
                    }
                }
                //once catalog id was found get the relation of course set with the latest catalog an copy it


                $SetRelations = new CurrSetByCourse();
                $currentSetRels = $SetRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catNeeded));
                foreach($currentSetRels as $setRel)
                {
                    $thisSetRel = new CurrSetByCourse();
                    //check if the relation exist in the prospective catalog
                    $thisSetRelExist = $thisSetRel->find('set_id=:set_id AND catalog_id=:catalog_id AND course_id=:course_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID, ':course_id'=>$setRel->getAttribute('course_id')));
                    if(!$thisSetRelExist)
                    {
                        $saveNewSetRel = new CurrSetByCourse();
                        $saveNewSetRel->course_id = $setRel->getAttribute('course_id');
                        $saveNewSetRel->catalog_id = $catalogID;
                        $saveNewSetRel->set_id = $setIdentifierID;
                        $saveNewSetRel->save();
                    }
                }
            }*/
            continue;
        }
    }

    public function actionRetrieveGroupFields()
    {
        $group = new CurrGroup();
        $groupInfo = new HisGroup();

        //name of course being passed
        $myGroup = $_GET['mygroup'];

        $gID = $group->find('name=:name', array(':name'=>$myGroup));

        //get id of the course
        $myGroupID = $gID->getAttribute('id');

        //get info for course from db based on id
        $tInfo = $groupInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myGroupID));

        $return = $_GET;

        //get name of the prefix id
        $return["myTrackDescription"] = $tInfo->getAttribute('description');                 //eg COP
        $return["myTrackMinCredits"] = $tInfo->getAttribute('minCredits');
        $return["myTrackMaxCredits"] = $tInfo->getAttribute('maxCredits');

        echo json_encode($return);
    }

    public function actionUpdateGroup()
    {
        $groupModel = new CurrGroup();
        $groupInfoModel = new HisGroup();

        $group = $_GET['name'];
        $description = $_GET['description'];
        $mincredits = $_GET['mincredits'];
        $maxcredits = $_GET['maxcredits'];
        $catalogID = $_GET['catalogID'];

        //get id from currgroup table
        $myGroup = $groupModel->find('name=:name', array(':name'=>$group));
        $groupIdentifierID = $myGroup->getAttribute('id');

        $exist = $groupInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $groupIdentifierID));

        if ( $exist){
            HisGroup::model()->updateByPk($exist->getAttribute('id'),array(
                'minCredits' => $mincredits,
                'maxCredits' => $maxcredits,
                'description' => $description,
                'identifier_id' => $groupIdentifierID,
                'catalog_id' => $catalogID,
            ));
        }
        else{
            $groupInfoModel->description = $description;
            $groupInfoModel->minCredits = $mincredits;
            $groupInfoModel->maxCredits = $maxcredits;
            $groupInfoModel->identifier_id = $groupIdentifierID;
            $groupInfoModel->catalog_id = $catalogID;
            $groupInfoModel->save();
        }

        $haveGroupRelation = new CurrGroupBySet();
        $myGroupRelation = $haveGroupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$groupIdentifierID, ':catalog_id'=>$catalogID));

        if(!$myGroupRelation)
        {
            $catalog = new Catalog();
            $allCatalogs = $catalog->findAll('activated=:activated', array(':activated' => 1));
            $lastactiveCatalog = 0;
            //checks for the last active catalog
            foreach ($allCatalogs as $active) {
                $lastactiveCatalog = $active->getAttribute('id');
            }

            $groupRelation = new CurrGroupBySet();
            $theseGroupRelations = $groupRelation->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id' => $groupIdentifierID, ':catalog_id' => $lastactiveCatalog));
            foreach ($theseGroupRelations as $relation) {
                $newRelation = new CurrGroupBySet();
                $newRelation->group_id = $relation->group_id;
                $newRelation->set_id = $relation->set_id;
                $newRelation->catalog_id = $catalogID;
                $newRelation->save();

                //for each set pertaining to the group update it too
                $setRelations = new CurrSetByCourse();
                $mySetRelations = $setRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$relation->set_id, ':catalog_id'=>$catalogID));
                //if user has not changes in the set copy current active to user prospective catalog
                if ( !$mySetRelations) {
                    //copy current relations to the table

                    $relations = new CurrSetByCourse();
                    $theseRelations = $relations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id' => $relation->set_id, ':catalog_id' => $lastactiveCatalog));
                    //copy relations of the active catalog to prospective catalog
                    foreach ($theseRelations as $relationSet) {
                        $newRelation = new CurrSetByCourse();
                        $newRelation->course_id = $relationSet->course_id;
                        $newRelation->set_id = $relationSet->set_id;
                        $newRelation->catalog_id = $catalogID;
                        $newRelation->save();
                    }
                }

            }
        }


    }

    public function actionRemoveSetGroup()
    {
        $set = new CurrSet();
        $group = new CurrGroup();
        $setByGroup = new CurrSetByCourse();

        $mySet = $_GET['set'];
        $myGroup = $_GET['group'];
        $catalogId = $_GET['catalogId'];


        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $sIDs = $setID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_group_set WHERE set_id=:set_id AND group_id=:group_id AND catalog_id=:catalog_id';
        $params = array(
            "set_id" => $sIDs,
            "group_id" => $gIDs,
            "catalog_id"=>$catalogId
        );
        $command->setText($sql)->execute($params);
    }
    /*end group function*/



    /*SET functions*/
    public function actionAddCourseSet()
    {
        $set = new CurrSet();
        $course = new CurrCourse();
        $setByCourse = new CurrSetByCourse();

        $mySet = $_GET['set'];
        $myCourse = $_GET['course'];
        $myCatalogId = $_GET['catalogId'];

        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $courseID = $course->find('name=:name', array(':name'=>$myCourse));


        $sIDs = $setID->getAttribute('id');
        $cIDs = $courseID->getAttribute('id');

        $setByCourse->set_id = $sIDs;
        $setByCourse->course_id = $cIDs;
        $setByCourse->catalog_id = $myCatalogId;
        $setByCourse->save();
    }

    public function actionSaveNewSet()
    {
        $setModel = new CurrSet();
        $setCourseModel = new CurrSetByCourse();
        $setInfoModel = new HisSet();
        $courseModel = new CurrCourse();

        $set = $_GET['name'];
        $description = $_GET['description'];
        $novals = $_GET['novals'];
        $maxcredits = $_GET['maxcredits'];
        $mincredits = $_GET['mincredits'];
        $catalogID = $_GET['catalogID'];

        //save new set in currset
        $setModel->name = $set;
        $setModel->catalog_id = $catalogID;
        $setModel->save();

        //get id of the set inserted in the table
        $mySet = $setModel->find('name=:name', array(':name'=>$set));
        $setIdentifierID = $mySet->getAttribute('id');

        $setInfoModel->description = $description;
        $setInfoModel->minCredits = $mincredits;
        $setInfoModel->maxCredits = $maxcredits;
        $setInfoModel->identifier_id = $setIdentifierID;
        $setInfoModel->catalog_id = $catalogID;
        $setInfoModel->save();

        //insert each relation if needed to be inserted
        for ( $i = 0; $i < $novals; $i++)
        {
            $course = $_GET['element'.$i];
            $this->saveNewSetCourseRelation($course, $setIdentifierID, $catalogID);
            /*$myCourse = $courseModel->find('name=:name', array(':name'=>$course));
            $courseIdentifierID = $myCourse->getAttribute('id');

            $exist = $setCourseModel->find('set_id=:set_id AND course_id=:course_id AND catalog_id=:catalog_id', array(':set_id' => $setIdentifierID, ':course_id' => $courseIdentifierID, ':catalog_id' => $catalogID));

            if ( !$exist )
            {
                $setCourseModel = new CurrSetByCourse();
                $setCourseModel->course_id = $courseIdentifierID;
                $setCourseModel->set_id = $setIdentifierID;
                $setCourseModel->catalog_id = $catalogID;
                $setCourseModel->save();
            }
            continue;*/
        }
    }

    public function actionUpdateSet()
    {
        $setModel = new CurrSet();
        $setInfoModel = new HisSet();

        $set = $_GET['name'];
        $description = $_GET['description'];
        $mincredits = $_GET['mincredits'];
        $maxcredits = $_GET['maxcredits'];
        $catalogID = $_GET['catalogID'];

        //get id from currset table
        $mySet = $setModel->find('name=:name', array(':name'=>$set));
        $setIdentifierID = $mySet->getAttribute('id');

        //check whether catalog exists
        $exist = $setInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $setIdentifierID));

        //if it exist update the row
        if ( $exist){
            HisSet::model()->updateByPk($exist->getAttribute('id'),array(
                'minCredits' => $mincredits,
                'maxCredits' => $maxcredits,
                'description' => $description,
                'identifier_id' => $setIdentifierID,
                'catalog_id' => $catalogID,
            ));
        }
        //if it does not create a new row in hisset table
        else{
            $setInfoModel->description = $description;
            $setInfoModel->minCredits = $mincredits;
            $setInfoModel->maxCredits = $maxcredits;
            $setInfoModel->identifier_id = $setIdentifierID;
            $setInfoModel->catalog_id = $catalogID;
            $setInfoModel->save();
        }

        $haveRelations = new CurrSetByCourse();
        $myRelations = $haveRelations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setIdentifierID, ':catalog_id'=>$catalogID));

        //if user has not changes in the set copy current active to user prospective catalog
        if ( !$myRelations) {
            //copy current relations to the table
            $catalog = new Catalog();
            $allCatalogs = $catalog->findAll('activated=:activated', array(':activated' => 1));
            $lastactiveCatalog = 0;
            //checks for the last active catalog
            foreach ($allCatalogs as $active) {
                $lastactiveCatalog = $active->getAttribute('id');
            }

            $relations = new CurrSetByCourse();
            $theseRelations = $relations->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id' => $setIdentifierID, ':catalog_id' => $lastactiveCatalog));
            //copy relations of the active catalog to prospective catalog
            foreach ($theseRelations as $relation) {
                $newRelation = new CurrSetByCourse();
                $newRelation->course_id = $relation->course_id;
                $newRelation->set_id = $relation->set_id;
                $newRelation->catalog_id = $catalogID;
                $newRelation->save();
            }
        }
    }

    public function actionRetrieveSetFields()
    {
        $set = new CurrSet();
        $setInfo = new HisSet();

        //name of course being passed
        $mySet = $_GET['myset'];

        $sID = $set->find('name=:name', array(':name'=>$mySet));

        //get id of the course
        $mySetID = $sID->getAttribute('id');

        //get info for course from db based on id
        $sInfo = $setInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$mySetID));



        $return = $_GET;

        //get name of the prefix id
        $return["mySetDescription"] = $sInfo->getAttribute('description');                 //eg COP
        $return["mySetMinCredits"] = $sInfo->getAttribute('minCredits');               //description of course
        $return["mySetMaxCredits"] = $sInfo->getAttribute('maxCredits');                    ;

        echo json_encode($return);
    }

    public function actionRemoveCourseSet()
    {
        $set = new CurrSet();
        $course = new CurrCourse();
        $setByCourse = new CurrSetByCourse();

        $mySet = $_GET['set'];
        $myCourse = $_GET['course'];
        $myCatalogId = $_GET['catalogId'];


        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $courseID = $course->find('name=:name', array(':name'=>$myCourse));


        $sIDs = $setID->getAttribute('id');
        $cIDs = $courseID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_set_course WHERE set_id=:set_id AND course_id=:course_id AND catalog_id=:catalog_id';
        $params = array(
            "set_id" => $sIDs,
            "course_id" => $cIDs,
            "catalog_id"=> $myCatalogId
        );
        $command->setText($sql)->execute($params);
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('RemoveCourseSet',array('model'=>$model),false, true);*/
    }
    /*end set function*/



    /*COURSE functions*/
    public function actionSaveNewCourse()
    {
        $courseModel = new CurrCourse();
        $prefixModel = new CurrCoursePrefix();
        $courseInfoModel = new HisCourse();

        //get data send from form
        $course = $_GET['name'];
        $prefix = $_GET['prefix'];
        $code = $_GET['code'];
        $description = $_GET['description'];
        $notes = $_GET['note'];
        $credits = $_GET['credits'];
        $catalogID = $_GET['catalogID'];

        //save new course into curr_course table
        $courseModel->name = $course;
        $courseModel->catalog_id = $catalogID;
        $courseModel->save();

        //get the id of the course just inserted in curr_course table to get the identifier_ID
        $myCourse = $courseModel->find('name=:name', array(':name'=>$course));
        $courseIdentifierID = $myCourse->getAttribute('id');

        //get the prefix id  of the course inserted to get the course coursePrefix_id
        $myPrefix = $prefixModel->find('name=:name', array(':name'=>$prefix));
        $prefixID = $myPrefix->getAttribute('id');

        //save course information in his_course
        $courseInfoModel->coursePrefix_id = $prefixID;
        $courseInfoModel->abstract = $description;
        $courseInfoModel->credits = $credits;
        $courseInfoModel->notes = $notes;
        $courseInfoModel->number = $code;
        $courseInfoModel->identifier_id = $courseIdentifierID;
        $courseInfoModel->catalog_id = $catalogID;
        $courseInfoModel->save();
    }

    public function actionRetrieveCourseFields()
    {
        $course = new CurrCourse();
        $prefix = new CurrCoursePrefix();
        $courseInfo = new HisCourse();

        //name of course being passed
        $myCourse = $_GET['mycourse'];

        $cID = $course->find('name=:name', array(':name'=>$myCourse));

        //get id of the course
        $myCourseID = $cID->getAttribute('id');

        //get info for course from db based on id
        $cInfo = $courseInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myCourseID));

        //get id of the course prefix id of the course
        $myPrefixID = $cInfo->getAttribute('coursePrefix_id');


        $cPrefix = $prefix->find('id=:id', array(':id'=>$myPrefixID));

        $return = $_GET;

        //get name of the prefix id
        $return["myCoursePrefixID"] = $cPrefix->getAttribute('name');                 //eg COP
        $return["myCourseAbstract"] = $cInfo->getAttribute('abstract');               //description of course
        $return["myCourseNote"] = $cInfo->getAttribute('notes');                      //notes of the course
        $return["myCourseNumber"] = $cInfo->getAttribute('number');                   //number id of course
        $return["myCourseCredits"] = $cInfo->getAttribute('credits');                 //number of credits
        $return["myCourseName"] = $myCourse;

        echo json_encode($return);
    }

    public function actionUpdateCourse()
    {
        $courseModel = new CurrCourse();
        $prefixModel = new CurrCoursePrefix();
        $courseInfoModel = new HisCourse();

        $course = $_GET['name'];
        $prefix = $_GET['prefix'];
        $code = $_GET['code'];
        $description = $_GET['description'];
        $notes = $_GET['note'];
        $credits = $_GET['credits'];
        $catalogID = $_GET['catalogID'];

        $myCourse = $courseModel->find('name=:name', array(':name'=>$course));
        $courseIdentifierID = $myCourse->getAttribute('id');

        //checks if user have made changes to an existing course

        $exist = $courseInfoModel->find('catalog_id=:catalog_id AND identifier_id=:identifier_id', array(':catalog_id' => $catalogID, ':identifier_id' => $courseIdentifierID));
        $myPrefix = $prefixModel->find('name=:name', array(':name'=>$prefix));
        $prefixID = $myPrefix->getAttribute('id');

        if ( $exist ){
            HisCourse::model()->updateByPk($exist->getAttribute('id'),array(
                'coursePrefix_id' => $prefixID,
                'abstract' => $description,
                'credits' => $credits,
                'notes' => $notes,
                'identifier_id' => $courseIdentifierID,
                'catalog_id' => $catalogID,
            ));
        }
        else{
            $courseInfoModel->coursePrefix_id = $prefixID;
            $courseInfoModel->abstract = $description;
            $courseInfoModel->credits = $credits;
            $courseInfoModel->notes = $notes;
            $courseInfoModel->number = $code;
            $courseInfoModel->identifier_id = $courseIdentifierID;
            $courseInfoModel->catalog_id = $catalogID;
            $courseInfoModel->save();
        }

    }

    /*end course function*/

    public function actionCourseProspectiveForm()
    {
        $data = array();
        $data["myValue"] = "Content updated in AJAX";

        $this->renderPartial('courseProspectiveForm', $data, false, true);

    }

    public function actionAcceptReject()
    {
        $model=new Catalog;

        // uncomment the following code to enable ajax-based validation
        /*
        if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-acceptReject-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

        if(isset($_POST['Catalog']))
        {
            $model->attributes=$_POST['Catalog'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render('acceptReject',array('model'=>$model));
    }

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionUpdate()
	{
        $dgu = new CurrDgu;
        $major = new CurrMajor;
        $course = new CurrCourse;
        $set = new CurrSet;
        $group = new CurrGroup;
        $minor = new CurrMinor;
        $certificate = new CurrCertificate;
        $model = new Catalog;       
        
		$this->render('update',array( 'model'=>$model ,
                                        'dgu'=>$dgu, 
                                        'major'=>$major, 
                                        'course'=>$course, 
                                        'set'=>$set, 
                                        'group'=>$group,
                                        'minor'=>$minor, 
                                        'certificate'=>$certificate,));
	}

    public function actionPropose()
    {
        $model=new Catalog;

        // uncomment the following code to enable ajax-based validation
        /*
        if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-propose-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

        if(isset($_POST['Catalog']))
        {
            $model->attributes=$_POST['Catalog'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render('propose',array('model'=>$model));
    }
    
	public function actionView()
	{
        $mycat =  $_GET['checkProspectiveCat'];
		$this->render('view', array('catid'=>$mycat));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}