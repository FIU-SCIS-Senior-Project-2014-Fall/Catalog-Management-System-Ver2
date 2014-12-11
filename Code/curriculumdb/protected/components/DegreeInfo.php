<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Helper class for major and track.
 * 
 * DegreeInfo is a class that represents a track, along with the 
 * corresponding major and catalog. 
 *
 * @author Oscar Aparacio
 * 
 */
class degreeInfo{
    private $major;
    private $track;
    private $trackId;
    private $term;
    
    /**
     * Create a DegreeInfo object
     * 
     * DegreeInfo is a class that represents a track, along with the 
     * corresponding major and catalog. 
     * 
     * @param int $majorId  The id for the major in the CurrMajor model.
     * @param int $trackId The id for the track in the CurrTrack model.
     * @param int $termId The id for the catalog that has the track.
     */
    public function DegreeInfo($majorId, $trackId, $termId){
        
        $this->major = CurrMajor::model()->findByPk($majorId);
        $this->track = CurrTrack::model()->findByPk($trackId);
        $this->trackId = $trackId;
        $this->term= $termId;
        
    }
    
    public function getGroups(){
        return CurrTrackByGroup::model()->with('group')->findAll(
                'track_id=:trackId',
                array('trackId'=>  $this->trackId));
    }
    
    public function getMajor() {
        return $this->major;
    }

    public function getTrack() {
        return $this->track;
    }

    public function getTerm() {
        return $this->term;
    }


}

?>
