<?php

/**
 * Description of CourseInfo
 * 
 * Class used to get course information such as "COP 2210" as well as position
 * Also includes an algorithm to order courses when no flowchart is available
 *
 * @author Chris
 */
class CourseFlowInfo {
    
    /*public function getCourseInfo($n)
     * Accepts an interger as a parameter which acts as the set id
     * This function retrieves course information for a particular set.
     * It requires that a flowchart have already been created for this set.
     * Returns an array: 
     * $string which is an array holding course information stored relative to position.
     * $courseid which is an array holding courseid number relative to position for use in hidden fields.
     * $flowchartid which is a variable holding the id for the specific flowchart.
     *      */
    public function getCourseInfo($n)
    {
        $row = 0;
        $string = array();
        $courseid = array();
        $setByCourse = FlowCourse::model()->findAll('t.setid=:id', array(':id' => $n));
        $flowchartid = $setByCourse[0]->flowchartid;
        foreach ($setByCourse AS $course)
        {      
            global $string;
            $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->courseid));
            $entity = new Course($course->courseid, $this->catalogId); //$entity has current and history
            $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
            $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
            $string[$course->position] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
            $string[$course->position].= ' '.$data->number.'<br>';
            $course2 = CurrSetByCourse::model()->with('course')->findAll('t.course_id=:cid AND t.catalog_id=:catalogId', array(':cid' => $course->courseid, 'catalogId' => $this->catalogId));
            $string[$course->position].= $course2[0]->course->name.'<br>';
            $courseid[$course->position] = $course->courseid;
            foreach($setByReq AS $req)
            {
                $entity1 = new Course($req->requisite_id, $this->catalogId);
                $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                if($req->level == 0)
                {
                    $string[$course->position].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$course->position].= ' '.$data1->number.' <br>'; 
                    break; //Flow chart to display only a single course as pre-req
                }
            }
            foreach($setByReq AS $req)
            {
                $entity1 = new Course($req->requisite_id, $this->catalogId);
                $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                if($req->level == 1)
                {
                    $string[$course->position].= 'Co: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$course->position].= ' '.$data1->number.' <br>';
                    break; //Flow chart to display only a single course as co-req
                }
            }
            $row+=1;
        }  
        return array($string, $courseid, $flowchartid);
    }
    
    /*public function getSetInfo($n)
     * Accepts an interger as a parameter which acts as the group id
     * This function retrieves course information for a particular group.
     * It requires that a flowchart have already been created for this group.
     * If a flowchart does not exist '-1' will be returned signalling no flowchart should be created.
     * Returns an array: 
     * $string which is an array holding course information stored relative to position.
     * $setid which is an array holding setid number relative to position for use in hidden fields.
     * $setindex which is a variable holding the number of sets.
     * $flowchartid which is a variable holding the id for the specific flowchart.
     *      */
    public function getSetInfo($n)
    {
        $row = 0;
        $string = array();
        $setid = array();
        $setindex = 0;
        $recordGroup = FlowSet::model()->findAll('t.groupid=:gid', array(':gid' => $n));
        if(empty($recordGroup))
        {
            $flowchartid = -1;
            $setindex = -1;
        }
        else
            $flowchartid = $recordGroup[0]->flowchartid;
        foreach ($recordGroup AS $set)
        {      
            $sid = $set->setid;
            $courseSet = FlowCourse::model()->findAll(array('order'=>'t.position', 'condition'=>'t.setid=:sid', 'params'=>array(':sid'=>$sid)));
            $index = 0;
            foreach ($courseSet AS $course)
            {
                global $string;
                
                $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->courseid));
                $entity = new Course($course->courseid, $this->catalogId); //$entity has current and history
                $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
                $string[$set->position][$course->position] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
                $string[$set->position][$course->position].= ' '.$data->number.'<br>';
                $setid[$set->position] = $set->setid;
                foreach($setByReq AS $req) //GET ONE PRE REQ
                {
                    $entity1 = new Course($req->requisite_id, $this->catalogId);
                    $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                    $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                    if($req->level == 0)
                    {
                        $string[$set->position][$course->position].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                        $string[$set->position][$course->position].= ' '.$data1->number.' <br>'; 
                        break; //Flow chart to display only a single course as pre-req
                    }
                }
                $index += 1;
            }
            $setindex += 1;
            $row+=1;
           
        }
        return array($string, $setid, $setindex, $flowchartid);
    }
    
    /*public function getTrackInfo($n)
     * Accepts an interger as a parameter which acts as the track id
     * This function retrieves course information for a particular track.
     * It requires that a flowchart have already been created for this track.
     * If a flowchart does not exist '-1' will be returned signalling no flowchart should be created.
     * Returns an array: 
     * $string which is an array holding course information stored relative to position.
     * $groupid which is an array holding groupid number relative to position for use in hidden fields.
     * $setindex which is a variable holding the number of sets.
     * $groupindex which is a variable holding the number of groups in a track.
     * $flowchartid which is a variable holding the id for the specific flowchart.
     *  */
    public function getTrackInfo($n)
    {
        $row = 0;
        $string = array(); //store course information
        $groupid = array();
        $groupindex = 0;
        $recordTrack = FlowGroup::model()->findAll('t.trackid=:tid', array(':tid' => $n));
        if(empty($recordTrack))
        {
            $flowchartid = -1;
            $setindex = -1;
            $groupindex = -1;
        }
        else
            $flowchartid = $recordTrack[0]->flowchartid;
        foreach ($recordTrack AS $group)
        {
            $gid = $group ->groupid;
            $recordSet = FlowSet::model()->findAll('t.groupid=:gid', array(':gid' => $gid));
            $setid = array();
            $setindex = 0;
            foreach ($recordSet AS $set)
            {      
                $sid = $set->setid;
                $courseSet = FlowCourse::model()->findAll(array('order'=>'t.position', 'condition'=>'t.setid=:sid', 'params'=>array(':sid'=>$sid)));
                $index = 0;
                //$setid[$set->position] = $courseSet[$setindex]->setid;
                $groupid[$group->position] = $group->groupid;
                foreach ($courseSet AS $course)
                {
                    global $string;
                    $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->courseid));
                    $entity = new Course($course->courseid, $this->catalogId); //$entity has current and history
                    $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
                    $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
                    $string[$group->position][$set->position][$course->position] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$group->position][$set->position][$course->position].= ' '.$data->number.'<br>';
                    $setid[$set->position] = $set->setid;
                    foreach($setByReq AS $req) //GET ONE PRE REQ
                    {
                        $entity1 = new Course($req->requisite_id, $this->catalogId);
                        $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                        $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                        if($req->level == 0)
                        {
                            $string[$group->position][$set->position][$course->position].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                            $string[$group->position][$set->position][$course->position].= ' '.$data1->number.' <br>'; 
                            break; //Flow chart to display only a single course as pre-req

                        }
                    }//pre req close
                    $index += 1;
                } //course set close
                $setindex += 1;            
            } //set close
            $row+=1;
            $groupindex +=1;
        }
        return array($string, $groupid, $setindex, $groupindex, $flowchartid);
    }
    
    /*public function getInfo($n)
     * Accepts an interger as a parameter which acts as the set id
     * This function retrieves course information for a particular set where a flowchart does not already exist.
     * Courses are organized via the number of pre-requisites that each course has.
     * Returns an array: 
     * $string which is an array holding course information stored relative to position.
     * $courseid which is an array holding courseid number relative to position for use in hidden fields.
     * $flowchartid which is a variable holding the id for the specific flowchart.
     *      */
    public function getDefaultSet($n)
    {
        $pos = 0;
        $string = array();
        $courseid = array();
        $order = array();
        $index = 0;
        
        $setByCourse = CurrSetByCourse::model()->with('course')->findAll('t.set_id=:id AND t.catalog_id=:catalogId', array(':id' => $n, 'catalogId' => $this->catalogId));
        $count = sizeof($setByCourse);
        for($i = 0; $i<5; $i++)
        {
            for($j = 0; $j<$count; $j++)
            {
                $preSet = HisRequisite::model()->findAll('t.course_id=:cid', array(':cid' => $setByCourse[$j]->course_id));
                if(sizeof($preSet) == $i)
                {
                    $order[$index] = $setByCourse[$j];
                    $index++;
                }
            }
        }
        
        foreach ($order AS $course)
        {      
            
            global $string;
            $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->course_id));
            $entity = new Course($course->course_id, $this->catalogId); //$entity has current and history
            $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
            $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
            $string[$pos] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
            $string[$pos].= ' '.$data->number.'<br>';
            $course2 = CurrSetByCourse::model()->with('course')->findAll('t.course_id=:cid AND t.catalog_id=:catalogId', array(':cid' => $course->course_id, 'catalogId' => $this->catalogId));
            $string[$pos].= $course2[0]->course->name.'<br>';
            $courseid[$pos] = $course->course_id;
            foreach($setByReq AS $req)
            {
                $entity1 = new Course($req->requisite_id, $this->catalogId);
                $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                if($req->level == 0)
                {
                    $string[$pos].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$pos].= ' '.$data1->number.' <br>'; 
                    break; //Flow chart to display only a single course as pre-req
                }
            }
            foreach($setByReq AS $req)
            {
                $entity1 = new Course($req->requisite_id, $this->catalogId);
                $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                if($req->level == 1)
                {
                    $string[$pos].= 'Co: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                    $string[$pos].= ' '.$data1->number.' <br>';
                    break; //Flow chart to display only a single course as co-req
                }
            }
            $pos++;
        }  
        return array($string, $courseid);
    }
    
    /*public function getDefaultGroup($n)
     * Accepts an interger as a parameter which acts as the group id
     * This function retrieves course information for a particular group where a flowchart does not already exist.
     * Sets are organized by id and courses via the number of pre-requisites that each course has.
     * Returns an array: 
     * $string which is an array holding course information stored relative to position.
     * $setid which is an array holding setid number relative to position for use in hidden fields.
     * $numSets which is a variable holding the number of sets in a group.
     *      */
    public function getDefaultGroup($n)
    {
        $string = array();
        $setid = array();
        $setByGroup = CurrGroupBySet::model()->findAll('t.group_id=:id AND t.catalog_id=:catalogId', array(':id' => $n, 'catalogId' => $this->catalogId));
        $numSets = sizeof($setByGroup);
        echo $numSets;
        for($x = 0; $x<$numSets; $x++)
        {
            $order = array();
            $index = 0;
            $pos = 0;
            $sid = $setByGroup[$x]->set_id;
            $setid[$x] = $sid;
            $setByCourse = CurrSetByCourse::model()->with('course')->findAll('t.set_id=:id AND t.catalog_id=:catalogId', array(':id' => $sid, 'catalogId' => $this->catalogId));
            $count = sizeof($setByCourse);
            for($i = 0; $i<5; $i++)
            {
                for($j = 0; $j<$count; $j++)
                {
                    $preSet = HisRequisite::model()->findAll('t.course_id=:cid', array(':cid' => $setByCourse[$j]->course_id));
                    if(sizeof($preSet) == $i)
                    {
                        $order[$index] = $setByCourse[$j];
                        $index++;
                    }
                }
            }

            foreach ($order AS $course)
            {      

                global $string;
                $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->course_id));
                $entity = new Course($course->course_id, $this->catalogId); //$entity has current and history
                $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
                $string[$x][$pos] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
                $string[$x][$pos].= ' '.$data->number.'<br>';
                $course2 = CurrSetByCourse::model()->with('course')->findAll('t.course_id=:cid AND t.catalog_id=:catalogId', array(':cid' => $course->course_id, 'catalogId' => $this->catalogId));
                
                foreach($setByReq AS $req)
                {
                    $entity1 = new Course($req->requisite_id, $this->catalogId);
                    $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                    $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                    if($req->level == 0)
                    {
                        $string[$x][$pos].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                        $string[$x][$pos].= ' '.$data1->number.' <br>'; 
                        break; //Flow chart to display only a single course as pre-req
                    }
                }
                $pos++;
            }  
        }
        for($i=0; $i<$numSets; $i++)
            foreach($string[$i] AS $test)
                  echo $test;

        return array($string, $setid, $numSets);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*public function getDefaultTrack($n)
     * Accepts an interger as a parameter which acts as the track id
     * This function retrieves course information for a particular track where a flowchart does not already exist.
     * Traks are organized via the number groups and sets they have. Courses by the number of pre-requisites that each course has.
     * Returns an array: 
     * $string which is an array holding course information stored relative to position.
     * $courseid which is an array holding courseid number relative to position for use in hidden fields.
     * $flowchartid which is a variable holding the id for the specific flowchart.
     *      */
    public function getDefaultTrack($n)
    {
        $string = array();
        $setid = array();
        $setByGroup = CurrGroupBySet::model()->findAll('t.group_id=:id AND t.catalog_id=:catalogId', array(':id' => $n, 'catalogId' => $this->catalogId));
        $numSets = sizeof($setByGroup);
        echo "Test ". $n;
        echo "Test ". $numSets;
        for($x = 0; $x<$numSets; $x++)
        {
            $order = array();
            $index = 0;
            $pos = 0;
            $sid = $setByGroup[$x]->set_id;
            $setid[$x] = $sid;
            $setByCourse = CurrSetByCourse::model()->with('course')->findAll('t.set_id=:id AND t.catalog_id=:catalogId', array(':id' => $sid, 'catalogId' => $this->catalogId));
            $count = sizeof($setByCourse);
            for($i = 0; $i<5; $i++)
            {
                for($j = 0; $j<$count; $j++)
                {
                    $preSet = HisRequisite::model()->findAll('t.course_id=:cid', array(':cid' => $setByCourse[$j]->course_id));
                    if(sizeof($preSet) == $i)
                    {
                        $order[$index] = $setByCourse[$j];
                        $index++;
                    }
                }
            }

            foreach ($order AS $course)
            {      

                global $string;
                $setByReq = HisRequisite::model()->with('requisite')->findAll('t.course_id=:cid', array(':cid' => $course->course_id));
                $entity = new Course($course->course_id, $this->catalogId); //$entity has current and history
                $data = $entity->getHistoryEntity();    //extract history into $data, it has the course prefix id
                $prefix = new CoursePrefix($data->coursePrefix_id, $this->catalogId); //prefix his and curr
                $string[$x][$pos] = $prefix->getHistoryEntity()->prefix; //extract the prefix from the history
                $string[$x][$pos].= ' '.$data->number.'<br>';
                $course2 = CurrSetByCourse::model()->with('course')->findAll('t.course_id=:cid AND t.catalog_id=:catalogId', array(':cid' => $course->course_id, 'catalogId' => $this->catalogId));
                
                foreach($setByReq AS $req)
                {
                    $entity1 = new Course($req->requisite_id, $this->catalogId);
                    $data1 = $entity1->getHistoryEntity();    //extract history into $data, it has the course prefix id
                    $prefix1 = new CoursePrefix($data1->coursePrefix_id, $this->catalogId); //prefix his and curr
                    if($req->level == 0)
                    {
                        $string[$x][$pos].= 'Pre: '.$prefix1->getHistoryEntity()->prefix; //extract the prefix from the history
                        $string[$x][$pos].= ' '.$data1->number.' <br>'; 
                        break; //Flow chart to display only a single course as pre-req
                    }
                }
                $pos++;
            }  
        }
        
        return array($string, $setid, $numSets);
    }
    
}
