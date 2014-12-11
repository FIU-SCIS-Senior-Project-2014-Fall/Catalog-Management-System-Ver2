<?php
/* @var $this FlowCourseController */
/* @var $model FlowCourse */

$this->breadcrumbs=array(
	'Flow Courses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FlowCourse', 'url'=>array('index')),
	array('label'=>'Create FlowCourse', 'url'=>array('create')),
	array('label'=>'View FlowCourse', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FlowCourse', 'url'=>array('admin')),
);
?>

<h1>Update FlowCourse <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>