<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VersionedEntity
 *
 * @author root
 */
abstract class VersionedEntity {
    
    protected $entity;
    protected $catalog;
    protected $catalog_id;
    protected $entityType;
    protected $his_tableName;


    /*
     * constructor
     */
    protected function VersionedEntity($entityId, $catalogId){
        
        
        $this->catalog_id = $catalogId;
        $this->catalog = Catalog::model()->findByPk($catalogId);
        //initialize
        $this->init($entityId);
    }
    
    /*
     * private init
     */
    private function init($entityId){
        
        $this->entity = $this->findEntity($entityId);
        
//        if($this->entity == NULL)
//            throw new Exception('check that you have an ephoc catalog and data on all the entities.');
    }
    
    /*
     * public getEntity
     */
    public function getEntity(){
        return $this->entity;
    }
    
    public function updateData(){
        
        //if activated save directly
        if ($this->catalog->activated == 1){
            echo "<h2> catalog activated-></h2>";
            $this->updateHistoryRecord();
        }
        else{
            echo "<h2> catalog NOT activated-></h2>";
            if($this->doesEntityBelongsToCurrentVersion()){
                echo "<h2> Update</h2>";
                $this->updateHistoryRecord();
            }
            else {echo "<h2> New</h2>";
                $this->createNewHistoryRecord();
            }
            
        }
    }
    
    public function deleteOrRevertEntity(){
        
        $hisEntity = $this->getHistoryEntity();
        
        if(!Yii::app()->getModule('catalog')->isCatalogActivated($hisEntity->catalog_id)){
            
            if($this->getHisCount() <= 1)
                return $this->deleteEntity();
            else
                return $this->revertEntity();
        }
        else
            return false;
    }
    
    private function deleteEntity(){
        if($this->getHistoryEntity()->delete())
            return $this->entity->delete();
        else
            return false;
    }
    private function revertEntity(){
        return $this->getHistoryEntity()->delete();
    }
    
    
    
    public static function createNewEntity($currModel, $hisModel){

        if(static::entityExistsCurr($currModel))
            throw new Exception('Entity exist, dont override it. use different id');
        
                
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
    
    //******************************** HELPERS ********************************
    
    protected function getMostResentActivatedVersionForEntity($entityId){
        
        $sql = 'SELECT DISTINCT id FROM catalog WHERE '.
                    'activated=1 AND id IN'.
                            '(SELECT catalog_id FROM '.$this->his_tableName.' WHERE '.
                                'identifier_id= :identifier)'.
                    ' ORDER BY startingDate;';
        
        $result = Yii::app()->db->createCommand($sql)->query(
                    array(':identifier'=>$entityId));
        
        return $result->read();
            
    }
    
//    public static function getActivatedVersionForEntity($entityId){
//        
//        $sql = 'SELECT DISTINCT id FROM catalog WHERE '.
//                    'activated=1 AND id IN'.
//                            '(SELECT catalog_id FROM '.$this->his_tableName.' WHERE '.
//                                'identifier_id= :identifier)'.
//                    ' ORDER BY startingDate;';
//        
//        $result = Yii::app()->db->createCommand($sql)->query(
//                    array(':identifier'=>$entityId));
//        
//        return $result->read();
//            
//    }
//    
    private function doesEntityBelongsToCurrentVersion(){
        $sql = 'SELECT * FROM '.$this->his_tableName.' WHERE '.
                    'catalog_id = :catalog_id';
        
            return Yii::app()->db->createCommand($sql)->execute(array(':catalog_id'=>  $this->catalog_id));
        
    }
    
    
    public function getArrEntity(){
        $entityIdentifier = $this->entity;
        $entityData = $this->getHistoryEntity();
        
        $arrEntity = array_merge( array('type'=>$this->entityType), 
                                    $entityIdentifier->attributes, 
                                    $entityData->attributes);
        
        return $arrEntity;
        
    }
    
    private function getHisCount(){
        $histEntities = $this->getHistoryEntities();
        return count($histEntities);
    }
    
    
    //******************************* ABSTRACTS *****************************


    protected abstract function findEntity($entityId);
    
    protected abstract function updateHistoryRecord();
    
    protected abstract function createNewHistoryRecord();
    
    public abstract function getHistoryEntity();
    
    public abstract function getHistoryEntities();

    //*********** HELPERS ********
    //protected abstract static function entityExistsCurr($model);
    
    //protected abstract static function entityExistsHis($model);
}

?>
