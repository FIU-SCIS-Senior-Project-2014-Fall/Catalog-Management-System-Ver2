<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        $model = new MajorSelectionForm;

        //enable ajax-based validation
        if(isset($_POST['ajax']) && $_POST['ajax']==='major-selection-form-index-form'){
        echo CActiveForm::validate($model);
        Yii::app()->end();
        }


        if (isset($_POST['MajorSelectionForm'])) {
            
            $model->attributes = $_POST['MajorSelectionForm'];
            if ($model->validate()) {
                //Set it into the session.
                $catalog = Catalog::model()->findByPk($model->term);
                $_SESSION['catalogId'] = $catalog->id;
                $_SESSION['catalogName'] = $catalog->name;
                $_SESSION['catalogActivated'] = $catalog->activated;
                
                $this->catalogId = $_SESSION['catalogId'];
                $this->catalogName= $_SESSION['catalogName'];
                $this->catalogActivated = $_SESSION['catalogActivated'];
                
                $degreeInfo = new DegreeInfo($model->major, $model->track, $model->term);
                
                $this->render('majorRequirements', array('info'=>$degreeInfo));
                Yii::app()->end();
            }
        }
        //reset majorName
        $model->majorName = '';
        $this->render('index', array('model' => $model));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
//    public function actionLogin() {
//        $model = new LoginForm;
//
//        // if it is ajax validation request
//        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//
//        // collect user input data
//        if (isset($_POST['LoginForm'])) {
//            $model->attributes = $_POST['LoginForm'];
//            // validate user input and redirect to the previous page if valid
//            if ($model->validate() && $model->login())
//                $this->redirect(Yii::app()->user->returnUrl);
//        }
//        // display the login form
//        $this->render('login', array('model' => $model));
//    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    
    public function actionGetMajors(){
       
       if(Yii::app()->request->isAjaxRequest && isset($_GET['q']))
       {
            /* q is the default GET variable name that is used by
            / the autocomplete widget to pass in user input
            */
          $major = $_GET['q']; 
          // this was set with the "max" attribute of the CAutoComplete widget
          $limit = min($_GET['limit'], 50); 
          $criteria = new CDbCriteria;
          $criteria->condition = "name LIKE :input";
          $criteria->params = array(":input"=>"%$major%");
          $criteria->limit = $limit;
          $majorArray = CurrMajor::model()->findAll($criteria);
          //$returnVal = array();
          $returnVal = '';
          foreach($majorArray as $singleMajor)
          {
             //$returnVal[$singleMajor->getAttribute('user_id')] = $singleMajor->getAttribute('name');
             $returnVal .= $singleMajor->getAttribute('name').'|'
                                         .$singleMajor->getAttribute('id')."\n"; 
          }
          echo $returnVal;
       }
    }
    public function actionGetTracks(){
        
        if(isset($_POST['MajorSelectionForm']['major']))
            $majorId = $_POST['MajorSelectionForm']['major'];
        elseif(isset ($_POST['EditorSelectionForm']['major']))
            $majorId = $_POST['EditorSelectionForm']['major'];
        else
        	echo "No major is set";    
        
       $data= CurrMajorByTrack::model()->with('track')->findAll(
               'major_id=:majorId', 
                array(':majorId'=>$majorId));
          
       if($data == null)
            CHtml::tag('option',
                    array('value'=>NULL),CHtml::encode('No track'),false);
       else
           echo CHtml::tag('option',
                    array('value'=>''),CHtml::encode('Select a Track'),true);
        $data=CHtml::listData($data,'track_id','track.name');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                    array('value'=>$value),CHtml::encode($name),true);
        }
        return ;
    }
    
    public function  actionGetTerms(){
        
//        // OA-USE MODEL
//        $data = array('1'=>'Spring-2012', '2'=>'Summer-2012', '3'=>'Fall-2012');
//        
//        foreach($data as $value=>$name)
//        {
//            echo CHtml::tag('option',
//                    array('value'=>$value),CHtml::encode($name),true);
//        }
        
    }
    
    
    public function actionManage()
    {
        $model=new EditorSelectionForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='editor-selection-form-manage-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['EditorSelectionForm']))
        {
            $model->attributes=$_POST['EditorSelectionForm'];
            if($model->validate())
            {
                //Set it into the session.
                $catalog = Catalog::model()->findByPk($model->catalog);
                $_SESSION['catalogId'] = $catalog->id;
                $_SESSION['catalogName'] = $catalog->name;
                $_SESSION['catalogActivated'] = $catalog->activated;
                
                $this->catalogId = $_SESSION['catalogId'];
                $this->catalogName= $_SESSION['catalogName'];
                $this->catalogActivated = $_SESSION['catalogActivated'];
                
                $degreeInfo = new DegreeInfo($model->major, $model->track, $model->catalog);
                
                $this->render('editorRequirements', array('info'=>$degreeInfo));
                Yii::app()->end();
                return;
            }
        }
        $this->render('manage',array('model'=>$model));
    }
    
    public function actionListMajorPerDgu(){
    
       
        
        if(isset ($_POST['EditorSelectionForm']['dgu'])) {
            $dguId = $_POST['EditorSelectionForm']['dgu'];
            echo "dguId = ".$dguId;
        } else {
            echo "No dgu is set";    
        }

       $data= HisMajor::model()->with('dgu', 'identifier')->findAll(
               'dgu_id=:dguId and t.catalog_id=:catalogId',
                    array(':dguId'=>$dguId, ':catalogId'=>$this->catalogId));
       if($data == null) {
            CHtml::tag('option',
                    array('value'=>NULL),CHtml::encode('No dgu'),false);
       } else {
            echo CHtml::tag('option',
                    array('value'=>'-1'),CHtml::encode('Select a Major'),true);
            $data=CHtml::listData($data,'id','identifier.name');
            foreach($data as $value=>$name)
            {
                //echo CHtml::tag('option',
                //        array('value'=>$value),CHtml::encode($name),true);
            }
       }
        return ;
    }
    /*CONTROLLER TO RENDER CREATED PAGES*/
}