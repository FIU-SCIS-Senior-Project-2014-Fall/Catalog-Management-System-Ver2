<?php
/* @var $this MajorController */
/* @var $model CurrMajor */




$this->breadcrumbs = array(
    'Majors' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Majors', 'url' => array('index')),
    array('label' => 'Create Major', 'url' => array('create'),'visible'=> !$this->catalogActivated),
    array('label' => 'Update Major', 'url' => array('update', 'id' => $model->id),'visible'=> !$this->catalogActivated),
    array('label' => 'Delete Major', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?'),'visible'=> !$this->catalogActivated),
    /*array('label' => 'Manage Major', 'url' => array('admin')),*/
);
?>




<?php
//get data
$data = $model->hisMajors[0];
//get dgu
$dgu = CurrDgu::model()->findByPk($data->dgu_id);
//get major type
$majorType = CurrMajorType::model()->findByPk($data->majorType_id);

?>

<table>
    <tr>
        <th colspan="2">
            <h2><?php echo CHtml::encode($majorType->name); ?> in <?php echo $model->name; ?>:</h2>
        </th>
    </tr>
<tr>
    <td  style="width: 60%">
        <div class="contentContainer">
            
                <b>Description: </b></span><br/>
                <?php echo CHtml::encode($data->description); ?><br/><br/>
                
                <b>College: </b></span><br/>
                <?php echo CHtml::encode($dgu->name); ?><br/><br/>
                
             
            <p>
                <?php if(!$this->catalogActivated){ ?>
                <span class="bottomRight"><?php echo CHtml::link('Update Major', array('update', 'id'=>$model->id)); ?></span>
                <?php } ?>
            </p>
        </div>      
    </td>

    <td style="width: 100px">
        <div class="contentContainer">
            <b>Tracks: </b><br/><br/>
            <div id="links">
                <?php echo $this->renderPartial('_links', array('id'=>$model->id)); ?>
                
                <br/><br/>
                <p>
                
                </p> 
            </div>
        </div>
    </td>
</tr>


</table>


