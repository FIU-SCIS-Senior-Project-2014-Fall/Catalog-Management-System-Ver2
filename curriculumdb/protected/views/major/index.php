<?php
/* @var $this MajorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Majors',
);

$this->menu=array(
	array('label'=>'Create Major', 'url'=>array('create')),
);
?>

<h1>Majors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'sortableAttributes'=>array('name'),
)); ?>
