<?php
/* @var $this MajorController */
/* @var $model CurrMajor */

$this->breadcrumbs=array(
	'Major'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Majors', 'url'=>array('index')),
	/*array('label'=>'Manage CurrMajor', 'url'=>array('admin')),*/
);
?>

<h1>Create Major</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>