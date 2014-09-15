<table class="setTable">
<col width="50px">
<col width="200px">
 
    <?php
    $tmpCounter = 0;
    echo '<tr>';
    foreach($sets AS $singleSetId=>$singleSet){
        
    ?>
        
        <?php
        //Get courses in the set
        $courses = CurrSetByCourse::model()->with('course')->findAll(
                'set_id=:setId', array('setId'=>$singleSetId));
        $courses=CHtml::listData($courses,'course_id','course.name');
        //Render set content
        echo $this->renderPartial('majorRequirements/_setContent', array('courses'=>$courses));
        ?>
    <?php
        $tmpCounter++;
        if($tmpCounter % 2 == 0){
                    echo "</tr><tr>";
        }
        
        
     }
     ?>
</table>