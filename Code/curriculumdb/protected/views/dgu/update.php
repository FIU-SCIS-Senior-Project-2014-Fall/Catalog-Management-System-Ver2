<?php
/* @var $this DguController */
/* @var $model CurrDgu */

$this->breadcrumbs=array(
	'Dgus'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Dgu', 'url'=>array('index')),
	array('label'=>'Create Dgu', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'View Dgu', 'url'=>array('view', 'id'=>$currModel->id), 'visible'=> !$this->catalogActivated),
	/*array('label'=>'Manage CurrDgu', 'url'=>array('admin')),*/
);
?>

<h1><?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>