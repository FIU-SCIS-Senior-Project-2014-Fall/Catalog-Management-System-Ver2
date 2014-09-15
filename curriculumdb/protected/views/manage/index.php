<?php
/* @var $this EditorSelectionFormController */
/* @var $model EditorSelectionForm */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'editor-selection-form-manage-form',
	'enableAjaxValidation'=>false,
)); ?>

      	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
            <?php echo $form->labelEx($model,'dgu'); ?>                                                                                          
            <?php 
                echo CHtml::textArea('dgu_out');
                echo CHtml::hiddenField("major_data");
                echo "<br>";
                $data = CurrDgu::model()->findAll();                                                                                           
                $data = CHtml::listData($data,'id','name');                                                                                    
                
                echo $form->dropDownList($model,                                                                                               
                        'dgu',                                                                                                                 
                        array($data),                                                                        
                        array(  
                            'onchange' => 'javascript:$("#major_container").attr("style","display:block");',
                            'ajax' => array(                                                                                                   
                                'type'=>'POST', //request type                                                                                 
                                'url'=>CController::createUrl('site/listMajorPerDgu'), //url to call.                                          
                                //'update'=>'#major_data',                                            
                                'update'=>'#'.CHtml::activeId($model,'major'), //selector to update                                      
                            ),
                            'visible' => false,                            
                          )                                                                                                                 
                        );                                                                                                                     
            ?>
            <?php // echo $form->error($model,'dgu'); ?>                                                                                             
	</div>
	


        <div>
        <div class="row" id="major_container" style="display: none;">
                <?php echo $form->labelEx($model,'major'); ?>
                <?php                 
                    //$data = CurrMajor::model()->findAll();
                    //$data = CHtml::listData($data,'id','name');
                    echo $form->dropDownList($model,
                            'major',                                                                      
                            array(),
                            array(
                                'ajax' => array(
                                    'type'=>'POST', //request type                                                                                       
                                    'url'=>CController::createUrl('site/getTracks'), //url to call.                                                      
                                    'update'=>'#'.CHtml::activeId($model,'track'), //selector to update                                                  
                                    ))
                            ); ?>
                <?php echo $form->error($model,'major'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model,'track'); ?>
                <?php echo $form->dropDownList(
                        $model,
                        'track',
                         array(),
                         array('onChange'=>'javascript:$("#catalog_container").attr("style","display:block");',
                                    'style'=>'width: 150px;')
                         ); ?>
	        <?php echo $form->error($model,'track'); ?>
        </div>

      	<div id="catalog_container" style="display: none">
            <?php echo $form->labelEx($model,'catalog');
	          echo $form->hiddenField($model, 'catalog')?>
            <div style="color: green">
	        <lu>
                 <?php
                    $activeCatalogs = Catalog::model()->findAll('activated=1');
                    $activeCatalogs = CHtml::listData($activeCatalogs,'id','name');
                    foreach($activeCatalogs AS $id=>$value)
                        echo '<li>'.CHtml::link($value, '#', array('style'=>'color: green',
                                                    'onclick'=>'$("#'.CHtml::activeId($model,'catalog').'").val('.$id.');                            
                                                                $("#catalog_container a").css("background-color","transparent");                     
                                                                $(this).css("background-color", "#2B4E78");                                          
                                                                $(this).css("color", "#CAA22D");                                                     
                                                                $(this).css("font-weight", "bold");')).'</li>';
                 ?>
                </lu>
            </div>
            <div style="color: red"> 
                <lu>
                <?php
                    $prospectiveCatalogs = Catalog::model()->findAll('activated=0');
                    $prospectiveCatalogs = CHtml::listData($prospectiveCatalogs,'id','name');
                    foreach($prospectiveCatalogs AS $id=>$value)
                        echo '<li>'.CHtml::link($value, '#', array('style'=>'color: red',
                                                    'onclick'=>'$("#'.CHtml::activeId($model,'catalog').'").val('.$id.');                            
                                                                $("#catalog_container a").css("background-color","transparent");                     
                                                                $(this).css("background-color", "#2B4E78");                                          
                                                                $(this).css("color", "#CAA22D");                                                     
                                                                $(this).css("font-weight", "bold");')).'</li>';
                ?>
                </lu>
            </div>
        </div>
        
        <div class="row buttons">
                <?php echo CHtml::submitButton('Submit'); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->