<?php
/* @var $this ProspectiveController */

    $set = new CurrSet();
    $course = new CurrCourse();
    $setByCourse = new CurrSetByCourse();

    $mySet = $_GET['set'];
    $myCourse = $_GET['course'];

    $setID = $set->find('name=:name', array(':name'=>$mySet));
    $courseID = $course->find('name=:name', array(':name'=>$myCourse));


    $sIDs = $setID->getAttribute('id');
    $cIDs = $courseID->getAttribute('id');

    $setByCourse->set_id = $sIDs;
    $setByCourse->course_id = $cIDs;
    $setByCourse->catalog_id = 0;
    $setByCourse->save();

?>