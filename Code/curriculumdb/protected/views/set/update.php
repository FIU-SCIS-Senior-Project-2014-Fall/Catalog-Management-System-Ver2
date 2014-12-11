<?php
/* @var $this SetController */
/* @var $CurrModel CurrSet */
/* @var $Hisodel HisSet */

$this->breadcrumbs=array(
	'Sets'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Set', 'url'=>array('index')),
	array('label'=>'Create Set', 'url'=>array('create')),
	array('label'=>'View Set', 'url'=>array('view', 'id'=>$currModel->id)),
	/*array('label'=>'Manage Set', 'url'=>array('admin')),*/
);
?>

<h1>Update <?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>