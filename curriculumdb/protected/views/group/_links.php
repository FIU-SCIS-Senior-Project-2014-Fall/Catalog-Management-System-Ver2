   <style>
      .float-left {
          position:relative;
          float:left;
      }
      .outer {
          position:relative;
          float:left;
          width:600px;
          border: thin solid red;
      }

      .box-container {
          width: 50%;
      }

    .box {
            width: 100%;
            height: 247px;
        text-align: center;
            border: solid black thin;
            margin: 0;
            padding: 0;
    }
    .box-container1 {
          width: 25%;
      }
    .box1 {
            width: 100%;
            height: 60px;
        text-align: center;
            border: solid black thin;
            margin: 0;
            padding: 0;
    }
    
        #result {
            clear: left;
        }

  </style>
   <script>
    var isDragging = false;
    var objSource = "";
    var row = 0;
    var row1 = 0;
    var test = 0;
    
    function Box (id, dropState) {
      this.id = id;
      this.canDrop = dropState;
      this.value="empty";
    }


    var arrBox = new Array();


    function allowDrop(obj, ev)
    {
        if (arrBox[obj.id].canDrop) {
                    ev.preventDefault(); //allow drop
        }
    }

    function drag(parent, ev)
    {
        ev.dataTransfer.setData("Text",parent.id + ":" + ev.target.id);
    }

    function drop(dropTarget, ev)
    {
        if (arrBox[dropTarget.id].canDrop) {
            ev.preventDefault(); //do not try to open link
            var dragData=ev.dataTransfer.getData("Text");
                        var indexColon = dragData.indexOf(":");
                        var parentId = dragData.substring(0,indexColon);
                        var dragId = dragData.substring(indexColon+1);
                        //alert(dropTarget.id + ":" + parentId);
            ev.target.appendChild(document.getElementById(dragId));
                        var dragv = document.getElementById(dragId);
                        arrBox[dropTarget.id].canDrop = false;
                        arrBox[dropTarget.id].value = dragId;
                        arrBox[parentId].value = "";
                        var newP = dropTarget.id;
                        var temp = dragv.getElementsByTagName("input")[0].value;
                        var index1 = temp.indexOf(';');
                        var index = temp.indexOf(':');
                        var cid = temp.substring(index+1);
                        var fid = temp.substring(0,index1);
                        dragv.getElementsByTagName("input")[0].value = fid + ";" + newP + ":" + cid;
            }
    }

    function dragStart(obj) {
        isDragging = true;
        objSource = obj;
        objSource.style.border = 'thin solid black';
    }

    function dragEnd(obj) {
        if (isDragging) {
                    objSource.style.border = 'thin solid red';
                    arrBox[objSource.id].canDrop = true;
            }
            isDragging = false;
    }
    
   </script>
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

//FLOW CHART START We already have a set of courses.
    $row = 0;
    echo '<div class=\'outer\'>';
    $string = array();
    $recordSet = FlowSet::model()->findAll('t.groupid=:gid', array(':gid' => $id));
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
            /*foreach($setByReq AS $req) //GET ONE CO REQ
            {
                $entity1 = new Course($req->requisite_id, $this->catalogId);
                $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                if($req->level == 1)
                {
                    $string[$setindex][$index].= 'Co: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$setindex][$index].= ' '.$data1->number.' <br>';
                    break; //Flow chart to display only a single course as co-req
                }
            }*/
            $index += 1;
        }
        $setindex += 1;
        $row+=1;
    }   
        echo "<div class=\"form\">";

        $form=$this->beginWidget('CActiveForm', array(
                'id'=>'flow-group-form',
                'enableAjaxValidation'=>false,
                'action' => Yii::app()->createUrl('//group/flowGroup'),
        )); 
        
        for($x = 0; $x<($setindex + (4-$setindex%4)); $x++)  
        {
            echo "<script>
            arrBox[row] = new Box(row, true);

            document.write(\"<div class='box-container float-left'><div id ='\" + row + \"' class='box' \");
                document.write(\"ondragstart='dragStart(this)' ondragend='dragEnd(this)' \");
                document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'>\");";

            
            echo "document.write(\"<div id='drag\" + row + \"' draggable='true'\" +    
                   \"ondragstart='drag(this.parentNode,event)'>\");";
            
            //if(!empty($setid[$x]))     
                //echo "document.write(\"<input type='hidden' id='hidden\" + $x + \"' name='hidden\" + $x + \"' value='\" + $flowchartid + \";\" + $x +\":\"+ $setid[$x] + \"'>\");";      
            //hidden fields represent flowchartid;position;setid
            
            if(!empty($string[$x]))
            {
                echo "document.write(\"<input type='hidden' id='hidden\" + $x + \"' name='hidden\" + $x + \"' value='\" + $flowchartid + \";\" + $x +\":\"+ $setid[$x] + \"'>\");";      
                foreach($string[$x] AS $test)
                {   echo "document.write(\"<div class='box-container1 float-left'><div id ='\" + row + \"' class='box1'>\");";
                    echo "document.write(\"$test\");";
                    echo "document.write(\"</div></div>\");";
  
                }
            }
            //close each group
                     echo 'document.write("</div>");';

            echo "document.write(\"</div></div>\");
                row++;
            </script>";
        }
        
        echo "<input type=\"submit\">";
        $this->endWidget();
        //database changes
        //create a controller that has an update
        //gii model for flow_course controller and model
        echo "</div>";
    echo "</div>";

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