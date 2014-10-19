<?php
/* @var $this ProspectiveController */
/* @var $model Catalog */
/* @var $form CActiveForm*/

    

    $this->breadcrumbs=array(
	'Prospective'=>array('/catalog/prospective'),
	'Create',
    );
    
    $users = $dgu->findAllBySql("select name from curr_dgu");
$data = array();

foreach($users as $u){
    $data[$u->name] = $u->name;
}
?>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prospective-catalog-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    <?php //echo $form->errorSummary($model); ?>


    <div class="contentContainer">
            <div class="row">
                    <?php echo 'Select Your DGU'; ?></br>
                    <?php echo $form->dropDownList($dgu, 'name', $data, array('prompt'=>'')); ?>
            </div>
        
            <div class="row">
                    <?php echo 'Catalog Name'; ?></br>
                    <?php echo $form->textArea($model, 'name',array('size'=>60,'maxlength'=>255));;?>
            </div>
        
            <div class="row">
                    <?php echo 'Add Majors' ?></br>
                    <?php echo $form->textArea($major, 'name',array('size'=>60,'maxlength'=>255)); ?>
                    <button id="add-major">Add</button>
                    <button id="edit-major">Edit</button>
                    <button id="remove-major">Remove</button>
            </div>
        
            <div class="row">
                    <?php echo 'Add Minors'; ?></br>
                    <?php echo $form->textArea($minor, 'name',array('size'=>60,'maxlength'=>255)); ?>
                    <button id="add-minor">Add</button>
                    <button id="edit-minor">Edit</button>
                    <button id="remove-minor">Remove</button>
            </div>
        
            <div class="row">
                    <?php echo 'Add Certificates'; ?></br>
                    <?php echo $form->textArea($minor, 'name',array('size'=>60,'maxlength'=>255)); ?>
                    <button id="add-certificate">Add</button>
                    <button id="edit-certificate">Edit</button>
                    <button id="remove-certificate">Remove</button>
            </div>
            
            <div class="row">
                    <?php echo 'Add Groups' ;?></br>
                    <?php echo $form->textArea($group, 'name',array('size'=>60,'maxlength'=>255)) ;?>
                    <button id="add-group">Add</button>
                    <button id="edit-group">Edit</button>
                    <button id="remove-group">Remove</button>
            </div>
        
            <div class="row">
                    <?php echo 'Add Sets' ;?></br>
                    <?php echo $form->textArea($set, 'name',array('size'=>60,'maxlength'=>255)); ?>
                    <button id="add-set">Add</button>
                    <button id="edit-set">Edit</button>
                    <button id="remove-set">Remove</button>
             </div>
        
            <div class="row">
                    <?php echo 'Add Courses'; ?></br>
                    <?php echo $form->textArea($course, 'name',array('size'=>60,'maxlength'=>255)); ?>
                    <button id="add-course">Add</button>
                    <button id="edit-course">Edit</button>
                    <button id="remove-course">Remove</button>
            </div>
                    
            <div class="row buttons">
                    <?php echo CHtml::submitButton('Create'); ?>
            </div>

            <!-- Contact Form -->
            <div id="courseForm">
                <form class="form" action="#" id="contact">
                    <h3>Course Form</h3>
                    <label>Prefix: <span>*</span></label>
                    <input type="text" id="course-prefix" placeholder="Course Prefix"/></br>
                    <label>Code: <span>*</span></label>
                    <input type="text" id="course-code" placeholder="Course Code"/></br>
                    <label>Name: <span>*</span></label>
                    <input type="text" id="course-name" placeholder="Course Name"/></br>
                    <label>Description: <span>*</span></label>
                    <input type="text" id="course-description" placeholder="Course Description"/></br>
                   <!-- <input type="button" id="save" value="Send"/>-->
                    <!--<input type="button" id="close-course-form" value="Cancel"/>-->
                    <br/>
                </form>
            </div>


    <?php $this->endWidget(); ?>
  </div><!-- form -->   
        
            
        
            
        