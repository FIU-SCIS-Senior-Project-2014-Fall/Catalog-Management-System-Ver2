<?php

/**
 * @var int Id the id for the parent to get the links from.
 *  
 */
//**************************** LIST OF GROUPS FOR MAJOR **************************************************

$groupBySet = CurrGroupBySet::model()->with('set')->findAll('t.group_id=:id AND t.catalog_id=:catalogId', array(':id' => $id, 'catalogId' => $this->catalogId));
if (empty($groupBySet)) {

    echo "no Set available for this group.<br/>";
} else {
    // Create the list
    echo '<ul>';
    foreach ($groupBySet AS $set) {
        echo '<li>';
        $image = CHtml::image('http://localhost/images/remove_x_image.gif', 'Remove this item from the list', array('style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($image,"#", array("submit"=>array('removeLink', 'linkId'=>$set->id), 'confirm' => 'Are you sure?',
                                            'style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($set->set->name, array('set/' . $set->set->id));
        echo '</li>';
    }
    echo '</ul>';
}
?>
<br/>
<?php if(!$this->catalogActivated){ ?>
<div class="bottomLeft">
<?php
//********************************* LINK ro OPEN DIALOG ************************************************

echo CHtml::link('Add a Set', '#', array(
    'onclick' => '$("#addLinkDialog").dialog("open"); return false;',
));
?></div> 
<?php }

if(!$this->catalogActivated){ ?>
<div class="bottomRight">
    <?php    
    echo CHtml::link('Remove a set', '#', array(
        'onclick' => '$(".removeLink").css("display", "inline"); return false;',
    ));
?></div>
<?php } ?>

<?php
//*********************** DIALOG ADD ITEM *************************

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addLinkDialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Add Set',
        'autoOpen' => false,
        'modal' => true,
        'buttons' => array
            (
            'Cancel' => 'js:function(){$(this).dialog("close");}',
        ),
    ),
));
$this->renderPartial('_addLinks', array('groupId' => $id));
$this->endWidget('zii.widgets.jui.CJuiDialog');  
?>