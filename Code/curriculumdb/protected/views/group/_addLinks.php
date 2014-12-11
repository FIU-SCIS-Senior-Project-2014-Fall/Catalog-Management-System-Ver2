<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//create model
$model = new CurrGroupBySet();

?>

<div class="dialog_input">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'curr-group-by-set-_data_form-form',
    'enableAjaxValidation'=>true,
    'htmlOptions'=> array( 'onsubmit'=>'return false;')
)); ?>
    
<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php 
            $model->group_id = $groupId;
            echo $form->hiddenField($model,'group_id'); 
        ?>
    </div>

    <div class="row">
        <?php 
        
        $data = CurrGroupBySet::model()->with('set')->findAll('t.catalog_id=:catalog AND t.group_id!=:group',
                                                        array(':group'=>$groupId, ':catalog'=>$this->catalogId));

        $data = CHtml::listData($data, 'set_id', 'set.name');
        echo $form->dropDownList($model, 'set_id', $data);
        echo $form->error($model,'set_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('onclick'=>'submitAddLink();')); ?> 
        <b>or</b>
        <?php echo CHtml::link('Create New', array('set/create')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
</div>
    
    <script type="text/javascript">
        
        function submitAddLink(){
            var data= $("#curr-group-by-set-_data_form-form").serialize();
            $.ajax(
            {   type: 'POST',
                url:'<?php echo Yii::app()->createAbsoluteUrl("group/ajaxAddLink")?>',
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