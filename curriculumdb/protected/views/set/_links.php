<?php

/**
 * @var int Id the id for the parent to get the links from.
 *  
 */
//**************************** LIST OF GROUPS FOR MAJOR **************************************************

$setByCourse = CurrSetByCourse::model()->with('course')->findAll('t.set_id=:id AND t.catalog_id=:catalogId', array(':id' => $id, 'catalogId' => $this->catalogId));
if (empty($setByCourse)) {

    echo "no Courses available for this Set.<br/>";
} else {
    // Create the list
    echo '<ul>';
    foreach ($setByCourse AS $course) {
        echo '<li>';
         $image = CHtml::image('http://localhost/images/remove_x_image.gif', 'Remove this item from the list', array('style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($image,"#", array("submit"=>array('removeLink', 'linkId'=>$course->id), 'confirm' => 'Are you sure?',
                                            'style'=>'display: none', 'class'=>'removeLink'));
        echo CHtml::link($course->course->name, array('course/' .$course->course->id));
        echo '</li>';
    }
    echo '</ul>';
}
    echo '<table>';
    echo '<th>Course ID</th><th>Course Name</th><th>Description</th><th>Credits</th><th>Pre-Requisites</th><th>Co-Requisites</th>';
    foreach ($setByCourse AS $course)
    {
        echo '<tr>';
        echo '<td>';
             $entity = new Course($course->course_id, $this->catalogId); //$entity has current and history
             $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
             $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
             echo $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
             echo ' '.$data->number; 
        echo '</td>';
        echo '<td>';
        echo $course->course->name;
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
?>
<br/>

<?php if(!$this->catalogActivated){ ?>
<div class="bottomLeft">
<?php
//********************************* LINK ro OPEN DIALOG ************************************************
echo CHtml::link('Add Course', '#', array(
    'onclick' => '$("#addLinkDialog").dialog("open"); return false;',
));
?></div>
<?php } 
if(!$this->catalogActivated){ ?>
<div class="bottomRight">
<?php
echo CHtml::link('Remove Course', '#', array(
    'onclick' => '$(".removeLink").css("display", "inline"); return false;',
));
?></div> <?php } ?>

<?php
//*********************** DIALOG ADD ITEM *************************

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addLinkDialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Add Course',
        'autoOpen' => false,
        'modal' => true,
        'buttons' => array
            (
            'Cancel' => 'js:function(){$(this).dialog("close");}',
        ),
    ),
));
$this->renderPartial('_addLinks', array('setId' => $id));
$this->endWidget('zii.widgets.jui.CJuiDialog');  
?>