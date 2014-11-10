<?php
/* @var $this FlowCourseController */
/* @var $data FlowCourse */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flowchartid')); ?>:</b>
	<?php echo CHtml::encode($data->flowchartid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('courseid')); ?>:</b>
	<?php echo CHtml::encode($data->courseid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />


</div>