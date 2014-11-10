<?php
/* @var $this ProspectiveController */

    $minor = new CurrMinor();
    $group = new CurrGroup();
    $minorByGroup = new CurrMajorByTrack();

    $myMinor = $_GET['minor'];
    $myGroup = $_GET['group'];


    $minorID = $minor->find('name=:name', array(':name'=>$myMinor));
    $groupID = $group->find('name=:name', array(':name'=>$myGroup));


    $mIDs = $minorID->getAttribute('id');
    $gIDs = $groupID->getAttribute('id');

    $command = Yii::app()->db->createCommand();

    $sql='DELETE FROM curr_minor_group WHERE minor_id=:minor_id AND group_id=:group_id';
    $params = array(
        "minor_id" => $mIDs,
        "group_id" => $gIDs
    );
    $command->setText($sql)->execute($params);


?>