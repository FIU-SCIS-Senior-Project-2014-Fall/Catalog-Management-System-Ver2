<?php
/* @var $this DguController */
/* @var $model CurrDgu */
/* @var $model CurrDgu */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'curr-dgu-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($currModel); ?>
	<?php echo $form->errorSummary($hisModel); ?>

        <div class="contentContainer">
            <div class="row">
                    <?php echo $form->labelEx($currModel,'name'); ?>
                    <?php 
                            if($action == 'create')
                                echo $form->textField($currModel,'name',array('size'=>60,'maxlength'=>255)); 
                            else
                                echo $form->textField($currModel,'name',array('size'=>60,'maxlength'=>255));
                    ?>
                    <?php echo $form->error($currModel,'$currModel'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($hisModel,'code'); ?>
                    <?php echo $form->textField($hisModel,'code'); ?>
                    <?php echo $form->error($hisModel,'code'); ?>
            </div>


            <div class="row">
                    <?php echo $form->labelEx($hisModel,'description'); ?>
                    <?php echo $form->textArea($hisModel,'description', array('rows'=>6, 'cols'=>50)); ?>
                    <?php echo $form->error($hisModel,'description'); ?>
            </div>


            <div class="row">
                    <?php
                        if($action == 'create'){
                            echo $form->labelEx($hisModel,'catalog_id'); 

                            $data = Catalog::model()->findAll();
                            $data = CHtml::listData($data,'id','name');
                            echo $form->dropDownList($hisModel,
                                    'catalog_id',
                                    $data
                                    );

                            echo $form->error($hisModel,'catalog_id'); 
                        }
                    ?>
            </div>

            <div class="row buttons">
                    <?php echo CHtml::submitButton($currModel->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div>
<?php $this->endWidget(); ?>

</div><!-- form -->