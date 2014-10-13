<ul class="actions">
<?php

if ( Yii::app()->getModule('user')->isUserAdvisor()) {
?>
    
    <li><?php echo CHtml::link(CatalogModule::t('Create Prospective Catalog'), array('/catalog/prospective/create')); ?></li></br>
    <li><?php echo CHtml::link(CatalogModule::t('Update Prospective Catalog'), array('/catalog/prospective/update')); ?></li></br>
    <li><?php  echo CHtml::link(CatalogModule::t('Propose Prospective Catalog'), array('/catalog/prospective/propose')); } ?></li></br>
    <?php if ( Yii::app()->getModule('user')->isUserAdmin()) { ?>
    <li><?php  
        echo CHtml::link(CatalogModule::t('Accept / Reject Prospective Catalog'), array('prospective/acceptReject')); }?></li></br>


</ul>