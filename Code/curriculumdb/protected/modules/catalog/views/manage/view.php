<?php
/* @var $this ManageController */
/* @var $model Catalog */

$this->breadcrumbs=array(
	'Catalogs'=>array('index'),
	$model->name,
);

if($model->activated){
    $menuArr= array(
                array('label'=>'List Catalogs', 'url'=>array('index')),
                array('label'=>'Create Catalog', 'url'=>array('create')),
        );
}
else{
    $menuArr= array(
                array('label'=>'List Catalogs', 'url'=>array('index')),
                array('label'=>'Create Catalog', 'url'=>array('create')),
                array('label'=>'Update Catalog', 'url'=>array('update', 'id'=>$model->id)),
                array('label'=>'Delete Catalog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
        );
}

$this->menu=$menuArr;
?>

<h2>Catalog</h2>

<table>
    <tr>
        <th colspan="2">
            
                <h3>
                    <?php echo CHtml::encode($model->name); ?> 
                    (<?php if($model->activated){echo '<spam style="color: green">Activated</spam>';}else{echo '<spam style="color: red">Prospective</spam>';}?>)
                </h3>       
        </th>

</tr>
<tr>
    <td  style="width: 60%">
        <div class="contentContainer">
            <p>
                <b>Description: </b><br/>
                <?php echo CHtml::encode($model->description); ?><br/><br/>
                
                <b>Creation Date: </b><br/>
                <?php echo CHtml::encode($model->creationDate); ?><br/><br/>
                
                <b>Year: </b><br/>
                <?php echo CHtml::encode($model->year); ?><br/><br/>
                
                <b>Term: </b><br/>
                <?php echo CHtml::encode($model->term); ?><br/><br/>
                
                <b>Starting Date: </b> <br/>date catalog starts to apply to students*<br/>
                <?php echo CHtml::encode($model->startingDate); ?><br/><br/>
                
                <b>Admin who activated it: </b><br/>
                <?php 
                    if($model->activation_userId != null){
                            $user = User::model()->findbyPk($model->activation_userId);
                            echo CHtml::encode($user->name);
                    }
                    else{
                        echo 'none <br/><br/>';
                    }
                ?>
                <br/><br/>
                
            </p>  
            <p >
                <div class="bottomLeft"><?php if(!$model->activated)echo CHtml::link('Update Catalog', array('update', 'id' => $model->id)); ?></div>
            </p>
            <div class="bottomRight"><?php if(!$model->activated) echo CHtml::link('Activate Catalog',"#", 
                    array("submit"=>array('activateCatalog', 'id'=>$model->id), 'confirm' => 'Are you sure you want to activate?')); ?></div>
        </div>      
    </td>
</tr>


</table>

