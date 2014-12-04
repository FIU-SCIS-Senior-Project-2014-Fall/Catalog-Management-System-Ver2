<link rel="stylesheet" href="http://localhost/css/page.css" />
<?php

/* @var $this siteController */
/* @var $model  */
/* @var $form CActiveForm */
?>

<div class="container">    
    <?php
    $major = $info->getMajor();
    $track = $info->getTrack();
    $term = $info->getTerm();
    
    $groups = $info->getGroups();
    $groups=CHtml::listData($groups,'group_id','group.name');
 
    $this->breadcrumbs=array(
	$major->name.' >> '.$track->name.' Track ('.$term.')',
);

    
    
    if(empty($groups)){
        echo 'No groups associated with this track';
    }
    else{
       
       echo CHtml::link("View Flowchart", array('track/' . $track->id));
       echo "<br><br>";
       foreach($groups AS $singleGroupId=>$singleGroup){
    ?>
        <div class="group">
            <div class="student_group_header"><?php echo $singleGroup ?></div>
            <div>
                <?php 
                    //grab all set info
                    $sets = CurrGroupBySet::model()->with('set')->findAll('t.group_id=:groupId AND t.catalog_id=:catalog', 
                            array(':groupId'=>$singleGroupId, ':catalog'=>$this->catalogId));
                    $sets=CHtml::listData($sets,'set_id','set.name');
                    echo $this->renderPartial('majorRequirements/_groupContent', array('sets'=>$sets)); 
                ?>
             </div>
        </div>
    
        
    <?php    
       }
    }?>
</div>
