<?php
/* @var $this CatalogController */
/* @var $model Catalog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-propose-form',
	'enableAjaxValidation'=>false,
)); ?>

	


	<div class="row buttons">
		<?php echo CHtml::submitButton('Edit'); ?>
        <?php echo CHtml::submitButton('Propose'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->