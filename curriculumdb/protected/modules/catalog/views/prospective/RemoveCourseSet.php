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

    $command = Yii::app()->db->createCommand();


    $sql='DELETE FROM curr_set_course WHERE set_id=:set_id AND course_id=:course_id';
    $params = array(
        "set_id" => $sIDs,
        "course_id" => $cIDs
    );
    $command->setText($sql)->execute($params);
?>
