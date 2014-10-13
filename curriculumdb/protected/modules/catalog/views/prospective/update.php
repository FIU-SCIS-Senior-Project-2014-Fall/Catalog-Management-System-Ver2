<?php
/* @var $this ProspectiveController */

$this->breadcrumbs=array(
	'Prospective'=>array('/catalog/prospective'),
	'Update',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prospective-catalog-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    
    <?php //echo $form->errorSummary($model); ?>
    
    <div class="contentContainer">
            <div class="row">
                    <?php echo 'Catalog DGU' ?></br>
                    <?php echo $form->textArea($dgu, 'name', array()) ?>
            </div>
        
            <div class="row">
                    <?php echo 'Catalog Name'; ?></br>
                    <?php echo $form->textArea($model, 'name',array('size'=>60,'maxlength'=>255));;?>
            </div>
        
            <div class="row">
                    <?php echo 'Majors' ?></br>
                    <?php echo $form->textArea($major, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
        
            <div class="row">
                    <?php echo 'Minors'; ?></br>
                    <?php echo $form->textArea($minor, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
        
            <div class="row">
                    <?php echo 'Certificates'; ?></br>
                    <?php echo $form->textArea($minor, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
            
            <div class="row">
                    <?php echo 'Groups' ;?></br>
                    <?php echo $form->textArea($group, 'name',array('size'=>60,'maxlength'=>255)) ;?>
            </div>
        
            <div class="row">
                    <?php echo 'Sets' ;?></br>
                    <?php echo $form->textArea($set, 'name',array('size'=>60,'maxlength'=>255)); ?>
        
            <div class="row">
                    <?php echo 'Courses'; ?></br>
                    <?php echo $form->textArea($course, 'name',array('size'=>60,'maxlength'=>255)); ?>
            </div>
                    
            <div class="row buttons">
                    <?php echo CHtml::submitButton('Update'); ?>
            </div>
    </div> 
    <?php $this->endWidget(); ?>
  </div><!-- form -->   