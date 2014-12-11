
<?php
/* @var $this ProspectiveController */

$this->breadcrumbs=array(
	'Prospective'=>array('/catalog/prospective'),
	'View',
);
?>
<?php $prospCatId = $_GET['checkProspectiveCat']; ?>
<h1><?php echo 'Prospective Catalog ID: '.$_GET['checkProspectiveCat']; ?></h1>

<h3>Majors Proposed</h3>
<?php
$currMajorModel = new CurrMajor();
$hisMajorModel = new HisMajor();
$majors = $hisMajorModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));
if (!$majors)
{
    echo '<label>Currently there are no proposed majors </label>';
}
else
{
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Major Name </th>';
    echo '<th>Major Information </th>';
    echo '</tr>';

    foreach ($majors as $majorsProposed)
    {
        $major = $majorsProposed->getAttribute('identifier_id');
        $myMajor = $currMajorModel->find('id=:id', array(':id'=>$major));

        $mymajorName = $myMajor->getAttribute('name');
        $parenthesys = '';

        if($myMajor->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$mymajorName.$parenthesys.'</td>';
        echo '<td>';
        echo 'Description: '.$majorsProposed->getAttribute('description').'</br>';

        $majorByTrack = new CurrMajorByTrack();
        $majorId = $major;

        $tracksInMajor = $majorByTrack->findAll('major_id=:major_id', array(':major_id'=>$majorId));

        foreach($tracksInMajor as $track)
        {
            $thisMajorId = $track->getAttribute('track_id');
            $thisTrackModel = new CurrTrack();
            $trackName = $thisTrackModel->find('id=:id', array(':id'=>$thisMajorId))->getAttribute('name');

            echo $trackName.'</br>';
        }
    }
    echo '</td>';
    echo '</tr>';


echo '</table>';
}
?>
</br>
<h3>Minors Proposed</h3>
<?php
$currMinorModel = new CurrMinor();
$hisMinorModel = new HisMinor();
$minors = $hisMinorModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));

if ( !$minors)
{
    echo '<label>Currently there are no proposed minors </label>';
}
else
{
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Minor Name </th>';
    echo '<th>Minor Information </th>';
    echo '</tr>';

    foreach ( $minors as $minorProposed )
    {
        //find name
        $minor = $minorProposed->getAttribute('identifier_id');
        $myMinor= $currMinorModel->find('id=:id', array(':id'=>$minor));

        $myMinorName = $myMinor->getAttribute('name');
        $parenthesys = '';

        if($myMinor->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$myMinorName.$parenthesys.'</td>';
        echo '<td>';
        echo 'Description: '.$minorProposed->getAttribute('description').'</br>';
        echo 'Mininum Credits: '.$minorProposed->getAttribute('minCredits').'</br>';

        $minorByGroup = new CurrMinorGroup();
        $groupsInMinor = $minorByGroup->findAll('minor_id=:minor_id AND catalog_id=:catalog_id', array(':minor_id'=>$myMinor->getAttribute('id'), ':catalog_id'=>$prospCatId));

        foreach ( $groupsInMinor as $git)
        {
            //get id of group
            $currGroup = new CurrGroup();
            $thisgroup= $currGroup->find('id=:id', array(':id'=>$git->getAttribute('group_id')));

            //print name of the group
            echo $thisgroup->getAttribute('name').'</br>';

            //id of the current group to find out its sets
            $thisGroupId = $thisgroup->getAttribute('id');

            $groupBySet = new CurrGroupBySet();
            $theseSets = $groupBySet->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$thisGroupId, ':catalog_id'=>$prospCatId));

            foreach ( $theseSets as $set)
            {
                $setId = $set->getAttribute('set_id');
                $setName = CurrSet::model()->find('id=:id', array( ':id'=>$setId))->getAttribute('name');

                //echo $setName.'</br>';

                $setByCourse = new CurrSetByCourse();
                $theseCourse = $setByCourse->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setId, ':catalog_id'=>$prospCatId));

                foreach( $theseCourse as $course)
                {
                    $courseModel = new CurrCourse();
                    $coursePrefix = new CurrCoursePrefix();
                    $hisCourseModel = new HisCourse();

                    $courseId = $course->getAttribute('course_id');
                    $courseName = $courseModel->find('id=:id', array(':id'=>$courseId))->getAttribute('name');

                    $coursePrefixId = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('coursePrefix_id');
                    $prefixName = $coursePrefix->find('id=:id', array(':id'=>$coursePrefixId))->getAttribute('name');

                    $courseNumber = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('number');

                    echo '-'.$prefixName.' '.$courseNumber.' - '.$courseName.'</br>';
                }
            }

        }
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
?>
</br>
<h3>Certificates Proposed</h3>
<?php
$currCertificateModel = new CurrCertificate();
$hisCertificateModel = new HisCertificate();
$certificates = $hisCertificateModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));

