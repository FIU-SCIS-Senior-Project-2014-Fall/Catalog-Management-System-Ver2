<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xmlGenerator
 *
 * @author root
 */
class XmlGenerator {
    
    const ENTITY_DGU = 'dgu';
    const ENTITY_MAJOR = 'major';
    const ENTITY_TRACK = 'track';
    const ENTITY_GROUP = 'group';
    const ENTITY_SET = 'set';
    const ENTITY_COURSE = 'course';
    const ENTITY_REQUISITE = 'requisite';
    
    private $catalog;
    private $xml;


    /**
     * Constructor
     * @param type $catalog_id 
     */
    public function XmlGenerator($catalog_id){
                
        $this->catalog = $this->getCatalogInfo($catalog_id);
        
    }
    
    
    public function generateXml($entity, $id){
        
        $this->xml = '<?xml version="1.0" encoding="UTF-8"?>';
        
        $this->xml .= "<catalog>"; //open catalog tag
        $this->parseCatalog();
        $this->xml .= "</catalog>";//close catalog tag
        
        $this->xml .= "<info>"; //open data tag
        $this->recursiveGenerate($entity, $id);
        $this->xml .= "</info>"; //open data tag
        
        return $this->xml;
    }
    
    private function recursiveGenerate($entityName, $id){
        
        $entity = $this->getEntityInfo($entityName, $id);
        
        $this->xml .= "__________________________________________"; //open level
        $this->xml .= "<$entityName>"; //open level
        
        foreach($entity AS $key=>$value){
            $this->xml .= "<$key>";
            foreach($value->metadata->columns AS $attribute){

                //Atomoc Level
                if($attribute->isForeignKey == FALSE){
                    $this->xml .= "<".$attribute->name.">"; 
                    $this->xml .= $value->getAttribute($attribute->name);
                    $this->xml .= "</".$attribute->name.">";
                }
                else{ //Deeper
                    echo $attribute->name."<br/>";
                    if($attribute->name != 'catalog_id' && $attribute->name != 'identifier_id' && $attribute->name != 'course_id'){
                        $this->xml .= '<'.$attribute->name.'>';
                        $this->recursiveGenerate($attribute->name, $value->getAttribute($attribute->name));
                        $this->xml .=  '</'.$attribute->name.'>';
                    }
                }
            }    
            $this->xml .= "</$key>";
        }
        
        
        $this->xml .= "</$entityName>"; // close level
        
        
        
        
    }
    
    private function getEntityInfo($entity, $id){
        
        switch ($entity){
            case self::ENTITY_DGU:
            case 'dgu_id':
                $entity = new Dgu($id,$this->catalog->id);
                return array('identifier'=>$entity->getEntity(), 'data'=>$entity->getHistoryEntity());
            case self::ENTITY_MAJOR;
            case 'major_id':
                $entity = new Major($id, $this->catalog->id);
                return array('identifier'=>$entity->getEntity(), 'data'=>$entity->getHistoryEntity());
            case self::ENTITY_TRACK;
            case 'track_id':
                $entity = new Track($id,$this->catalog->id);
                return array('identifier'=>$entity->getEntity(), 'data'=>$entity->getHistoryEntity());
            case self::ENTITY_GROUP;
            case 'group_id':
                $entity = new Group($id,$this->catalog->id);
                return array('identifier'=>$entity->getEntity(), 'data'=>$entity->getHistoryEntity());
            case self::ENTITY_SET;
            case 'set_id':
                $entity = new Set($id,$this->catalog->id);
                return array('identifier'=>$entity->getEntity(), 'data'=>$entity->getHistoryEntity());
            case self::ENTITY_COURSE;
            case 'course_id':
                $entity = new Course($id,$this->catalog->id);
                return array('identifier'=>$entity->getEntity(), 'data'=>$entity->getHistoryEntity());
//            case self::ENTITY_REQUISITE;
//                $entity = new Course($id,$this->catalog->id);
//                return $entity;
            default :
                return array();
//                throw new Exception ('OA - Level does not exist');
        }
    }
    
    
    
    private function getCatalogInfo($catalog_id){
        
        $catalog= Catalog::model()->findByPk($catalog_id);
        
        if(is_null($catalog))
            throw new Exception('OA - catalog not found');
        
        return $catalog;
        
    }
    
    private function parseCatalog(){
        
        
        //catalog attributes
        foreach ($this->catalog->attributes AS $key=>$value){
            
            $this->xml .= '<'.$key.'>';
            $this->xml .= $value;
            $this->xml .= '</'.$key.'>';
        }
        
        
    }
}

?>
