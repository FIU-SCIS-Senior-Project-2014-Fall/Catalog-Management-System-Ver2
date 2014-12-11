<?php
/* @var $this TrackController */
/* @var $data CurrTrack */
?>

<div class="view">

	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<b><?php #echo CHtml::encode($data->getAttributeLabel('catalog_id')); ?></b>
	<?php #echo CHtml::encode($data->catalog_id); ?>
	<br />


</div>