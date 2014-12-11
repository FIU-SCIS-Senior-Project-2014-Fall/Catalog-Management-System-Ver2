<ul class="actions">
<?php
$catalog = new Catalog();
$thisUser = Yii::app()->getUser()->getId();
$myCatId = $catalog->find('creatorId=:creatorId', array(':creatorId'=>$thisUser));
if ( Yii::app()->getModule('user')->isUserAdvisor()) {
?>
    
    <li><?php echo CHtml::link(CatalogModule::t('Create Prospective Catalog'), array('/catalog/prospective/create')); ?></li></br>
    <?php if ( $myCatId ){?>
    <li><a href="<?php echo Yii::app()->createUrl('catalog/prospective/View', array('checkProspectiveCat'=> $myCatId->getAttribute("id"))); ?>"> View Prospective Catalog</li>
    <?php }} if ( Yii::app()->getModule('user')->isUserAdmin()) { ?>
    <li><?php  
        echo CHtml::link(CatalogModule::t('Accept / Reject Prospective Catalog'), array('prospective/acceptReject')); }?></li></br>


</ul>