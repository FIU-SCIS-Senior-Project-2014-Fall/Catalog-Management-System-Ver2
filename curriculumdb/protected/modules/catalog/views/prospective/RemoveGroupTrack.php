<?php
/* @var $this ProspectiveController */

    $track = new CurrTrack();
    $group = new CurrGroup();
    $trackByGroup = new CurrTrackByGroup();

    $myTrack = $_GET['track'];
    $myGroup = $_GET['group'];


    $trackID = $track->find('name=:name', array(':name'=>$myTrack));
    $groupID = $group->find('name=:name', array(':name'=>$myGroup));


    $tIDs = $trackID->getAttribute('id');
    $gIDs = $groupID->getAttribute('id');

    $command = Yii::app()->db->createCommand();


    $sql='DELETE FROM curr_track_group WHERE track_id=:track_id AND group_id=:group_id';
    $params = array(
        "track_id" => $tIDs,
        "group_id" => $gIDs
    );
    $command->setText($sql)->execute($params);
?>
