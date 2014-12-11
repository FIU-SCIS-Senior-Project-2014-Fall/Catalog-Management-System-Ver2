<?php
/* @var $this ManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Catalogs',
);

$this->menu=array(
	array('label'=>'Create Catalog', 'url'=>array('create')),
);
?>

<h1>Catalogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>
<br/><br/><br/><br/>
<spam style="color: green">*</spam><span>  Activated</span><br/>
<spam style="color: red">**</spam><span> Prospective</span>

