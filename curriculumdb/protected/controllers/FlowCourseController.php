<?php

class FlowCourseController extends Controller
{
	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionUpdate($id)
	{
                $entity = new FlowCourse($id, $this->id);
                
                $currModel = $entity->getEntity();
                $hisModel = $currModel->flowCharts[0];

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($hisModel);

		if(isset($_POST['FlowCourse']))
		{
                    $entityAttributes = $entity->getEntity();
                    $entityData = $entityAttributes->flowCharts[0];
                    
                    
                    $entityData->attributes = $_POST['FlowCourse'];
		}

		$this->render('update',array(
                    'currModel'=>$currModel, 'hisModel'=>$hisModel,
		));
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