<?php
/* @var $this DguController */
/* @var $model CurrDgu */

$this->breadcrumbs=array(
	'Dgus'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Dgu', 'url'=>array('index')),
	/*array('label'=>'Manage CurrDgu', 'url'=>array('admin')),*/
);
?>

<h1>Create Dgu</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>

