

<?php
/* @var $this CatalogController */
/* @var $model Catalog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-courseProspectiveForm-form',
	'enableAjaxValidation'=>false,
)); ?>

    <!-- Course Form -->
    <div id="CourseDiv">
        <form class="CourseForm" action="#" id="CourseForm">
            <h3>Course Form</h3>
            <label>Prefix: <span>*</span></label>
            <input type="text" id="course-prefix" placeholder="Course Prefix"/></br>
            <label>Code: <span>*</span></label>
            <input type="text" id="course-code" placeholder="Course Code"/></br>
            <label>Name: <span>*</span></label>
            <input type="text" id="course-name" placeholder="Course Name"/></br>
            <label>Description: <span>*</span></label>
            <input type="text" id="course-description" placeholder="Course Description"/></br>
            <input type="button" id="save-course-form" value="Save"/>
            <input type="button" id="close-course-form" value="Cancel"/>
            <br/>
        </form>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->