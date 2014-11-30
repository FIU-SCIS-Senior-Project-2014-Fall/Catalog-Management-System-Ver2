<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of CourseInfo
 * 
 * Class used to get course information such as "COP 2210"
 *
 * @author Chris
 */
class CourseFlowInfo {
    
    public function getCourseInfo($n)
    {
        $row = 0;
        $string = array();
        $courseid = array();
        foreach ($n AS $course)
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
        return array($string, $courseid);
    }
    
    
    public function getSetInfo($n)
    {
        $row = 0;
        $string = array();
        $setid = array();
        $setindex = 0;
        foreach ($n AS $set)
        {      
            $sid = $set->setid;
            $courseSet = FlowCourse::model()->findAll(array('order'=>'t.position', 'condition'=>'t.setid=:sid', 'params'=>array(':sid'=>$sid)));
            $index = 0;
            //$setid[$set->position] = $courseSet[$setindex]->setid;
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
        return array($string, $setid, $setindex);
    }
    
    public function getTrackInfo($n)
    {
        $row = 0;
        $string = array(); //store course information
        $groupid = array();
        $groupindex = 0;
        foreach ($n AS $group)
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
        return array($string, $groupid, $setindex, $groupindex);
    }
}
