<?php
/* @var $this TrackController */
/* @var $model CurrTrack */

$identifier = $model->getEntity();
$data = $model->getHistoryEntity();


$this->breadcrumbs=array(
	'Tracks'=>array('index'),
	$identifier->name,
);

$this->menu=array(
	array('label'=>'List Tracks', 'url'=>array('index')),
	array('label'=>'Create Track', 'url'=>array('create'), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Update Track', 'url'=>array('update', 'id'=>$identifier->id), 'visible'=> !$this->catalogActivated), 
	array('label'=>'Delete Track', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$identifier->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=> !$this->catalogActivated), 
	/*array('label'=>'Manage Track', 'url'=>array('admin')),*/
);
?>
<table>
<tr>
<h1><?php echo $identifier->name; ?> Track</h1>
</tr>
<tr>
    <td  style="width: 60%">
        <div class="contentContainer">
            <p>
                <b>Description: </b><br/>
                <?php echo CHtml::encode($data->description); ?><br/><br/>
                
                <b>Min Credits: </b><br/>
                <?php echo CHtml::encode($data->minCredits); ?><br/><br/>
                
            </p>  
            <p >
                <?php if(!$this->catalogActivated){ ?>
                <span class="bottomRight"><?php echo CHtml::link('Update Track', array('update', 'id' => $identifier->id)); ?></span>
                <?php } ?>
            </p>
        </div>      
    </td>

    <td style="width: 100px">
        <div class="contentContainer">
            <b>Groups: </b><br/><br/>
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
