<?php
/* @var $this CatalogController */
/* @var $model Catalog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-acceptReject-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	


	<div class="row buttons">
		<?php echo CHtml::submitButton('Accept'); ?>
        <?php echo CHtml::submitButton('Reject'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->