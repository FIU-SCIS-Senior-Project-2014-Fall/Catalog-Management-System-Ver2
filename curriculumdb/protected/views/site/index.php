<?php
/* @var $this MajorSelectionFormController */
/* @var $model MajorSelectionForm */
/* @var $form CActiveForm */
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'major-selection-form-index-form',
	'enableAjaxValidation'  =>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php   
        echo $form->errorSummary($model); 
        ?>

	<div class="row">
            <?php 
            // --- MAJOR ---
            echo $form->labelEx($model,'major');
            $this->widget('CAutoComplete',
                  array(
                      'model'=>$model,
                      'attribute'=>'majorName',
                      'value'=>'',
//                      'name'=>'major_name',//name of the html field
                        'selectFirst'=>true,
                        'url'=>array('site/getmajors'), //Post to getMajors action
                        'max'=>10, //specifies the max number of items to display
                        'minChars'=>1, //before autocomplete initiates a lookup
                        'delay'=>500, //number of milliseconds before lookup occurs
                        'matchCase'=>false, //match case when performing a lookup?
                        'htmlOptions'=>array('size'=>'30'),
                        'methodChain'=>'.result( 
                                            function(event,item){ 
                                            $("#track_container").attr("style","display:block");
                                                $("#'.CHtml::activeId($model,'major').'").val(item[1]);
                                                    '.
                                                //Ajax call that will update the tracks dropdown
                                                CHtml::ajax(array(
                                                    'id'=>'major',
                                                    'type'=>'POST',
                                                    'url'=>CController::createUrl('site/gettracks'),
                                                    'update'=>'#'.CHtml::activeId($model,'track').'',
                                                    )).'})',
        ));
        //hidden field representing the major in the model to pass the id
        echo $form->hiddenField($model,'major');?>
		<?php echo $form->error($model,'major'); ?>
	</div>

	<div class="row" id="track_container">
            <?php 
                    
            echo $form->labelEx($model,'track');
            echo $form->dropDownList($model,
                                'track',
                                array(),
                                array('onChange'=>'javascript:$("#term_container").attr("style","display:block");',
                                    'style'=>'width: 150px;')
                                );
            echo $form->error($model,'track'); ?>
	</div>

	<div class="row" id="term_container">
		<?php echo $form->labelEx($model,'term'); 
                    $data = Catalog::model()->findAll('activated=1');
                    $data = CHtml::listData($data,'id','name');
                    
                    echo $form->dropDownList($model,
                                'term',
                                $data
                        ); ?>
		<?php echo $form->error($model,'term'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->