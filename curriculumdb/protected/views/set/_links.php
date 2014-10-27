  <style>
      .spacer {
          position:relative;
          float:left;
          width:100%;
      }
	.box {
	    position:relative;
            width: 100%;
            height: 60px;
	    text-align: center;
            border: solid black thin;
            overflow: hidden;
            padding: 0;
            margin: 0;
	}
        .box-left {
	    float:left;
        }
	.box-right {
            float:right;
	}
	.row {
            position:relative;
            float:left;
		width:100%;
		height:auto;
	}
        .outer {
          position: relative;
          float: left;
          width: 750px;
          border: thin solid red;
      }
      
      .box-container {
          position: relative;
          width: 25%;
          float: left;
      }
  </style>
  <script>
    var isDragging = false;
    var objSource = "";
    var row = 0;
  
    function Box (id, dropState) {
      this.id = id;
      this.canDrop = dropState;
    }
    
    function BoxRight (id) {
      Box.call(this, id, true);
    }
    BoxRight.prototype = Object.create(Box.prototype);
    BoxRight.prototype.constructor = BoxRight;
    
    function BoxLeft (id) {
      Box.call(this, id, false);
    }
    BoxLeft.prototype = Object.create(Box.prototype);
    BoxLeft.prototype.constructor = BoxLeft;
    

    var arrBox = new Array();
    var arrBoxLeft = new Array();

    
	function allowDrop(obj, ev)
	{
		if (arrBox[obj.id].canDrop) {
			ev.preventDefault();
		}
	}

	function drag(parent, ev)
	{
		ev.dataTransfer.setData("Text",parent.id + ":" + ev.target.id);
	}

	function drop(obj, ev)
	{   
		if (arrBox[obj.id].canDrop) {
			ev.preventDefault();
			var dragData=ev.dataTransfer.getData("Text");
                        var indexColon = dragData.indexOf(":");
                        var sourceId = dragData.substring(0,indexColon);
                        var dragId = dragData.substring(indexColon+1);
			ev.target.appendChild(document.getElementById(dragId));
                        var value = document.getElementById(dragId).innerHTML;
                        
                        if (obj.id.indexOf("boxRight") == 0) {
                            var index = parseInt(obj.id.substring(8));
                        }       
                  
                        if (sourceId.indexOf("boxRight") == 0) {
                            var index = parseInt(sourceId.substring(8));
                        }
                        
                    arrBox[obj.id].canDrop = !arrBox[obj.id].canDrop;  
		}
	}
	
	function dragStart(obj) {
	    isDragging = true;
	    objSource = obj;
		objSource.style.border = "thin solid black";
	}
	
	function dragEnd(obj) {
	    if (isDragging) {
			objSource.style.border = "thin solid red";
			arrBox[objSource.id].canDrop = !arrBox[objSource.id].canDrop;
		}
		isDragging = false;
	}
</script>';
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


    $row = 0;
    echo '<div class=\'outer\'>';
    $string = array();
    foreach ($setByCourse AS $course)
    {      
        global $string;
        $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->course_id));
        $entity = new Course($course->course_id, $this->catalogId); //$entity has current and history
        $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
        $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
        $string[$row] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
        $string[$row].= ' '.$data->number.'<br>';
        $string[$row].= $course->course->name.'<br>';
        foreach($setByReq AS $req)
        {
            $entity1 = new Course($req->requisite_id, $this->catalogId);
            $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
            $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
            if($req->level == 0)
            {
                $string[$row].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                $string[$row].= ' '.$data1->number.' <br>'; 
                break; //Flow chart to display only a single course as pre-req
            }
        }
        foreach($setByReq AS $req)
        {
            $entity1 = new Course($req->requisite_id, $this->catalogId);
            $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
            $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
            if($req->level == 1)
            {
                $string[$row].= 'Co: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                $string[$row].= ' '.$data1->number.' <br>';
                break; //Flow chart to display only a single course as co-req
            }
        }
        $row+=1;
    }    
       
        
        //echo "<div id = row".$row ."class = row>";
        //echo "<div id = boxLeft".$row ." class=\"box box-left\">";
    
    foreach($string AS $line)
    {
        echo "<script>
            arrBox[\"boxLeft\"+(row*3+0+row)] = new BoxLeft(row);
            arrBox[\"boxRight\"+(row*3+1+row)] = new BoxRight(row);
            arrBox[\"boxRight\"+(row*3+2+row)] = new BoxRight(row);
            arrBox[\"boxRight\"+(row*3+3+row)] = new BoxRight(row);

            document.write(\"<div class='row'>\");
                    document.write(\"<div class = 'box-container'><div id ='boxLeft\" + (row*3+0+row) + \"' class='box box-left' \");
                            document.write(\"ondragstart='dragStart(this)' ondragend='dragEnd(this)' \");
                            document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'>\");
                           
                            document.write('<div id=\"drag' + row + '\" draggable=\"true\" ondragstart=\"drag(this.parentNode,event)\">' + '$line');
                             document.write(\"<input type='hidden' id='hidden\" + 
                    (row*3+0+row) + \"' name='hidden\" + (row*3+0+row) + \"' row='\" + (row) + \"'>\");    
                            
                    document.write(\"</div></div></div>\");
                    
                    document.write(\"<div class = 'box-container'><div id = 'boxRight\" + (row*3+1+row) + \"' class='box box-right' \");
                            document.write(\"ondragstart=dragStart(this) ondragend=dragEnd(this) \");
                            document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'\");
                    document.write(\"></div></div>\");
                    
                    document.write(\"<div class = 'box-container'><div id = 'boxRight\" + (row*3+2+row) + \"' class='box box-right' \");
                            document.write(\"ondragstart=dragStart(this) ondragend=dragEnd(this) \");
                            document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'\");
                    document.write(\"></div></div>\");
                   
                    document.write(\"<div class = 'box-container'><div id = 'boxRight\" + (row*3+3+row) + \"' class='box box-right' \");
                            document.write(\"ondragstart=dragStart(this) ondragend=dragEnd(this) \");
                            document.write(\"ondrop='drop(this, event)' ondragover='allowDrop(this, event)'\");
                    document.write(\"></div></div>\");
            document.write(\"</div>\");
            row++;
        </script>";
    }
    echo '</div>';
    
        //echo '<br></div>'; //Close Left
        //echo "<div id = boxRight".$row ." class=\"box box-right\">";
            //echo "Test";
        //echo '</div>';
        //echo '</div>'; //Close Row
        //$row = $row + 1;
    //}
    //echo '</div>';    
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