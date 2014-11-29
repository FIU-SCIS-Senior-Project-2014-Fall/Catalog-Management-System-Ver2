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

$groupBySet = CurrGroupBySet::model()->with('set')->findAll('t.group_id=:id AND t.catalog_id=:catalogId', array(':id' => $id, 'catalogId' => $this->catalogId));
if (empty($groupBySet)) {

    //echo "no Set available for this group.<br/>";
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

//FLOW CHART START We already have a set of courses.
    $row = 0;
    $string = array();
    $recordSet = FlowSet::model()->findAll('t.groupid=:gid', array(':gid' => $id));
    if(!empty($recordSet))
    {
        $flowchartid = $recordSet[0]->flowchartid;
        $setid = array();
        $setindex = 0;
        foreach ($recordSet AS $set)
        {      
            $sid = $set->setid;
            $courseSet = FlowCourse::model()->findAll('t.setid=:sid', array(':sid'=>$sid));
            $index = 0;
            //$setid[$set->position] = $courseSet[$setindex]->setid;
            foreach ($courseSet AS $course)
            {
                global $string;
                $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->courseid));
                $entity = new Course($course->courseid, $this->catalogId); //$entity has current and history
                $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
                $string[$set->position][$index] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
                $string[$set->position][$index].= ' '.$data->number.'<br>';

                $setid[$set->position] = $set->setid;
                foreach($setByReq AS $req) //GET ONE PRE REQ
                {
                    $entity1 = new Course($req->requisite_id, $this->catalogId);
                    $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                    $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                    if($req->level == 0)
                    {
                        $string[$set->position][$index].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                        $string[$set->position][$index].= ' '.$data1->number.' <br>'; 
                        break; //Flow chart to display only a single course as pre-req
                    }
                }
                $index += 1;
            }
            $setindex += 1;
            $row+=1;
        }   

        $form=$this->beginWidget('CActiveForm', array(
                'id'=>'flow-group-form',
                'enableAjaxValidation'=>false,
                'action' => Yii::app()->createUrl('//group/flowGroup'),
        )); 
        echo '<div class=\'outer\'>';

        for($x = 0; $x<($setindex + (4-$setindex%4)); $x++)  
        {
            echo "<script>
            arrBox[row] = new Box(row, true);

            document.write(\"<div class='box-container-set float-left'><div id ='\" + row + \"' class='box-set' \");
                document.write(\"ondragstart='dragStart(this)' ondragend='dragEnd(this)' \");
                document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'>\");";


            echo "document.write(\"<div class='drag' id='drag\" + row + \"' draggable='true'\" +    
                   \"ondragstart='drag(this.parentNode,event)'>\");";

            if(!empty($string[$x]))
            {
                echo "document.write(\"<input type='hidden' id='hidden\" + $x + \"' name='hidden\" + $x + \"' value='\" + $flowchartid + \";\" + $x +\":\"+ $setid[$x] + \"'>\");";      
                foreach($string[$x] AS $test)
                {   
                    echo "document.write(\"<div class='box-container-course float-left'><div id ='\" + row + \"' class='box-course'>\");";
                    echo 'document.write("<a href=\'../set/'. $setid[$x]. '\'>'. $test. ' </a>");';
                    echo "document.write(\"</div></div>\");"; 
                }
                
            }
            //close each group
            echo 'document.write("</div>");';

            echo "document.write(\"</div></div>\");
                row++;
            </script>";
        }
            echo "</div>";

        echo "<input type=\"submit\">";

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