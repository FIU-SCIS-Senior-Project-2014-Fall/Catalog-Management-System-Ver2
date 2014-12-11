<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//create model
$model = new CurrMajorByTrack();

?>

<div class="dialog_input">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'curr-major-by-track-_data_form-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=> array( 'onsubmit'=>'return false;')
)); ?>
    
<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php 
            $model->major_id = $majorId;
            echo $form->hiddenField($model,'major_id'); 
        ?>
    </div>

    <div class="row">
        <?php 
        
        $data = CurrMajorByTrack::model()->with('track')->findAll('t.catalog_id=:catalog AND t.major_id!=:major',
                                                        array(':major'=>$majorId, ':catalog'=>$this->catalogId));

        $data = CHtml::listData($data, 'track_id', 'track.name');
        echo $form->dropDownList($model, 'track_id', $data);
        echo $form->error($model,'track_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('onclick'=>'submitAddLink();')); ?> 
        <b>or</b>
        <?php echo CHtml::link('Create New', array('track/create')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
</div>
    
    <script type="text/javascript">
        
        function submitAddLink(){
            var data= $("#curr-major-by-track-_data_form-form").serialize();
            
            $.ajax(
            {   type: 'POST',
                url:'<?php echo Yii::app()->createAbsoluteUrl("major/ajaxAddLink")?>',
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