<?php

class HelperController extends Controller
{
	public function actionSetCatalog()
	{
            if( isset($_POST['catalogDropdown']) ){
                $catalog = Catalog::model()->findByPk($_POST['catalogDropdown']);
                
                Yii::app()->session['catalogId'] = $catalog->id;
                Yii::app()->session['catalogName'] = $catalog->name;
                Yii::app()->session['catalogActivated'] = $catalog->activated;
            }
            else{
                echo 'error';
            } 
            
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