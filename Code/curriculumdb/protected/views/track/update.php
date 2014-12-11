<?php
/* @var $this TrackController */
/* @var $model CurrTrack */
/* @var $hisModel HisTrack */

$this->breadcrumbs=array(
	'Tracks'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Track', 'url'=>array('index')),
	array('label'=>'Create Track', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'View Track', 'url'=>array('view', 'id'=>$currModel->id), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage CurrTrack', 'url'=>array('admin')),*/
);
?>

<h1>Update <?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>