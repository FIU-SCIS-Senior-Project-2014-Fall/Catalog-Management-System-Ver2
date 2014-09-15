<?php
/* @var $this CoursePrefixController */
/* @var $currModel CurrCoursePrefix */
/* @var $hisModel HisCoursePrefix */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'curr-course-prefix-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="contentContainer">
            <?php echo $form->errorSummary($currModel); ?>
            <?php echo $form->errorSummary($hisModel); ?>

            <div class="row">
                    <?php echo $form->labelEx($currModel,'name'); ?>
                    <?php echo $form->textField($currModel,'name',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($currModel,'name'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($currModel,'school_id'); ?>
                    <?php echo $form->textField($currModel,'school_id'); ?>
                    <?php echo $form->error($currModel,'school_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'prefix'); ?>
                <?php echo $form->textField($hisModel,'prefix'); ?>
                <?php echo $form->error($hisModel,'prefix'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'description'); ?>
                <?php echo $form->textField($hisModel,'description'); ?>
                <?php echo $form->error($hisModel,'description'); ?>
            </div>


            <div class="row buttons">
                    <?php echo CHtml::submitButton($currModel->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div>
<?php $this->endWidget(); ?>

</div><!-- form -->