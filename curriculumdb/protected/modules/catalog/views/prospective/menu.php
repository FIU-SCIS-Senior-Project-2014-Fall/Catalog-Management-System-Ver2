<ul class="actions">
<?php

?>
    
    <li><?php echo CHtml::link(CatalogModule::t('Create Prospective Catalog'), array('/catalog/prospective/create')); ?></li>
    <li><?php echo CHtml::link(CatalogModule::t('Update Prospective Catalog'), array('/catalog/prospective/update')); ?></li>
    <li><?php echo CHtml::link(CatalogModule::t('Propose Prospective Catalog'), array('/catalog/prospective/propose')); ?></li>
    <li><?php echo CHtml::link(CatalogModule::t('Accept / Reject Prospective Catalog'), array('catalog/prospective/accept')); ?></li>


</ul>