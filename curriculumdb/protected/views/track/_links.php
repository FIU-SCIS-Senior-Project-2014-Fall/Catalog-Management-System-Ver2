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
    
    $recordGroup = FlowGroup::model()->findAll('t.trackid=:tid', array(':tid' => $id));
    if(!empty($recordGroup))
    {
        $flowchartid = $recordGroup[0]->flowchartid;
        $info = CourseFlowInfo::getTrackInfo($recordGroup);
        $string = $info[0];
        $groupid = $info[1];
        $setindex = $info[2];
        $groupindex = $info[3];
        
     //group close
        
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
