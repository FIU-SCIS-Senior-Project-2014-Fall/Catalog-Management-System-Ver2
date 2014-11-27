<?php

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/javascript/flowchartdrag.js');
$cs->registerCssFile($baseUrl.'/css/flowchart.css');
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

//FLOW CHART START We already have a set of courses.
   
    $recordSet = FlowCourse::model()->findAll('t.setid=:sid', array(':sid' => $id));
    if(!empty($recordSet))
    {
        $flowchartid = $recordSet[0]->flowchartid;
        $info = CourseFlowInfo::getCourseInfo($recordSet);
        $string = $info[0];
        $courseid = $info[1];

        $form=$this->beginWidget('CActiveForm', array(
                'id'=>'flow-course-form',
                'enableAjaxValidation'=>false,
                'action' => Yii::app()->createUrl('//set/flowSet'),
        )); 
            echo '<div class=\'outer\'>';

        for($x = 0; $x<(sizeof($string) + (4-sizeof($string)%4)); $x++)  
        {
            echo "<script>
                arrBox[row] = new Box(row, true);

                document.write(\"<div class='box-container-course float-left'><div id ='\" + row + \"' class='box-course' \");
                    document.write(\"ondragstart='dragStart(this)' ondragend='dragEnd(this)' \");
                    document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'>\");";

            if (!empty($string[$x])) { //eventually, this will be a test to see if item belongs in current row
                echo "document.write('<div id=\"drag' + row + '\" draggable=\"true\" ondragstart=\"drag(this.parentNode,event)\">' + '$string[$x]' + '');";
                echo "document.write(\"<input type='hidden' id='hidden\" + $x + \"' name='hidden\" + $x + \"' value='\" + $flowchartid + \";\" + $x +\":\"+$courseid[$x] + \"'>\");";      
                echo "document.write(\"</div>\");";
            }   	
            echo "document.write(\"</div></div>\");
                row++;
            </script>";
        }        
        echo "<input type=\"submit\">";
        echo "</div>";
        $this->endWidget();
        //database changes
        //create a controller that has an update
        //gii model for flow_course controller and model
    }

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