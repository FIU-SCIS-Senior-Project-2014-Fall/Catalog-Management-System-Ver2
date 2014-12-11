<?php
/* @var $this ManageController */
/* @var $model Catalog */

$this->breadcrumbs=array(
	'Catalogs'=>array('index'),
	$model->name=>array('view','id'=>$model->name),
	'Update',
);

$this->menu=array(
	array('label'=>'List Catalog', 'url'=>array('index')),
	array('label'=>'Create Catalog', 'url'=>array('create')),
	array('label'=>'View Catalog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Catalog', 'url'=>array('admin')),
);
?>

<h2>Update Catalog: <?php echo $model->name; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'action'=>'update')); ?>