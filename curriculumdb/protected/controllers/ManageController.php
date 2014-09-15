<?php

/**
 * short class description.
 * Extended class description
 * 
 * @author curriculum
 * @package controllers
 */
class ManageController extends Controller {

    public $layout='//layouts/column2';
    
    public function actionIndex() {
        
        $model = new EditorSelectionForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'editor-selection-form-manage-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['EditorSelectionForm'])) {
            $model->attributes = $_POST['EditorSelectionForm'];
            if ($model->validate()) {
                //Set it into the session.
                $catalog = Catalog::model()->findByPk($model->catalog);
                $_SESSION['catalogId'] = $catalog->id;
                $_SESSION['catalogName'] = $catalog->name;
                $_SESSION['catalogActivated'] = $catalog->activated;

                $this->catalogId = $_SESSION['catalogId'];
                $this->catalogName = $_SESSION['catalogName'];
                $this->catalogActivated = $_SESSION['catalogActivated'];
                
                Yii::app()->session['manage=>major'] = $model->major;
                Yii::app()->session['manage=>track'] = $model->track;

                $this->redirect(array('viewTrack'));
//                $this->render('editorRequirements', array('info' => $degreeInfo));
                Yii::app()->end();
                return;
            }
        }
        $this->render('index', array('model' => $model));
    }
    
    
    public function actionViewTrack() {
        if(!isset(Yii::app()->session['manage=>major']) || !isset(Yii::app()->session['manage=>track']))
            $this->redirect('index');
        $degreeInfo = new DegreeInfo(Yii::app()->session['manage=>major'], Yii::app()->session['manage=>track'], $this->catalogId);
        
        $this->render('editorRequirements', array('info' => $degreeInfo));
    }
    public function actionViewGroup($id) {
        if(!isset(Yii::app()->session['manage=>major']) || !isset(Yii::app()->session['manage=>track']))
            $this->redirect('index');
        
        $degreeInfo = new DegreeInfo(Yii::app()->session['manage=>major'], Yii::app()->session['manage=>track'], $this->catalogId);
        
        $this->render('viewGroup', array('info'=>$degreeInfo, 'groupId'=>$id));
    }
    
    public function actionViewSet($id) {
        if(!isset(Yii::app()->session['manage=>major']) || !isset(Yii::app()->session['manage=>track']))
            $this->redirect('index');
        
        $degreeInfo = new DegreeInfo(Yii::app()->session['manage=>major'], Yii::app()->session['manage=>track'], $this->catalogId);

        $this->render('viewSet', array('info'=>$degreeInfo, 'setId'=>$id));
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