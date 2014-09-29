<?php
/* @var $this CatalogController */
/* @var $model Catalog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-prospective-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creationDate'); ?>
		<?php echo $form->textField($model,'creationDate'); ?>
		<?php echo $form->error($model,'creationDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'term'); ?>
		<?php echo $form->textField($model,'term'); ?>
		<?php echo $form->error($model,'term'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activated'); ?>
		<?php echo $form->textField($model,'activated'); ?>
		<?php echo $form->error($model,'activated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activation_userId'); ?>
		<?php echo $form->textField($model,'activation_userId'); ?>
		<?php echo $form->error($model,'activation_userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_catalogId'); ?>
		<?php echo $form->textField($model,'parent_catalogId'); ?>
		<?php echo $form->error($model,'parent_catalogId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startingDate'); ?>
		<?php echo $form->textField($model,'startingDate'); ?>
		<?php echo $form->error($model,'startingDate'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->