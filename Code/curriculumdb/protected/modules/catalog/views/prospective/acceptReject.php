<?php
/* @var $this CatalogController */
/* @var $model Catalog */
/* @var $form CActiveForm */
?>

<div class="form">

<div class="row">
    <h3>Proposed Prospective Catalogs</h3>
</div>

<div class="prospective-table">
<?php
    $catalog = new Catalog();
    $isProposed = 1;
    $result = $catalog->findAll('isProposed=:isProposed', array(':isProposed'=>$isProposed));

    if ( !$result )
    {
        echo '<h4>Currently there are no proposed catalogs </h4>';
    }
    else
    {
        echo '<table style="width:100%">';
        echo '<tr>';
            echo '<th>Catalog ID</th>';
            echo '<th>Catalog Name</th>';
            echo '<th>Created On</th>';
            echo '<th>Created By</th>';
        echo '</tr>';

            foreach($result as $cat)
            {

                echo '<tr>';
                echo '<td>'.$cat->getAttribute('id').'</td>'; ?>
                <td><a href="<?php echo Yii::app()->createUrl('catalog/prospective/View', array('checkProspectiveCat'=> $cat->getAttribute("id"))); ?>"> <?php echo $cat->getAttribute('name');?> </td>
                <?php
                echo '<td>'.$cat->getAttribute('creationDate').'</td>';
                echo '<td>'.$cat->getAttribute('creatorId').'</td>';
                echo '</tr>';
            }

    echo '</table>';
    }
?>

</div>

<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-acceptReject-form',
	'enableAjaxValidation'=>false,
));*/ ?>

	<?php //echo $form->errorSummary($model); ?>

	

<!--
	<div class="row buttons">
		<?php //echo CHtml::submitButton('Accept'); ?>
        <?php //echo CHtml::submitButton('Reject'); ?>
	</div>-->

<?php //$this->endWidget(); ?>

</div><!-- form -->