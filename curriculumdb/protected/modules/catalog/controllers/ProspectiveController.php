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

        //$this->renderPartial('create')
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

       /* $model=new Catalog;
        $major = new CurrMajor;
        $track = new CurrTrack;
        $relMajorTrack = new CurrMajorByTrack;



        $this->render('AddTrackMajor',array('model'=>$model,
                                                    'major'=>$major,
                                                    'track'=>$track,
                                                    'majorByTrack'=>$relMajorTrack),false, true);*/
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
        $model=new Catalog;

        $this->render('RetrieveCourseFields', array('model'=>$model));
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