<?php
/* @var $this FlowCourseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Flow Courses',
);

$this->menu=array(
	array('label'=>'Create FlowCourse', 'url'=>array('create')),
	array('label'=>'Manage FlowCourse', 'url'=>array('admin')),
);
?>

<h1>Flow Courses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
