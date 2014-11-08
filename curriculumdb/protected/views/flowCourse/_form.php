<?php
/* @var $this FlowCourseController */
/* @var $model FlowCourse */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'flow-course-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'flowchartid'); ?>
		<?php echo $form->textField($model,'flowchartid'); ?>
		<?php echo $form->error($model,'flowchartid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'courseid'); ?>
		<?php echo $form->textField($model,'courseid'); ?>
		<?php echo $form->error($model,'courseid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->