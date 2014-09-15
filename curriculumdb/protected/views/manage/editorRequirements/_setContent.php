
<?php

if(empty($courses))
    echo 'No courses to display ';
else
    ?>
        <?php
    foreach($courses AS $courseId=>$course){
        
        $course = new Course($courseId, $this->catalogId);
        $hisCourse = $course->getHistoryEntity();
        $coursePrefix = new CoursePrefix($hisCourse->coursePrefix_id, $this->catalogId);
        $coursePrefixEntity = $coursePrefix->getEntity();

//        var_dump($courseAR->coursePrefix->prefix);
       echo CHtml::link($coursePrefixEntity->hisCoursePrefixes[0]->prefix. ' ' .$hisCourse->number, array('course/view/'.$courseId));
               echo ' ' .$course->getEntity()->name."<br/>";
    }  
    
?>