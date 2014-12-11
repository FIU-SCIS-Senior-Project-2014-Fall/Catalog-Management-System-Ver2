<?php
/* @var $this GroupController */
/* @var $currModel CurrGroup */
/* @var $hisModel CurrGroup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'curr-group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
        
        <div class="contentContainer">
            <?php echo $form->errorSummary($currModel); ?>
            <?php echo $form->errorSummary($hisModel); ?>

            <div class="row">
                    <?php echo $form->labelEx($currModel,'name'); ?>
                    <?php if($action == 'create')
                                echo $form->textField($currModel,'name',array('size'=>60,'maxlength'=>255)); 
                            else
                                echo $form->textField($currModel,'name',array('size'=>60,'maxlength'=>255, 'disabled'=>'disabled'));
                    ?>
                    <?php echo $form->error($currModel,'name'); ?>
            </div>


            <div class="row">
                <?php echo $form->labelEx($hisModel,'description'); ?>
                <?php echo $form->textArea($hisModel,'description', array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($hisModel,'description'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'minCredits'); ?>
                <?php echo $form->textField($hisModel,'minCredits'); ?>
                <?php echo $form->error($hisModel,'minCredits'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'maxCredits'); ?>
                <?php echo $form->textField($hisModel,'maxCredits'); ?>
                <?php echo $form->error($hisModel,'maxCredits'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'minSets'); ?>
                <?php echo $form->textField($hisModel,'minSets'); ?>
                <?php echo $form->error($hisModel,'minSets'); ?>
            </div>


            <div class="row buttons">
                    <?php echo CHtml::submitButton($currModel->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->