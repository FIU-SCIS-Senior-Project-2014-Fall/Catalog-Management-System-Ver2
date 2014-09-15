<?php
/* @var $this CourseController */
/* @var $model CurrCourse */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Courses', 'url'=>array('index')),
	/*array('label'=>'Manage CurrCourse', 'url'=>array('admin')),*/
);
?>

<h1>Create Course</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>