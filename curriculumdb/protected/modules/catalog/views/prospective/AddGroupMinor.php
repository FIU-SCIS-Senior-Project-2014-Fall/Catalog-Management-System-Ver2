<?php
/* @var $this ProspectiveController */

    $minor = new CurrMinor();
    $group = new CurrGroup();
    $minorByGroup = new CurrMinorGroup();

    $myMinor = $_GET['minor'];
    $myGroup = $_GET['group'];


    $minorID = $minor->find('name=:name', array(':name'=>$myMinor));
    $groupID = $group->find('name=:name', array(':name'=>$myGroup));


    $mIDs = $minorID->getAttribute('id');
    $gIDs = $groupID->getAttribute('id');

    $minorByGroup->minor_id = $mIDs;
    $minorByGroup->group_id = $gIDs;
    $minorByGroup->catalog_id = 0;
    $minorByGroup->save();

?>