if ( !$certificates)
{
    echo '<label>Currently there are no proposed certificates </label>';
}
else
{
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Certificate Name </th>';
    echo '<th>Certificate Information </th>';
    echo '</tr>';

    foreach ( $certificates as $certificateProposed )
    {
        //find name
        $certificate = $certificateProposed->getAttribute('identifier_id');
        $myCertificate= $currCertificateModel->find('id=:id', array(':id'=>$certificate));

        $myCertificateName = $myCertificate->getAttribute('name');
        $parenthesys = '';

        if($myCertificate->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$myCertificateName.$parenthesys.'</td>';
        echo '<td>';
        echo 'Description: '.$certificateProposed->getAttribute('description').'</br>';
        echo 'Mininum Credits: '.$certificateProposed->getAttribute('minCredits').'</br>';

        $certificateByGroup = new CurrCertificateGroup();
        $groupsInCertificate = $certificateByGroup->findAll('certificate_id=:certificate_id AND catalog_id=:catalog_id', array(':certificate_id'=>$myCertificate->getAttribute('id'), ':catalog_id'=>$prospCatId));

        foreach ( $groupsInCertificate as $git)
        {
            //get id of group
            $currGroup = new CurrGroup();
            $thisgroup= $currGroup->find('id=:id', array(':id'=>$git->getAttribute('group_id')));

            //print name of the group
            echo $thisgroup->getAttribute('name').'</br>';

            //id of the current group to find out its sets
            $thisGroupId = $thisgroup->getAttribute('id');

            $groupBySet = new CurrGroupBySet();
            $theseSets = $groupBySet->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$thisGroupId, ':catalog_id'=>$prospCatId));

            foreach ( $theseSets as $set)
            {
                $setId = $set->getAttribute('set_id');
                $setName = CurrSet::model()->find('id=:id', array( ':id'=>$setId))->getAttribute('name');

                //echo $setName.'</br>';

                $setByCourse = new CurrSetByCourse();
                $theseCourse = $setByCourse->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setId, ':catalog_id'=>$prospCatId));

                foreach( $theseCourse as $course)
                {
                    $courseModel = new CurrCourse();
                    $coursePrefix = new CurrCoursePrefix();
                    $hisCourseModel = new HisCourse();

                    $courseId = $course->getAttribute('course_id');
                    $courseName = $courseModel->find('id=:id', array(':id'=>$courseId))->getAttribute('name');

                    $coursePrefixId = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('coursePrefix_id');
                    $prefixName = $coursePrefix->find('id=:id', array(':id'=>$coursePrefixId))->getAttribute('name');

                    $courseNumber = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('number');

                    echo '-'.$prefixName.' '.$courseNumber.' - '.$courseName.'</br>';
                }
            }

        }
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
?>
</br>
<h3>Tracks Proposed</h3>
<?php
$currTrackModel = new CurrTrack();
$hisTrackModel = new HisTrack();
$tracks = $hisTrackModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));

if ( !$tracks)
{
    echo '<label>Currently there are no proposed tracks </label>';
}
else
{
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Track Name </th>';
    echo '<th>Track Information </th>';
    echo '</tr>';

    foreach ( $tracks as $trackProposed )
    {
        //find name
        $track = $trackProposed->getAttribute('identifier_id');
        $myTrack = $currTrackModel->find('id=:id', array(':id'=>$track));

        $mytrackname = $myTrack->getAttribute('name');
        $parenthesys = '';

        if($myTrack->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$mytrackname.$parenthesys.'</td>';
        echo '<td>';
        echo 'Description: '.$trackProposed->getAttribute('description').'</br>';
        echo 'Mininum Credits: '.$trackProposed->getAttribute('minCredits').'</br>';

        $trackByGroup = new CurrTrackByGroup();
        $groupsInTracks = $trackByGroup->findAll('track_id=:track_id AND catalog_id=:catalog_id', array(':track_id'=>$myTrack->getAttribute('id'), ':catalog_id'=>$prospCatId));

        foreach ( $groupsInTracks as $git)
        {
            //get id of group
            $currGroup = new CurrGroup();
            $thisgroup= $currGroup->find('id=:id', array(':id'=>$git->getAttribute('group_id')));

            //print name of the group
            echo $thisgroup->getAttribute('name').'</br>';

            //id of the current group to find out its sets
            $thisGroupId = $thisgroup->getAttribute('id');

            $groupBySet = new CurrGroupBySet();
            $theseSets = $groupBySet->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$thisGroupId,':catalog_id'=>$prospCatId));

            foreach ( $theseSets as $set)
            {
                $setId = $set->getAttribute('set_id');
                $setName = CurrSet::model()->find('id=:id', array( ':id'=>$setId))->getAttribute('name');

                //echo $setName.'</br>';

                $setByCourse = new CurrSetByCourse();
                $theseCourse = $setByCourse->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$setId,':catalog_id'=>$prospCatId));

                foreach( $theseCourse as $course)
                {
                    $courseModel = new CurrCourse();
                    $coursePrefix = new CurrCoursePrefix();
                    $hisCourseModel = new HisCourse();

                    $courseId = $course->getAttribute('course_id');
                    $courseName = $courseModel->find('id=:id', array(':id'=>$courseId))->getAttribute('name');

                    $coursePrefixId = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('coursePrefix_id');
                    $prefixName = $coursePrefix->find('id=:id', array(':id'=>$coursePrefixId))->getAttribute('name');

                    $courseNumber = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('number');

                    echo '-'.$prefixName.' '.$courseNumber.' - '.$courseName.'</br>';
                }
            }

        }
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
?>

