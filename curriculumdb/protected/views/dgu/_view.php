<?php
/* @var $this DguController */
/* @var $data CurrDgu */
?>

<div class="view">

        <b>
            <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />
</div>