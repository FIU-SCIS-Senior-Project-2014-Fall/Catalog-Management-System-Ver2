<?php
/* @var $this CourseController */
/* @var $model CurrCourse */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Courses', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Update Course', 'url'=>array('update', 'id'=>$model->id), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Delete Course', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage Course', 'url'=>array('admin')),*/
);

    $data = $model->hisCourses[0];
?>



<table class="courseTable">
    <colgroup>
        <col width="120px;">
        <col width="600px;">
    </colgroup>
    <tr>
        <th colspan="2" class="rowTitle">
           <?php echo $model->name; ?>
        </th>
    </tr>
    <tr>
        <td class="rowTitle"><b>Course Name</b></td>
        <td><?php 
        $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId);
        echo $prefix->getHistoryEntity()->prefix;
        echo ' '.$data->number;
        ?></td>
    </tr>
    <tr>
        <td class="rowTitle"><b>Title</b></td>
        <td><?php echo $model->name; ?></td>
    </tr>
    <tr>
        <td class="rowTitle"><b>Abstract</b></td>
        <td><?php echo $data->abstract; ?></td>
    </tr>
    <tr>
        <td class="rowTitle"><b>Credit</b></td>
        <td><?php echo $data->credits; ?></td>
    </tr>
    <tr>
        <td class="rowTitle"><b>Prerequisite</b></td>
        <td><?php ?></td>
    </tr>
    <tr>
        <td class="rowTitle"><b>Corequisite</b></td>
        <td><?php ?></td>
    </tr>
    <tr>
        <td class="rowTitle"><b>Notes</b></td>
        <td><?php echo $data->notes; ?></td>
    </tr>
</table>
