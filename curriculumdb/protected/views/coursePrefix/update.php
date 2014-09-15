<?php
/* @var $this CoursePrefixController */
/* @var $currModel CurrCoursePrefix */
/* @var $hisModel HisCoursePrefix */

$this->breadcrumbs=array(
	'Course Prefixes'=>array('index'),
	$currModel->name=>array('view','id'=>$currModel->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Course Prefix', 'url'=>array('index')),
	array('label'=>'Create Course Prefix', 'url'=>array('create')),
	/*array('label'=>'View Course Prefix', 'url'=>array('view', 'id'=>$currModel->id)),*/
	/*array('label'=>'Manage Course Prefix', 'url'=>array('admin')),*/
);
?>

<h1>Update Course Prefix: <?php echo $currModel->name; ?></h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'update')); ?>