<?php
/* @var $this GroupController */
/* @var $model CurrGroup */
$identifier = $model->getEntity();
$data = $model->getHistoryEntity();


$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$identifier->name,
);

$this->menu=array(
	array('label'=>'List Groups', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Update Group', 'url'=>array('update', 'id'=>$identifier->id), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Delete Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$identifier->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage CurrGroup', 'url'=>array('admin')),*/
);
?>


<table>
    <tr>
        <th colspan="2"><h2><?php echo $identifier->name; ?>:</h2></th>
</tr>
<tr>
    <td  style="width: 60%">
        <div class="contentContainer">
            <p>
                <b>Description: </b><br/>
                <?php echo CHtml::encode($data->description); ?><br/><br/>
                
                <b>Min Credits: </b><br/>
                <?php echo CHtml::encode($data->minCredits); ?><br/><br/>
                
                <b>Max Credits: </b><br/>
                <?php echo CHtml::encode($data->maxCredits); ?><br/><br/>
                
                <b>Min Sets: </b><br/>
                <?php echo CHtml::encode($data->minSets); ?><br/><br/>
                
            </p>  
            <p>
                <?php if(!$this->catalogActivated){?>
                <div class="bottomRight"><?php echo CHtml::link('Update Group', array('update', 'id' => $identifier->id)); ?></div>
            <?php } ?></p>
        </div>      
    </td>

    <td style="width: 100px">
        <div class="contentContainer">
            <b>Sets: </b><br/><br/>
            <div id="links" name="links">
                <?php echo $this->renderPartial('_links', array('id' => $identifier->id)); ?> 
                <br/><br/>
                <p>
                
                </p> 
            </div>
        </div>
    </td>
</tr>


</table>
