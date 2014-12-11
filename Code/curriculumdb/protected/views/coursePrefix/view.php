<?php
/* @var $this CoursePrefixController */
/* @var $model CurrCoursePrefix */

$this->breadcrumbs=array(
	'Course Prefixes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CoursePrefix', 'url'=>array('index')),
	array('label'=>'Create CoursePrefix', 'url'=>array('create')),
	array('label'=>'Update CoursePrefix', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoursePrefix', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	/*array('label'=>'Manage CoursePrefix', 'url'=>array('admin')),*/
);
?>

<h1>View CoursePrefix #<?php echo $model->name; ?></h1>

<?php 
$data = $model->hisCoursePrefixes[0];
echo $data->description;
?>
