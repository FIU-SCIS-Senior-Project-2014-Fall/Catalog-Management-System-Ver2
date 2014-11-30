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
   
    $recordSet = FlowSet::model()->findAll('t.groupid=:gid', array(':gid' => $id));
    if(!empty($recordSet))
    {
        $flowchartid = $recordSet[0]->flowchartid;
        $info = CourseFlowInfo::getSetInfo($recordSet);
        $string = $info[0];
        $setid = $info[1];
        $setindex = $info[2];
        
       
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