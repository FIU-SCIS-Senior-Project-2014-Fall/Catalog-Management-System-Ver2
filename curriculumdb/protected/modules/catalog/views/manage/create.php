<?php
/* @var $this ManageController */
/* @var $model Catalog */

$this->breadcrumbs=array(
	'Catalogs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Catalog', 'url'=>array('index')),
	array('label'=>'Manage Catalog', 'url'=>array('admin')),
);
?>

<h2>Create Catalog</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'action'=>'create')); ?>