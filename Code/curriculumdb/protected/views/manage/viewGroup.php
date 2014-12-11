<?php
/* @var $this ManageController */

$this->breadcrumbs=array(
	'Manage'=>array('/manage'),
	'Program'=>array('manage/viewTrack'),
);

$this->menu= array(
                array('label'=>'Mange Group', 'url'=>array('group/view/'.$groupId)),
        );

$track = $info->getTrack();

$group = CurrTrackByGroup::model()->with('group')->find('t.track_id=:track AND t.group_id=:group AND t.catalog_id=:catalog', 
                                                                array(':track'=>$track->id,':catalog'=>$this->catalogId, ':group'=>$groupId));

?>



<div class="header"> <h2> <?php echo $group->group->name; ?> Group</h2></div>
    <div class="content">
        <?php 
            //grab all set info
            $sets = CurrGroupBySet::model()->with('set')->findAll('t.group_id=:groupId AND t.catalog_id=:catalog', 
                    array(':groupId'=>$group->group->id, ':catalog'=>$this->catalogId));
            $sets=CHtml::listData($sets,'set_id','set.name');
            
            echo $this->renderPartial('editorRequirements/_groupContent', array('sets'=>$sets)); 

        ?>
    </div>