</br>
<h3>Groups Proposed</h3>
<?php
$currGroupModel = new CurrGroup();
$hisGroupModel = new HisGroup();
//find all groups that have been proposed on this catalog
$groups = $hisGroupModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));

if ( !$groups )
{
    echo '<label>Currently there are no proposed groups </label>';
}
else {
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Group Name </th>';
    echo '<th>Group Information </th>';
    echo '</tr>';

    foreach($groups as $groupProposed)
    {
        //find name
        $group = $groupProposed->getAttribute('identifier_id');
        $mygroup = $currGroupModel->find('id=:id', array(':id'=>$group));

        $mygroupname = $mygroup->getAttribute('name');
        $parenthesys = '';

        if($mygroup->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$mygroupname.$parenthesys.'</td>';
        echo '<td>';
        echo 'Description: '.$groupProposed->getAttribute('description').'</br>';
        echo 'Mininum Credits: '.$groupProposed->getAttribute('minCredits').'</br>';
        echo 'Maximum Credits: '.$groupProposed->getAttribute('maxCredits').'</br>';

        $groupbyset = new CurrGroupBySet();
        $setsInGroup = $groupbyset->findAll('group_id=:group_id AND catalog_id=:catalog_id', array(':group_id'=>$mygroup->getAttribute('id'),':catalog_id'=>$prospCatId));
        foreach ( $setsInGroup as $sig)
        {
            $setModel = new CurrSet();
            $thisSet = $setModel->find('id=:id', array(':id'=>$sig->getAttribute('set_id')));
            //print name of set in group
            echo '</br>';
            echo $thisSet->getAttribute('name').'</br>';

            $setByCourse = new CurrSetByCourse();
            $courses = $setByCourse->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$sig->getAttribute('set_id'), ':catalog_id'=>$prospCatId));


            foreach($courses as $course)
            {
                $courseModel = new CurrCourse();
                $coursePrefix = new CurrCoursePrefix();
                $hisCourseModel = new HisCourse();

                $courseId = $course->getAttribute('course_id');
                $courseName = $courseModel->find('id=:id', array(':id'=>$courseId))->getAttribute('name');

                $coursePrefixId = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('coursePrefix_id');
                $prefixName = $coursePrefix->find('id=:id', array(':id'=>$coursePrefixId))->getAttribute('name');
                
                $courseNumber = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('number');

                echo '-'.$prefixName.' '.$courseNumber.' - '.$courseName.'</br>';
            }
            echo '</br>';
        }

        echo '</td>';
        echo '</tr>';


    }
    echo '</table>';
}
?>

</br>
<h3>Sets Proposed</h3>
<?php
$currSetModel = new CurrSet();
$hisSetModel = new HisSet();
$sets = $hisSetModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));

