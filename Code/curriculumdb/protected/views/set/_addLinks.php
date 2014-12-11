<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//create model
$model = new CurrSetByCourse();

?>

<div class="dialog_input">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'curr-set-by-course-_data_form-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=> array( 'onsubmit'=>'return false;')
)); ?>
    
<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php 
            $model->set_id = $setId;
            echo $form->hiddenField($model,'set_id'); 
        ?>
    </div>

    <div class="row">
        <?php 
        
        $data = CurrSetByCourse::model()->with('course')->findAll('t.catalog_id!=:catalog AND t.set_id!=:set',
                                                        array(':set'=>$setId, ':catalog'=>$this->catalogId));

        $data = CHtml::listData($data, 'course_id', 'course.name');
        echo $form->dropDownList($model, 'course_id', $data);
        echo $form->error($model,'course_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('onclick'=>'submitAddLink();')); ?> 
        <b>or</b>
        <?php echo CHtml::link('Create New', array('course/create')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
</div>
    
    <script type="text/javascript">
        
        function submitAddLink(){
            var data= $("#curr-set-by-course-_data_form-form").serialize();
            $.ajax(
            {   type: 'POST',
                url:'<?php echo Yii::app()->createAbsoluteUrl("set/ajaxAddLink")?>',
                data: data,
                success: function(data){ 
                            if(data == 'error'){
                                alert('Sorry, there was an error saving your data.');
                                $(this).dialog("close");
                            }
                            else{
                                window.location.href = data;
                            }
                         },
                error: function(data){
                            alert('Sorry, there was an error on Ajax communication');
                            $(this).dialog("close");
                        },
                dataType:'html'}
            );
        }
        
    </script>