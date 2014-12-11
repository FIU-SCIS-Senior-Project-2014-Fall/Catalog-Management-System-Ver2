<?php

class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model for a course.
	 * A course is built from the history table and the course table.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$currModel=new CurrCourse();
		$hisModel=new HisCourse();

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($currModel);
		//$this->performAjaxValidation($hisModel);

		if(isset($_POST['CurrCourse']) && isset($_POST['HisCourse']))
		{
                    $currModel->attributes=$_POST['CurrCourse'];
                    $hisModel->attributes=$_POST['HisCourse'];
                    $currModel->catalog_id = $this->catalogId;
                    $hisModel->catalog_id = $this->catalogId;
                        
                    //Validate
                    $hisValid = $hisModel->validate();
                    if($currModel->validate() && $hisValid){
			
                        try{
                            $newModelId = Course::createNewEntity($currModel, $hisModel);
                            
                            $this->redirect(array('view','id'=>$newModelId));
                        }
                        catch (Exception $e){
                            var_dump($e);
                        }
                    }
		}

		$this->render('create',array(
			'currModel'=>$currModel, 'hisModel'=>$hisModel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$entity = new Course($id, $this->catalogId);
                
                $currModel = $entity->getEntity();
                $hisModel = $currModel->hisCourses[0];

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($hisModel);

		if(isset($_POST['CurrCourse']) && isset($_POST['HisCourse']))
		{
                    $entityAttributes = $entity->getEntity();
                    $entityData = $entityAttributes->hisCourses[0];
                    
                    
                    $entityData->attributes = $_POST['HisCourse'];
                    
                    if($entityData->validate()){
                        
                        if($entity->updateData())
                            $this->redirect(array('view','id'=>$entityAttributes->id));
                    }
		}

		$this->render('update',array(
                    'currModel'=>$currModel, 'hisModel'=>$hisModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$entity = new Course($id, $this->catalogId);
                
                if($entity->deleteOrRevertEntity())
                    $this->redirect(array('index'));
                else 
                    Yii::app()->request->redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CurrCourse');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CurrCourse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CurrCourse']))
			$model->attributes=$_GET['CurrCourse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$entity = new Course($id, $this->catalogId);
		$model = $entity->getEntity();
		if($model===null)
			throw new CHttpException(404,'The requested entity does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='curr-course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