if ( !$sets )
{
    echo '<label>Currently there are no proposed groups </label>';
}
else {
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Set Name </th>';
    echo '<th>Set Information </th>';
    echo '</tr>';

    foreach($sets as $setProposed)
    {
        //find name
        $set = $setProposed->getAttribute('identifier_id');
        $mySet = $currSetModel->find('id=:id', array(':id'=>$set));

        $mygroupname = $mySet->getAttribute('name');
        $parenthesys = '';

        if($mySet->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$mygroupname.$parenthesys.'</td>';
        echo '<td>';
        echo 'Description: '.$setProposed->getAttribute('description').'</br>';
        echo 'Mininum Credits: '.$setProposed->getAttribute('minCredits').'</br>';
        echo 'Maximum Credits: '.$setProposed->getAttribute('maxCredits').'</br>';


        {

            //print name of set in group
            echo '</br>';
            echo 'Courses In Set</br>';

            $setByCourse = new CurrSetByCourse();
            $courses = $setByCourse->findAll('set_id=:set_id AND catalog_id=:catalog_id', array(':set_id'=>$set, ':catalog_id'=>$prospCatId));


            foreach($courses as $course)
            {
                $courseModel = new CurrCourse();
                $coursePrefix = new CurrCoursePrefix();
                $hisCourseModel = new HisCourse();

                $courseId = $course->getAttribute('course_id');
                $courseName = $courseModel->find('id=:id', array(':id'=>$courseId))->getAttribute('name');

                $coursePrefixId = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('coursePrefix_id');
                $prefixName = $coursePrefix->find('id=:id', array(':id'=>$coursePrefixId))->getAttribute('name');

                $courseNumber = $hisCourseModel->find('identifier_id=:identifier_id', array(':identifier_id'=>$courseId))->getAttribute('number');

                echo '-'.$prefixName.' '.$courseNumber.' - '.$courseName.'</br>';
            }
            echo '</br>';
        }

        echo '</td>';
        echo '</tr>';


    }
    echo '</table>';
}
?>

</br>
<h3>Courses Proposed</h3>
<?php
$currCourseModel = new CurrCourse();
$hisCourseModel = new HisCourse();
$courses = $hisCourseModel->findAll('catalog_id=:catalog_id', array(':catalog_id'=>$prospCatId));

if ( !$courses )
{
    echo '<label>Currently there are no proposed courses </label>';
}
else
{
    set_time_limit(100);
    echo '<table style="width:100%">';
    echo '<tr>';
    echo '<th>Course Name </th>';
    echo '<th>Course Information </th>';
    echo '</tr>';

    foreach($courses as $courseProposed)
    {
        $courseId = $courseProposed->getAttribute('identifier_id');
        $coursename = $currCourseModel->find('id=:id', array(':id'=>$courseId));

        if($coursename->getAttribute('catalog_id') == $prospCatId )
            $parenthesys = ' (New)';
        else{
            $parenthesys = ' (Edited)';
        }

        echo '<tr>';
        echo '<td>'.$currCourseModel->find('id=:id', array(':id'=>$courseId))->getAttribute('name').$parenthesys.'</td>';
        echo '<td>';


        {
            $prefix = new CurrCoursePrefix();
            $myPrefix = $prefix->find('id=:id', array(':id'=>$courseProposed->getAttribute('coursePrefix_id')));
            $prefixName = $myPrefix->getAttribute('name');

            echo 'Course ID  : '.$prefixName.' '.$courseProposed->getAttribute('number').'</br>';
            echo 'Credits    : '.$courseProposed->getAttribute('credits').'</br>';
            echo 'Description: '.$courseProposed->getAttribute('abstract').'</br>';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>


<div class="row">
    <?php if ( Yii::app()->getModule('user')->isUserAdmin()) { ?>
    <button class="accept-prospective" id="accept-prospective" onclick="acceptCatalog()">Accept</button>
    <button class="reject-prospective" id="reject-prospective" onclick="rejectCatalog()" >Reject</button>
        <script>
            function acceptCatalog()
            {
                var catno = '<?php echo $_GET['checkProspectiveCat'];?>';

                data = "catno="+encodeURIComponent(catno);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo  Yii::app()->createUrl('catalog/prospective/AcceptCatalog'); ?>',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        //alert('catalog created successfully');
                        alert('Catalog was successfully accepted');

                        //data returned from php
                    },
                    error: function(data){
                        alert('catalog was not proposed');
                    }
                });
            }
            function rejectCatalog()
            {
                var catno = '<?php echo $_GET['checkProspectiveCat'];?>';

                data = "catno="+encodeURIComponent(catno);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RejectCatalog'); ?>',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        //alert('catalog created successfully');
                        alert('Catalog was successfully rejected');

                        //data returned from php
                    },
                    error: function(data){
                        alert('catalog was not proposed');
                    }
                });
            }
        </script>
    <?php } else{ ?>
    <button class="edit-prospective" id="edit-prospective" onclick="goToCreate()" >Edit</button>
    <button class="propose-prospective" id="propose-prospective" onclick="propose()" >Propose</button>
        <script>
            function goToCreate()
            {
                var loc = '<?php echo  Yii::app()->createUrl('catalog/prospective/Create');?>';
                window.location.assign(loc);
            }
            function propose()
            {
                var catno = '<?php echo $_GET['checkProspectiveCat'];?>';

                data = "catno="+encodeURIComponent(catno);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo  Yii::app()->createUrl('catalog/prospective/ProposeCatalogFromView'); ?>',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        //alert('catalog created successfully');
                        alert('Catalog was successfully proposed');

                        //data returned from php
                    },
                    error: function(data){
                        alert('catalog was not proposed');
                    }
                });
            }
        </script>
    <?php }?>
</div>

