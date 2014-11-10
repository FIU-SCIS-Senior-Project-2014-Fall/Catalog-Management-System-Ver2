<?php

    $course = new CurrCourse();
    $prefix = new CurrCoursePrefix();
    $courseInfo = new HisCourse();


    //name of course being passed
    $myCourse = $_GET['mycourse'];

    $cID = $course->find('name=:name', array(':name'=>$myCourse));

    //get id of the course
    $myCourseID = $cID->getAttribute('id');

    //get info for course from db based on id
    $cInfo = $courseInfo->find('identifier_id=:identifier_id', array(':identifier_id'=>$myCourseID));

    //get id of the course prefix id of the course
    $myPrefixID = $cInfo->getAttribute('coursePrefix_id');


    $cPrefix = $prefix->find('id=:id', array(':id'=>$myPrefixID));
/*
    $return = $_POST;

    //get name of the prefix id
    $return["myCoursePrefixID"] = $cPrefix->getAttribute('name');                 //eg COP
    $return["myCourseAbstract"] = $cInfo->getAttribute('abstract');               //description of course
    $return["myCourseNote"] = $cInfo->getAttribute('notes');                      //notes of the course
    $return["myCourseNumber"] = $cInfo->getAttribute('number');                   //number id of course
    $return["myCourseCredits"] = $cInfo->getAttribute('credits');                 //number of credits
    $return["myCourseName"] = $myCourse;

    echo json_encode($return);*/

    //get name of the prefix id
    $_GET['myCoursePrefixID'] = $cPrefix->getAttribute('name');                 //eg COP
    $_GET['myCourseAbstract'] = $cInfo->getAttribute('abstract');               //description of course
    $_GET['myCourseNote'] = $cInfo->getAttribute('notes');                      //notes of the course
    $_GET['myCourseNumber'] = $cInfo->getAttribute('number');                   //number id of course
    $_GET['myCourseCredits'] = $cInfo->getAttribute('credits');                 //number of credits
    $_GET['myCourseName'] = $myCourse;
?>