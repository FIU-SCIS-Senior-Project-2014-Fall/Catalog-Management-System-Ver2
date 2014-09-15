<?php
/* @var $this DguController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Degree Granted Unit',
);

$this->menu=array(
	array('label'=>'Create Dgu', 'url'=>array('create')),
	//array('label'=>'Manage CurrDgu', 'url'=>array('admin')),
);
?>

<h1>Degree Granted Unit</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'sortableAttributes'=>array('name'),
)); ?>
