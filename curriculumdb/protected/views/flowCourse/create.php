<?php
/* @var $this FlowCourseController */
/* @var $model FlowCourse */

$this->breadcrumbs=array(
	'Flow Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FlowCourse', 'url'=>array('index')),
	array('label'=>'Manage FlowCourse', 'url'=>array('admin')),
);
?>

<h1>Create FlowCourse</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>