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

    public function actionAddTrackMajor()
    {
        $major = new CurrMajor();
        $track = new CurrTrack();
        $majorByTrack = new CurrMajorByTrack();

        $myMajor = $_GET['major'];
        $myTrack = $_GET['track'];


        $majorID = $major->find('name=:name', array(':name'=>$myMajor));
        $trackID = $track->find('name=:name', array(':name'=>$myTrack));


        $mIDs = $majorID->getAttribute('id');
        $tIDs = $trackID->getAttribute('id');

        $majorByTrack->major_id = $mIDs;
        $majorByTrack->track_id = $tIDs;
        $majorByTrack->catalog_id = 0;
        $majorByTrack->save();

    }

    public function actionAddGroupTrack()
    {
        $track = new CurrTrack();
        $group = new CurrGroup();
        $trackByGroup = new CurrTrackByGroup();

        $myTrack = $_GET['track'];
        $myGroup = $_GET['group'];


        $trackID = $track->find('name=:name', array(':name'=>$myTrack));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $tIDs = $trackID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $trackByGroup->track_id = $tIDs;
        $trackByGroup->group_id = $gIDs;
        $trackByGroup->catalog_id = 0;
        $trackByGroup->save();
    }

    public function actionAddSetGroup()
    {
        $set = new CurrSet();
        $group = new CurrGroup();
        $groupBySet = new CurrGroupBySet();

        $mySet = $_GET['set'];
        $myGroup = $_GET['group'];


        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $sIDs = $setID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $groupBySet->set_id = $sIDs;
        $groupBySet->group_id = $gIDs;
        $groupBySet->catalog_id = 0;
        $groupBySet->save();
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('AddSetGroup',array('model'=>$model),false, true);*/
    }

    public function actionAddCourseSet()
    {
        $set = new CurrSet();
        $course = new CurrCourse();
        $setByCourse = new CurrSetByCourse();

        $mySet = $_GET['set'];
        $myCourse = $_GET['course'];

        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $courseID = $course->find('name=:name', array(':name'=>$myCourse));


        $sIDs = $setID->getAttribute('id');
        $cIDs = $courseID->getAttribute('id');

        $setByCourse->set_id = $sIDs;
        $setByCourse->course_id = $cIDs;
        $setByCourse->catalog_id = 0;
        $setByCourse->save();
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('AddCourseSet',array('model'=>$model),false, true);*/
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

        $myPrefix = $prefixModel->find('name=:name', array(':name'=>$prefix));
        $prefixID = $myPrefix->getAttribute('id');

        $courseInfoModel->coursePrefix_id = $prefixID;
        $courseInfoModel->abstract = $description;
        $courseInfoModel->credits = $credits;
        $courseInfoModel->notes = $notes;
        $courseInfoModel->number = $code;
        $courseInfoModel->identifier_id = $courseIdentifierID;
        $courseInfoModel->catalog_id = $catalogID;
        $courseInfoModel->save();
    }

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

        $courseModel->save(false);
/*
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
        $courseInfoModel->save();*/
    }

    public function actionSaveNewSet()
    {
        $setModel = new CurrSet();
        $setCourseModel = new CurrSetByCourse();
        $courseModel = new CurrCourse();

        $set = $_GET['name'];
        $description = $_GET['description'];
        $minCredits = $_GET['credits'];
        $catalogID = $_GET['catalogID'];

        $setModel->name = $set;
        $setModel->catalog_id = $catalogID;
       // $setModel->save();
    }

    public function actionGetLastCatalogID()
    {
        $max = Yii::app()->db->createCommand()->select('max(id) as max')->from('catalog')->queryScalar();

        $max = intval($max);
        $max++;

        $return = $_GET;
        $return["catalogId"] = $max;

        echo json_encode($return);

    }

    public function actionRemoveTrackMajor()
    {
        $major = new CurrMajor();
        $track = new CurrTrack();
        $majorByTrack = new CurrMajorByTrack();

        $myMajor = $_GET['major'];
        $myTrack = $_GET['track'];


        $majorID = $major->find('name=:name', array(':name'=>$myMajor));
        $trackID = $track->find('name=:name', array(':name'=>$myTrack));


        $mIDs = $majorID->getAttribute('id');
        $tIDs = $trackID->getAttribute('id');

        $command = Yii::app()->db->createCommand();

        $sql='DELETE FROM curr_major_track WHERE major_id=:major_id AND track_id=:track_id';
        $params = array(
            "major_id" => $mIDs,
            "track_id" => $tIDs
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

    public function actionRemoveGroupTrack()
    {
        $track = new CurrTrack();
        $group = new CurrGroup();
        $trackByGroup = new CurrTrackByGroup();

        $myTrack = $_GET['track'];
        $myGroup = $_GET['group'];


        $trackID = $track->find('name=:name', array(':name'=>$myTrack));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $tIDs = $trackID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_track_group WHERE track_id=:track_id AND group_id=:group_id';
        $params = array(
            "track_id" => $tIDs,
            "group_id" => $gIDs
        );
        $command->setText($sql)->execute($params);
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('RemoveGroupTrack',array('model'=>$model),false, true);*/
    }

    public function actionRemoveSetGroup()
    {
        $set = new CurrSet();
        $group = new CurrGroup();
        $setByGroup = new CurrSetByCourse();

        $mySet = $_GET['set'];
        $myGroup = $_GET['group'];


        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $groupID = $group->find('name=:name', array(':name'=>$myGroup));


        $sIDs = $setID->getAttribute('id');
        $gIDs = $groupID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_group_set WHERE set_id=:set_id AND group_id=:group_id';
        $params = array(
            "set_id" => $sIDs,
            "group_id" => $gIDs
        );
        $command->setText($sql)->execute($params);
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('RemoveSetGroup',array('model'=>$model),false, true);*/
    }

    public function actionRemoveCourseSet()
    {
        $set = new CurrSet();
        $course = new CurrCourse();
        $setByCourse = new CurrSetByCourse();

        $mySet = $_GET['set'];
        $myCourse = $_GET['course'];


        $setID = $set->find('name=:name', array(':name'=>$mySet));
        $courseID = $course->find('name=:name', array(':name'=>$myCourse));


        $sIDs = $setID->getAttribute('id');
        $cIDs = $courseID->getAttribute('id');

        $command = Yii::app()->db->createCommand();


        $sql='DELETE FROM curr_set_course WHERE set_id=:set_id AND course_id=:course_id';
        $params = array(
            "set_id" => $sIDs,
            "course_id" => $cIDs
        );
        $command->setText($sql)->execute($params);
        /*
        $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;

        $this->render('RemoveCourseSet',array('model'=>$model),false, true);*/
    }

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
		$this->render('view');
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