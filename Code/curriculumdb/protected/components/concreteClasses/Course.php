<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Course
 *
 * @author root
 */
class Course extends VersionedEntity {
    /**
     * Constructor
     * 
     * @param type $entityId
     * @param type $catalogId 
     */
    public function Course($entityId, $catalogId){
        $this->his_tableName = 'his_course';
        parent::VersionedEntity($entityId, $catalogId);
    }
    
    public function getHistoryEntity() {
        return $this->entity->hisCourses[0];
        
    }
    public function getHistoryEntities() {
        return HisCourse::model()->findAll('identifier_id=:entityId', array('entityId'=>$this->entity->id));
        
    }

    //*************************** FIND ENTITY *************************************
    
        /**
     * Finds an entity of the table with the most recent history.
     * It is used by a wrapper on the parent class to set the member entity.
     * 
     * @param type $entityId
     * @return AR entity with most recent history
     */
    protected function findEntity($entityId) {              
        //SELECT * FOROM curr_table, his_table 
        //  WHERE id = $entityId AND his_table.catalog_id=$$versionId
        $entity = CurrCourse::model()->with('hisCourses')
        	->find('t.id=:entityId AND hisCourses.catalog_id=:versionId',
                array(':entityId'=>$entityId, ':versionId'=> $this->catalog_id ));
            
        //if version of history does not exists, find the most reasent one
        if(is_null($entity)){            
            //get the most resent active version on the his_table
        	$mostResentActiveVersion = 
        		$this->getMostResentActivatedVersionForEntity(
        								$entityId, $this->his_tableName);
                      
            //SELECT * FOROM curr_table, his_table
            // WHERE id=$entityId AND his_table.catalog_id=$mostResentActiveVersion['id']
            $entity = CurrCourse::model()->with('hisCourses')
            	->find('t.id=:entityId AND hisCourses.catalog_id=:versionId',
                	array(':entityId'=>$entityId, 
                		  ':versionId'=> $mostResentActiveVersion['id']));
        }
        
        //Return the entity Active Record
        return $entity;
    }
    
    
    //********************* UPDATE ENTITY ***********************************
    
    /**
     * Updates the entity WITHOUT CREATING a new history record
     * @return BOOLEAN
     */
    protected function updateHistoryRecord() {
        $hisRecord = $this->entity->hisCourses[0];
        return $hisRecord->save();
    }
    
     /**
     * Updates the entity CREATING a new history record
     * @return BOOLEAN
     */
    protected function createNewHistoryRecord() {
        
        $hisRecord = $this->entity->hisCourses[0];
        $newHisRecord = new HisCourse();
        $newHisRecord->setAttributes($hisRecord->attributes);
        $newHisRecord->unsetAttributes(array('id'));
        $newHisRecord->setIsNewRecord(true);
        $newHisRecord->catalog_id = $this->catalog_id;
        
        return $newHisRecord->save();
        
        
    }

    
    //************************** NEW ENTITY **********************************
    
    /**
     * Creates a new entity (saves to database)
     * creates the identifier record (curr_table), and then the data (his_table)
     * @param AR $currModel
     * @param AR $hisModel
     * @return int Id of new entity
     * @throws Exception
     */
    protected static function newEntity($currModel, $hisModel) {
        
        // create identifier (base)
        if($currModel->save()){
            
            //This will be an error when the current model is reset. The history
            //data will be larger than the current. At some point the current
            //will be reset to make a new catalog, at that point, new courses
            //cannot be added. (TD)
            $hisModel->identifier_id = $currModel->id;
            
            if($hisModel->save()){
                return $currModel->id;
            }
            else{
                throw new Exception("cannot create hisModel for identifier: ".$currModel->id);
            }
        }
        else{
            throw new Exception("cannot create currModel");
        }
        
    }
    
    
    //**************************** HELPER FUNCTIONS *****************************
    
    /**
     * 
     * @param AR $model 
     */
    protected static function entityExistsCurr($model) {
       return CurrCourse::model()->exists('id=:id', array(':id'=>$model->id));
    }
    protected static function entityExistsHis($model) {
        return HisCourse::model()->exists('id=:id', array(':id'=>$model->id));
    }

}

?>

