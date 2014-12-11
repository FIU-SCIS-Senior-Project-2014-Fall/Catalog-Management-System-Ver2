<?php

/**
 * @var int Id the id for the parent to get the links from.
 *  
 */
//**************************** LIST OF TRACKS FOR MAJOR **************************************************

$majorByTrack = CurrMajorByTrack::model()->with('track')->findAll('t.major_id=:id AND t.catalog_id=:catalogId', array(':id' => $id, 'catalogId' => $this->catalogId));

if (empty($majorByTrack)) {

    echo "no tracks available for this major.<br/>";
} else {
    // Create the list
    echo '<ul>';
    foreach ($majorByTrack AS $track) {
        echo '<li>';
        $image = CHtml::image('http://localhost/images/remove_x_image.gif', 'Remove this item from the list', array('style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($image,"#", array("submit"=>array('removeLink', 'linkId'=>$track->id), 'confirm' => 'Are you sure?',
                                            'style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($track->track->name, array('track/' .$track->track->id));
        echo '</li>';
    }
    echo '</ul>';
}
?>
<br/>

<?php if(!$this->catalogActivated){ ?>
<span class="bottomRight"><?php
//********************************* LINK or OPEN DIALOG ************************************************

echo CHtml::link('Remove a track', '#', array(
    'onclick' => '$(".removeLink").css("display", "inline"); return false;',
));
?></span>
<?php }

if(!$this->catalogActivated){ ?>

<span class="bottomLeft"><?php
//********************************* LINK or OPEN DIALOG ************************************************

echo CHtml::link('Add a Track', '#', array(
    'onclick' => '$("#addTrackDialog").dialog("open"); return false;',
));
?></span>
<?php } ?>

<?php
//*********************** DIALOG ADD ITEM *************************

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addTrackDialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Add Track',
        'autoOpen' => false,
        'modal' => true,
        'buttons' => array
            (
            'Cancel' => 'js:function(){$(this).dialog("close");}',
        ),
    ),
));
$this->renderPartial('_addLinks', array('majorId' => $id));
$this->endWidget('zii.widgets.jui.CJuiDialog');  
?>