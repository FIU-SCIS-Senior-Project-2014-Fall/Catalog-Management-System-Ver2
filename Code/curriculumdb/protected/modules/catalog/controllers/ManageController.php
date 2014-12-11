 <?php

/**
 * short class description.
 * Extended class description
 * 
 * @author curriculum
 * @package modules.catalog.controllers
 */
class ManageController extends Controller
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
				'actions'=>array('create','update', 'activateCatalog'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Catalog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
                        $model->creationDate = date('mm-dd-yyyy');
			if($model->save()){
                            $lastActivatedCatalog = $this->getLastActivatedCatalog ();
                            $this->createLinks($lastActivatedCatalog, $model->id);
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Catalog');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Catalog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Catalog']))
			$model->attributes=$_GET['Catalog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        private function createLinks($lastActivatedCatalog, $newCatalogId){
            //create major links
            $currentMajorLinks = CurrMajorByTrack::model()->findAll('catalog_id=:lastActivatedCatalog', 
                                                                        array(':lastActivatedCatalog'=>$lastActivatedCatalog->id)); 
            foreach ($currentMajorLinks AS $majorLink){
                $new = new CurrMajorByTrack();
                $new->attributes = $majorLink->attributes;
                $new->setIsNewRecord(true);
                $new->catalog_id = $newCatalogId;
                $new->save();
            }
            
            //create track links
            $currentTrackLinks = CurrTrackByGroup::model()->findAll('catalog_id=:lastActivatedCatalog', 
                                                                        array(':lastActivatedCatalog'=>$lastActivatedCatalog->id)); 
            foreach ($currentTrackLinks AS $trackLink){
                $new = new CurrTrackByGroup();
                $new->attributes = $trackLink->attributes;
                $new->setIsNewRecord(true);
                $new->catalog_id = $newCatalogId;
                $new->save();
            }
            
            //create group links
             $groupLinks = CurrGroupBySet::model()->findAll('catalog_id=:lastActivatedCatalog', 
                                                                        array(':lastActivatedCatalog'=>$lastActivatedCatalog->id)); 
            foreach ($groupLinks AS $groupLink){
                $new = new CurrGroupBySet();
                $new->attributes = $groupLink->attributes;
                $new->setIsNewRecord(true);
                $new->catalog_id = $newCatalogId;
                $new->save();
            }
            
            //create set links
            $currentSetLinks = CurrSetByCourse::model()->findAll('catalog_id=:lastActivatedCatalog', 
                                                                        array(':lastActivatedCatalog'=>$lastActivatedCatalog->id)); 
            foreach ($currentSetLinks AS $setLink){
                $new = new CurrSetByCourse();
                $new->attributes = $setLink->attributes;
                $new->setIsNewRecord(true);
                $new->catalog_id = $newCatalogId;
                $new->save();
            }
            
            //create course links (co and pre requisites)
            $currentReqLinks = CurrRequisite::model()->findAll('catalog_id=:lastActivatedCatalog', 
                                                                        array(':lastActivatedCatalog'=>$lastActivatedCatalog->id)); 
            foreach ($currentReqLinks AS $reqLink){
                $new = new CurrRequisite();
                $new->attributes = $reqLink->attributes;
                $new->setIsNewRecord(true);
                $new->catalog_id = $newCatalogId;
                $new->save();
            }
        }
        
        public function actionActivateCatalog($id){
            $model = $this->loadModel($id);
            $model->activated = 1;
            
            if($model->save())
                $this->redirect(array('index'));
            else
                Yii::app()->request->redirect($_SERVER['HTTP_REFERER']);
                
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Catalog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
