
<?php

if(empty($courses))
    echo '<td>There are NO courses to display</td>';
else
    ?>
    
        <?php
    foreach($courses AS $courseId=>$course){
        
        
        $course = new Course($courseId, $this->catalogId);
        $hisCourse = $course->getHistoryEntity();
        $coursePrefix = new CoursePrefix($hisCourse->coursePrefix_id, $this->catalogId);
        $coursePrefixEntity = $coursePrefix->getEntity();

//        var_dump($courseAR->coursePrefix->prefix);
       echo '<tr>'.'<td>'.$coursePrefixEntity->hisCoursePrefixes[0]->prefix. ' ' .$hisCourse->number. ' </td><td>' .$course->getEntity()->name.'</td></tr>';
    }
?>
    