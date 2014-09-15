<?php
/* @var $this CourseController */
/* @var $currModel CurrCourse */
/* @var $hisModel HisCourse */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Courses', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'View Course', 'url'=>array('view', 'id'=>$currModel->id), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage CurrCourse', 'url'=>array('admin')),*/
);
?>

<h1><?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>