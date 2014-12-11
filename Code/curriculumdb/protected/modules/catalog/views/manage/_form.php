<?php
/* @var $this ManageController */
/* @var $model Catalog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="contentContainer">
            <div class="row">
                    <?php echo $form->labelEx($model,'name'); ?>
                    <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'name'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($model,'description'); ?>
                    <?php echo $form->textArea($model,'description',array('maxlength'=>255)); ?>
                    <?php echo $form->error($model,'description'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($model,'year'); ?>
                    <?php echo $form->dropDownList($model,'year', 
                                                    array('2010'=>'2010', '2011'=>'2011', 
                                                            '2012'=>'2012', '2013'=>'2013', 
                                                            '2014'=>'2014')); ?>
                    <?php echo $form->error($model,'year'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($model,'term'); ?>
                    <?php echo $form->dropDownList($model,'term', array('SPRING'=>'SPRING', 'SUMMER'=>'SUMMER', 'FALL'=>'FALL')); ?>
                    <?php echo $form->error($model,'term'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($model,'startingDate'); ?>
                    <?php echo $form->textField($model,'startingDate'); ?>
                    <?php echo $form->error($model,'startingDate'); ?>
            </div>

            <div class="row buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div> 
<?php $this->endWidget(); ?>

</div><!-- form -->