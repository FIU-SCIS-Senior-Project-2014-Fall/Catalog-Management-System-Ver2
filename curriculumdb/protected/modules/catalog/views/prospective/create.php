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
            </div>
        
            <div class="row">
                    <?php echo 'Add Minors'; ?></br>
                    <?php echo $form->textArea($minor, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
        
            <div class="row">
                    <?php echo 'Add Certificates'; ?></br>
                    <?php echo $form->textArea($minor, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
            
            <div class="row">
                    <?php echo 'Add Groups' ;?></br>
                    <?php echo $form->textArea($group, 'name',array('size'=>60,'maxlength'=>255)) ;?>
            </div>
        
            <div class="row">
                    <?php echo 'Add Sets' ;?></br>
                    <?php echo $form->textArea($set, 'name',array('size'=>60,'maxlength'=>255)); ?>
        
            <div class="row">
                    <?php echo 'Add Courses'; ?></br>
                    <?php echo $form->textArea($course, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
                    
            <div class="row buttons">
                    <?php echo CHtml::submitButton('Create'); ?>
            </div>
    </div> 
    <?php $this->endWidget(); ?>
  </div><!-- form -->   
        
            
        
            
        