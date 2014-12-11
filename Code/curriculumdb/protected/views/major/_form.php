<?php
/* @var $this MajorController */
/* @var $currModel CurrMajor */
/* @var $hisModel HisMajor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'curr-major-form',
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
                <?php echo $form->labelEx($hisModel,'dgu_id'); ?>
                <?php 
                        $data = CurrDgu::model()->findAll();
                        $data = CHtml::listData($data,'id','name');
                        echo $form->dropDownList($hisModel,
                                'dgu_id',
                                $data
                                );
                ?>
                <?php echo $form->error($hisModel,'dgu_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'majorType_id'); ?>
                <?php
                        $data = CurrMajorType::model()->findAll();
                        $data = CHtml::listData($data,'id','name');
                        echo $form->dropDownList($hisModel,
                                'majorType_id',
                                $data
                                );
                ?>
                <?php echo $form->error($hisModel,'majorType_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($hisModel,'description'); ?>
                <?php echo $form->textArea($hisModel,'description', array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($hisModel,'description'); ?>
            </div>

            <div class="row buttons">
                    <?php echo CHtml::submitButton($currModel->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div>
<?php $this->endWidget(); ?>

</div><!-- form -->