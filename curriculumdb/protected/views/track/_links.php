<?php

/**
 * @var int Id the id for the parent to get the links from.
 *  
 */
//**************************** LIST OF GROUPS FOR MAJOR **************************************************

$trackByGroup = CurrTrackByGroup::model()->with('group')->findAll('t.track_id=:id AND t.catalog_id=:catalogId', array(':id' => $id, 'catalogId' => $this->catalogId));
if (empty($trackByGroup)) {

    echo "no Groups available for this track.<br/>";
} else {
    // Create the list
    echo '<ul>';
    foreach ($trackByGroup AS $group) {
        echo '<li>';
         $image = CHtml::image('http://localhost/images/remove_x_image.gif', 'Remove this item from the list', array('style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($image,"#", array("submit"=>array('removeLink', 'linkId'=>$group->id), 'confirm' => 'Are you sure?',
                                            'style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($group->group->name, array('group/' . $group->group->id));
        echo '</li>';
    }
    echo '</ul>';
}
?>
<br/>
<?php if(!$this->catalogActivated){ ?>
<span class="bottomLeft"><?php
//********************************* LINK ro OPEN DIALOG ************************************************

echo CHtml::link('Add Set', '#', array(
    'onclick' => '$("#addLinkDialog").dialog("open"); return false;',
));
?></span>
<?php }
if(!$this->catalogActivated){ ?>
<span class="bottomRight">
<?php
echo CHtml::link('Remove Set', '#', array(
    'onclick' => '$(".removeLink").css("display", "inline"); return false;',
));
?></span>
<?php } ?>

<?php
//*********************** DIALOG ADD ITEM *************************

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addLinkDialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Add Group',
        'autoOpen' => false,
        'modal' => true,
        'buttons' => array
            (
            'Cancel' => 'js:function(){$(this).dialog("close");}',
        ),
    ),
));
$this->renderPartial('_addLinks', array('trackId' => $id));
$this->endWidget('zii.widgets.jui.CJuiDialog');  
?>
