<?php
/* @var $this CourseController */
/* @var $currModel CurrCourse */
/* @var $hisModel HisCourse */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'curr-course-form',
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

            <!--COURSE PREFIX -->
            <div class="row">
                <?php echo $form->labelEx($hisModel,'coursePrefix_id'); ?>
                <?php $data = CurrCoursePrefix::model()->findAll();
                        $data = CHtml::listData($data,'id','name');
                        echo $form->dropDownList($hisModel,
                                'coursePrefix_id',
                                $data
                                ); ?>
                <?php echo $form->error($hisModel,'coursePrefix_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'number'); ?>
                <?php echo $form->textField($hisModel,'number'); ?>
                <?php echo $form->error($hisModel,'number'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'abstract'); ?>
                <?php echo $form->textArea($hisModel,'abstract', array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($hisModel,'abstract'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'notes'); ?>
                <?php echo $form->textArea($hisModel,'notes', array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($hisModel,'notes'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'credits'); ?>
                <?php echo $form->textField($hisModel,'credits'); ?>
                <?php echo $form->error($hisModel,'credits'); ?>
            </div>


            <div class="row buttons">
                    <?php echo CHtml::submitButton($currModel->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
            

<?php $this->endWidget(); ?>
        </div><!-- end container -->

</div><!-- form -->