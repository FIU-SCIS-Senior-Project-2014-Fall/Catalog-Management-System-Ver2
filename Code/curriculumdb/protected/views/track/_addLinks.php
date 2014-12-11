<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//create model
$model = new CurrTrackByGroup();

?>

<div class="dialog_input">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'curr-track-by-group-_data_form-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=> array( 'onsubmit'=>'return false;')
)); ?>
    
<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php 
            $model->track_id = $trackId;
            echo $form->hiddenField($model,'track_id'); 
        ?>
    </div>

    <div class="row">
        <?php 
        
        $data = CurrTrackByGroup::model()->with('group')->findAll('t.catalog_id=:catalog AND t.track_id!=:track',
                                                        array(':track'=>$trackId, ':catalog'=>$this->catalogId));

        $data = CHtml::listData($data, 'group_id', 'group.name');
        echo $form->dropDownList($model, 'group_id', $data);
        echo $form->error($model,'group_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('onclick'=>'submitAddLink();')); ?> 
        <b>or</b>
        <?php echo CHtml::link('Create New', array('group/create')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
</div>
    
    <script type="text/javascript">
        
        function submitAddLink(){
            var data= $("#curr-track-by-group-_data_form-form").serialize();
            $.ajax(
            {   type: 'POST',
                url:'<?php echo Yii::app()->createAbsoluteUrl("track/ajaxAddLink")?>',
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