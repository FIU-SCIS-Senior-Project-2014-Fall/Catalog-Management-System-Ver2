<?php
/* @var $this ProspectiveController */

        $major = new CurrMajor();
        $track = new CurrTrack();
        $majorByTrack = new CurrMajorByTrack();

        $myMajor = $_GET['major'];
        $myTrack = $_GET['track'];


        $majorID = $major->find('name=:name', array(':name'=>$myMajor));
        $trackID = $track->find('name=:name', array(':name'=>$myTrack));


        $mIDs = $majorID->getAttribute('id');
        $tIDs = $trackID->getAttribute('id');

        $command = Yii::app()->db->createCommand();

        $sql='DELETE FROM curr_major_track WHERE major_id=:major_id AND track_id=:track_id';
        $params = array(
            "major_id" => $mIDs,
            "track_id" => $tIDs
        );
        $command->setText($sql)->execute($params);


?>