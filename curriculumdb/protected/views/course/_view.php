<?php
/* @var $this CourseController */
/* @var $data CurrCourse */
?>

<div class="view">

	
	<?php 
            $course = new Course($data->id, $this->catalogId);
            $hisCourse = $course->getHistoryEntity();
            $prefix = new CoursePrefix($hisCourse->coursePrefix_id, $this->catalogId);
            $hisPrefix = $prefix->getHistoryEntity();
            
            echo CHtml::link(CHtml::encode($hisPrefix->prefix. ' ' .$hisCourse->number), array('view', 'id'=>$data->id)); 
        ?>
	
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>