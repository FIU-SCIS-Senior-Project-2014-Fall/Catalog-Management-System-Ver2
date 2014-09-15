<?php
/* @var $this MajorController */
/* @var $currModel CurrMajor */
/* @var $hisModel HisMajor */

$this->breadcrumbs=array(
	'Majors'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Major', 'url'=>array('index')),
	array('label'=>'Create Major', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'View Major', 'url'=>array('view', 'id'=>$currModel->id), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage Major', 'url'=>array('admin')),*/
);
?>

<h1>Update Major: <?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>