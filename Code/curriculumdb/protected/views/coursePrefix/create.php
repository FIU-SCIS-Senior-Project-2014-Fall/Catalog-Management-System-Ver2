<?php
/* @var $this CoursePrefixController */
/* @var $model CurrCoursePrefix */

$this->breadcrumbs=array(
	'Course Prefixes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CoursePrefix', 'url'=>array('index')),
	/*array('label'=>'Manage CoursePrefix', 'url'=>array('admin')),*/
);
?>

<h1>Create CoursePrefix</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>