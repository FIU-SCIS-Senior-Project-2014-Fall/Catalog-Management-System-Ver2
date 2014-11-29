<?php

/**
 * @var int Id the id for the parent to get the links from.
 *  
 */
//**************************** LIST OF GROUPS FOR MAJOR **************************************************
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/javascript/flowchartdrag.js');
$cs->registerCssFile($baseUrl.'/css/flowchart.css');
  
$trackByGroup = CurrTrackByGroup::model()->with('group')->findAll('t.track_id=:id AND t.catalog_id=:catalogId', array(':id' => $id, 'catalogId' => $this->catalogId));
if (empty($trackByGroup)) {

    //echo "no Groups available for this track.<br/>";
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
//FLOW CHART START We already have a set of courses.
    $row = 0;
    $string = array(); //store course information
    $recordGroup = FlowGroup::model()->findAll('t.trackid=:tid', array(':tid' => $id));
    if(!empty($recordGroup))
    {
        $flowchartid = $recordGroup[0]->flowchartid;
        $groupid = array();
        $groupindex = 0;
        foreach ($recordGroup AS $group)
        {
            $gid = $group ->groupid;
            $recordSet = FlowSet::model()->findAll('t.groupid=:gid', array(':gid' => $gid));
            $setid = array();
            $setindex = 0;
            foreach ($recordSet AS $set)
            {      
                $sid = $set->setid;
                $courseSet = FlowCourse::model()->findAll('t.setid=:sid', array(':sid'=>$sid));
                $index = 0;
                //$setid[$set->position] = $courseSet[$setindex]->setid;
                $groupid[$group->position] = $group->groupid;
                foreach ($courseSet AS $course)
                {
                    global $string;
                    $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->courseid));
                    $entity = new Course($course->courseid, $this->catalogId); //$entity has current and history
                    $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
                    $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
                    $string[$groupindex][$set->position][$index] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$groupindex][$set->position][$index].= ' '.$data->number.'<br>';

                    $setid[$set->position] = $set->setid;
                    foreach($setByReq AS $req) //GET ONE PRE REQ
                    {
                        $entity1 = new Course($req->requisite_id, $this->catalogId);
                        $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                        $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                        if($req->level == 0)
                        {
                            $string[$groupindex][$set->position][$index].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                            $string[$groupindex][$set->position][$index].= ' '.$data1->number.' <br>'; 
                            break; //Flow chart to display only a single course as pre-req

                        }
                    }//pre req close
                    $index += 1;
                } //course set close
                $setindex += 1;            
            } //set close
            $row+=1;
            $groupindex +=1;
        } //group close
        
        /*echo $string[0][0][0];
        echo $string[0][0][1];
        echo $string[0][0][2];
        
        echo $string[1][0][0];
        echo $string[1][0][1];
        echo $string[1][0][2];
        echo $string[1][0][3];
        echo $string[1][0][4];
        echo $string[1][0][5];
        echo $string[1][0][6];
        echo $string[1][0][7];
        echo $string[1][0][8];
        echo $string[1][0][9];
        echo $string[1][0][10];
        echo $string[1][0][11];
        echo $string[1][0][12];
        echo $string[1][0][13];
        
        echo $string[2][0][0];
        echo $string[2][0][1];
        echo $string[2][0][2];
        echo $string[2][0][3];
        echo $string[2][0][4];
        echo $string[2][0][5];
        
        echo $string[2][1][0];*/
 

        echo '<div class=\'outer\'>';

        $form=$this->beginWidget('CActiveForm', array(
                'id'=>'flow-group-form',
                'enableAjaxValidation'=>false,
                'action' => Yii::app()->createUrl('//track/flowTrack'),
        )); 
        
        for($x = 0; $x<($groupindex + (4-$groupindex%4)); $x++)  
        {
            echo "<script>
            arrBox[row] = new Box(row, true);

            document.write(\"<div class='box-container-group float-left'><div id ='\" + row + \"' class='box-group' \");
                document.write(\"ondragstart='dragStart(this)' ondragend='dragEnd(this)' \");
                document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'>\");";


            echo "document.write(\"<div class='drag' id='drag\" + row + \"' draggable='true'\" +    
                   \"ondragstart='drag(this.parentNode,event)'>\");";

            if(!empty($string[$x]))
            {
                echo "document.write(\"<input type='hidden' id='hidden\" + $x + \"' name='hidden\" + $x + \"' value='\" + $flowchartid + \";\" + $x +\":\"+ $groupid[$x] + \"'>\");";      

                for($i = 0; $i<$setindex; $i++)
                {
                    if(!empty($string[$x][$i]))
                    {
                        echo "document.write(\"<div class='box-container-set float-left'><div id ='\" + row + \"' class='box-set'>\");";

                        foreach($string[$x][$i] AS $test)
                        {   
                            echo "document.write(\"<div class='box-container-course float-left'><div id ='\" + row + \"' class='box-course'>\");";
                            echo 'document.write("<a href=\'../group/'. $groupid[$x]. '\'>'. $test. ' </a>");';
                            echo "document.write(\"</div></div>\");";
                        }
                        echo 'document.write("</div></div>");';
                    }
                }    
                //echo 'document.write("</div>");';
            }
            //close each group

            echo "document.write(\"</div></div>\");
                row++;
            </script>";

        }
        echo "<div class = 'box-container'>";
        echo "<input type=\"submit\">";
        echo "</div>";
        $this->endWidget();
        //database changes
        //create a controller that has an update
        //gii model for flow_course controller and model

        echo "</div>";    
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
