<?php
/* @var $this ProspectiveController */

    $set = new CurrSet();
    $group = new CurrGroup();
    $setByGroup = new CurrSetByCourse();

    $mySet = $_GET['set'];
    $myGroup = $_GET['group'];


    $setID = $set->find('name=:name', array(':name'=>$mySet));
    $groupID = $group->find('name=:name', array(':name'=>$myGroup));


    $sIDs = $setID->getAttribute('id');
    $gIDs = $groupID->getAttribute('id');

    $command = Yii::app()->db->createCommand();


    $sql='DELETE FROM curr_group_set WHERE set_id=:set_id AND group_id=:group_id';
    $params = array(
        "set_id" => $sIDs,
        "group_id" => $gIDs
    );
    $command->setText($sql)->execute($params);
?>
