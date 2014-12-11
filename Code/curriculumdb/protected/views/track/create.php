<?php
/* @var $this TrackController */
/* @var $model CurrTrack */

$this->breadcrumbs=array(
	'Tracks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Track', 'url'=>array('index')),
	/*array('label'=>'Manage CurrTrack', 'url'=>array('admin')),*/
);
?>

<h1>Create Track</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>