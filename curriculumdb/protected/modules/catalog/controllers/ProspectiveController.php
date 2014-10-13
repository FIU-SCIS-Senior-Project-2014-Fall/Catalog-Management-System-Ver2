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
                                        'certificate'=>$certificate));
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
                                        'certificate'=>$certificate));
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