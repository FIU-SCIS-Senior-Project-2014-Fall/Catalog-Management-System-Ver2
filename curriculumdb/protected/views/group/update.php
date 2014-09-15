<?php
/* @var $this GroupController */
/* @var $currModel CurrGroup */
/* @var $hisModel HisGroup */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'View Group', 'url'=>array('view', 'id'=>$currModel->name), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage Group', 'url'=>array('admin')),*/
);
?>

<h1>Update <?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>