<?php
/* @var $this FlowCourseController */
/* @var $model FlowCourse */

$this->breadcrumbs=array(
	'Flow Courses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FlowCourse', 'url'=>array('index')),
	array('label'=>'Create FlowCourse', 'url'=>array('create')),
	array('label'=>'Update FlowCourse', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FlowCourse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FlowCourse', 'url'=>array('admin')),
);
?>

<h1>View FlowCourse #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'flowchartid',
		'courseid',
		'position',
	),
)); ?>
