<table frame="box" class="tableGroup" >

<tr>
 
    <?php
    $tmpCounter = 0;
    foreach($sets AS $singleSetId=>$singleSet){
        echo '<td class="sets">';
        
        echo '<div class=set_header><b>'.CHtml::link($singleSet, array('manage/viewSet/', 'id'=>$singleSetId)).'</b></div>';

    ?>
        
        <?php
        //Get courses in the set
        $courses = CurrSetByCourse::model()->with('course')->findAll('t.set_id=:setId AND t.catalog_id=:catalog', 
                                                                array(':setId'=>$singleSetId, ':catalog'=>$this->catalogId));
        $courses=CHtml::listData($courses,'course_id','course.name');
        //Render set content
        echo $this->renderPartial('editorRequirements/_setContent', array('courses'=>$courses));
        ?>
    <?php
        
        
        if($tmpCounter % 2 != 0){
                    echo "</td></tr><tr>";
        }
        else{
            echo "</td>";
        }
        $tmpCounter++;
        
     }
     ?>
</tr>
</table>