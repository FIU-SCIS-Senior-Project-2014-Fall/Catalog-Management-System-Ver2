<?php
/* @var $this DguController */
/* @var $model CurrDgu */

$this->breadcrumbs=array(
	'Dgus'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Dgu', 'url'=>array('index')),
	array('label'=>'Create Dgu', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Update Dgu', 'url'=>array('update', 'id'=>$model->id), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Delete Dgu', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage Dgu', 'url'=>array('admin')),*/
);
?>

<h1><?php echo $model->name; ?></h1>

<?php 

$data = $model->hisDgus[0];

echo $data->code;
echo $data->description;

?>
