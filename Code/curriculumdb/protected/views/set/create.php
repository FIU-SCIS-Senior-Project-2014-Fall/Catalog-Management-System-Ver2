<?php
/* @var $this SetController */
/* @var $model CurrSet */

$this->breadcrumbs=array(
	'Sets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sets', 'url'=>array('index')),
	/*array('label'=>'Manage Sets', 'url'=>array('admin')),*/
);
?>

<h1>Create Set</h1>

<?php echo $this->renderPartial('_form', array('currModel'=>$currModel, 'hisModel'=>$hisModel, 'action'=>'create')); ?>