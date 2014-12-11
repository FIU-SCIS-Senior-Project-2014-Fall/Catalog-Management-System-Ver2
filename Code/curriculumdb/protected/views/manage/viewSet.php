<?php
/* @var $this ManageController */

$this->breadcrumbs=array(
	'Manage'=>array('/manage'),
	'Program'=>array('manage/viewTrack'),
);

$this->menu= array(
                array('label'=>'Mange Set', 'url'=>array('set/view/'.$setId)),
        );

//$group = $info->getGroups();
//
//$set = CurrGroupBySet::model()->with('set')->find('t.group_id=:group AND t.set_id=:set AND t.catalog_id=:catalog', 
//                                                                array(':group'=>$group->id,':catalog'=>$this->catalogId, ':set'=>$setId));

?>

<h2>Courses on <?php echo CurrSet::model()->findByPk($setId)->name; ?> Set</h2>

    <div class="header"> </div>
    <div class="content">
       <?php 
            //grab all set info
            $courses = CurrSetByCourse::model()->with('course')->findAll('t.set_id=:set AND t.catalog_id=:catalog', 
                    array(':set'=>$setId, ':catalog'=>$this->catalogId));
            $courses =CHtml::listData($courses,'course_id','course.name');
            
            echo $this->renderPartial('editorRequirements/_setContent', array('courses'=>$courses)); 

        ?>
    </div>
