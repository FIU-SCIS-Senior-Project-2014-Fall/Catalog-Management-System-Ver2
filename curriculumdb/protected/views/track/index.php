<?php
/* @var $this TrackController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tracks',
);

$this->menu=array(
	array('label'=>'Create Track', 'url'=>array('create')),
	/*array('label'=>'Manage CurrTrack', 'url'=>array('admin')),*/
);
?>

<h1>Tracks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'sortableAttributes'=>array('name'),
)); ?>
