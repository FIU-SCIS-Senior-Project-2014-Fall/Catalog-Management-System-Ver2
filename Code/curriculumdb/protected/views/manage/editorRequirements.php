<?php

/* @var $this siteController */
/* @var $model  */
/* @var $form CActiveForm */

    $major = $info->getMajor();
    $track = $info->getTrack();
    $catalog = $info->getTerm();

$this->breadcrumbs=array(
	'Manage'=>array('/manage')
);

$this->menu= array(
                array('label'=>'Mange Major', 'url'=>array('major/view/'.$major->id)),
                array('label'=>'Manage Track', 'url'=>array('track/view/'.$track->id)),
        );
?>

<div class="container">
    
    
    <?php

    echo "<h2>".$major->name."(".$track->name." Track)</h2>";
    
    $groups = CurrTrackByGroup::model()->with('group')->findAll('t.track_id=:track AND t.catalog_id=:catalog', 
                                                                array(':track'=>$track->id,':catalog'=>$this->catalogId));
    $groups=CHtml::listData($groups,'group_id','group.name');
      
    
   if(empty($groups)){
       echo 'There are no Groups to display';
   }
   else{
       
       foreach($groups AS $singleGroupId=>$singleGroup){
    ?>
    <div class="group">
        <div class="group_header">  <?php echo CHtml::link($singleGroup, array('manage/viewGroup/' . $singleGroupId)); ?>
        </div>
            <div class="group_content">
                <?php 
                    //grab all set info
                    $sets = CurrGroupBySet::model()->with('set')->findAll('t.group_id=:groupId AND t.catalog_id=:catalog', 
                            array(':groupId'=>$singleGroupId, ':catalog'=>$this->catalogId));
                    $sets=CHtml::listData($sets,'set_id','set.name');
    
                    echo $this->renderPartial('editorRequirements/_groupContent', array('sets'=>$sets, 'groupId'=>$singleGroupId)); 
                
                ?>
            </div>
        </div>
        
    <?php       
       }
   }
   ?>
    
    
</div>

