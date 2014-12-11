<?php
/* @var $this CoursePrefixController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Course Prefixes',
);

$this->menu=array(
	array('label'=>'Create CoursePrefix', 'url'=>array('create')),
	/*(array('label'=>'Manage CurrCoursePrefix', 'url'=>array('admin')),*/
);
?>

<h1>Course Prefixes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'sortableAttributes'=>array('name'),
)); ?>
