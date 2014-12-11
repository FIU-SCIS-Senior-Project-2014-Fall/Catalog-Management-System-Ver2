<?php
/* @var $this ManageController */
/* @var $data Catalog */
?>

<div class="view">

	<b></b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
         (<?php if($data->activated){echo '<spam style="color: green">*</spam>';}else{echo '<spam style="color: red">**</spam>';}?>)
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('startingDate')); ?>:</b>
	<?php echo CHtml::encode($data->startingDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_userId')); ?>:</b>
	<?php echo CHtml::encode($data->activation_userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_catalogId')); ?>:</b>
	<?php echo CHtml::encode($data->parent_catalogId); ?>
	<br />

	*/ ?>

</div>