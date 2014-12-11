<?php
/* @var $this GroupController */
/* @var $model CurrGroup */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Groups', 'url'=>array('index')),
	/*array('label'=>'Manage Group', 'url'=>array('admin')),*/
);
?>

<h1>Create Group</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>