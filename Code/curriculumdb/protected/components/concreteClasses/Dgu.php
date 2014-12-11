<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dgu
 *
 * @author root
 */
class Dgu extends VersionedEntity {

    public function Dgu($entityId, $catalogId){
        $this->his_tableName = 'his_dgu';
        parent::VersionedEntity($entityId, $catalogId);
    }
    
    public function getHistoryEntity() {
        return $this->entity->hisDgus[0];
        
    }
    public function getHistoryEntities() {
        return HisDgu::model()->findAll('identifier_id=:entityId', array('entityId'=>$this->entity->id));
        
    }
    
    //*************************** FIND *************************************
    //used by constructor
    protected function findEntity($entityId) {        
        
        //SELECT * FOROM curr_dgu, his_dgu 
        //  WHERE id = $entityId AND his_dgu.catalog_id=$$versionId
        $entity = CurrDgu::model()->with('hisDgus')->find('t.id=:entityId AND hisDgus.catalog_id=:versionId',
                array(':entityId'=>$entityId, ':versionId'=> $this->catalog_id ));
        
        //if version does not exists, find the most reasent one
        if(is_null($entity)){
            
            //get the most resent activity
            $mostResentActiveVersion = $this->getMostResentActivatedVersionForEntity($entityId, $this->his_tableName);
            
            
//            SELECT * FOROM curr_dgu, his_dgu 
//              WHERE id = $entityId AND his_dgu.catalog_id=$$versionId
            $entity = CurrDgu::model()->with('hisDgus')->find('t.id=:entityId AND hisDgus.catalog_id=:versionId',
                array(':entityId'=>$entityId, ':versionId'=> $mostResentActiveVersion['id']));
            
        }
        
        return $entity;
    }

    //********************* Update ***********************************
    protected function updateHistoryRecord() {
        $hisRecord = $this->entity->hisDgus[0];
        return $hisRecord->save();
    }
    
    protected function createNewHistoryRecord() {
        
        
        $hisRecord = $this->entity->hisDgus[0];
        $newHisRecord = new HisDgu();
        $newHisRecord->setAttributes($hisRecord->attributes);
        $newHisRecord->unsetAttributes(array('id'));
        $newHisRecord->setIsNewRecord(true);
        $newHisRecord->catalog_id = $this->catalog_id;
        
        
//        $newRecord->attributes = $this->entity->HisDgu[0]->attributes;
//        //declare new
//        $newRecord->isNewRecord = true;
//        //update version
//        $newRecord->catalog_id = $this->catalog_id;
        
        return $newHisRecord->save();
        
        
    }

    
    //************************** NEW **********************************
    protected static function newEntity($currModel, $hisModel) {
        
        // create base
        if($currModel->save()){
            
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
    
    
    
    //**************************** HELPERS *****************************
    protected static function entityExistsCurr($model) {
        return CurrDgu::model()->exists('id=:id', array(':id'=>$model->id));
    }
    protected static function entityExistsHis($model) {
        return HisDgu::model()->exists('id=:id', array(':id'=>$model->id));
    }


    
}
?>