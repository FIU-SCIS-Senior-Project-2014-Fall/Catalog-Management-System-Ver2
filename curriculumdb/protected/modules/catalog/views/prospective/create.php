<style>
    @import url(http://fonts.googleapis.com/css?family=Fauna+One|Muli);
    h3{
        font-size:18px;
        text-align:center;
        text-shadow:1px 0px 3px gray;
    }

    #remove-course, #remove-set, #remove-minor, #remove-certificate, #remove-group, #remove-track
    {
        display :none;
    }

    .prospectiveForm{
        display: inline-block;
        border-radius:2px;
        border: 3px;
        padding:20px 30px;
        box-shadow:0 0 15px;
        font-size:14px;
        font-weight:bold;
        width:350px;
        margin:20px 250px 0 35px;
        float: left;
    }

    .prospective-save-btn{
        background-color:darkblue;
        border:1px solid white;
        font-family: 'Fauna One', serif;
        font-Weight:bold;
        font-size:18px;
        color:white;
        width:49%;
    }

    .prospective-close-btn{
        background-color:slategray;
        border:1px solid white;
        font-family: 'Fauna One', serif;
        font-Weight:bold;
        font-size:18px;
        color:white;
        width:49%;
    }

    textarea{
        width:100%;
        height:80px;
        margin-top:5px;
        border-radius:3px;
        padding:5px;
        resize:none;
    }

    #CourseDiv-0, #MajorDiv-0, #MinorDiv-0, #TrackDiv-0, #CertificateDiv-0, #GroupDiv-0, #SetDiv-0 {
        opacity:0.92;
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;
        background: #ffffff;
        display: none;
    }

    #MajorForm, #MinorForm, #TrackForm, #CertificateForm, #GroupForm, #SetForm, #CourseForm    {
        margin:0px;
        background-color:white;
        font-family: 'Fauna One', serif;
        position: relative;
        border: 5px solid rgb(90, 158, 181);
    }

    #MajorForm{
        width:400px;
        height:350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
     }

    #MinorForm{
        width:400px;
        height:350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
    }

    #TrackForm{
        width:400px;
        height:350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
    }

    #CertificateForm{
        height:400px;
        width:350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
    }

    #GroupForm{
        width:400px;
        height:350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
    }

    #SetForm{
        width:400px;
        height: 350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
    }

    #CourseForm{
        width:400px;
        height: 350px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-175px;
    }


</style>
<script>
    $(document).ready(function() {
        /*Major functions*/
        {
            var no_majors = 0;

            /*closes current major form*/
            var close_major_form = function(){
                $("#MajorDiv-"+no_majors).on("click", "#close-major-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the major on the row*/
            var addMajor = function(){
                $(".major-inputs .add-major").click(function(e){
                   if (e.target !== this)
                   {
                       return;
                   }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentMajorForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out major field name first. It cannot be empty.");
                        return;
                    }

                    $("#MajorDiv-"+currentMajorForm).css("display", "block");
                    $("#MajorDiv-"+currentMajorForm +" #major-name-"+currentMajorForm).val(value);
                });
            }

            addMajor();
            close_major_form();

            /*add row for major with its corresponding major pop up form*/
            $(".add-major-field-rows").click(function(e){
                e.preventDefault();
                ++no_majors;
                var stringMajorForm = '<div id="MajorDiv-'+(no_majors)+'">'+
                                        '<form class="prospectiveForm" action="#" id="MajorForm">' +
                                            '<h3>Major Form</h3>'+
                                            '<label>Major Name </label>'+
                                            '<input type="text" id="major-name-'+no_majors+'" placeholder="Major Name" required readonly/></br>'+
                                            '<label>Number of Pre-requisite Courses: <span>*</span></label>'+
                                            '<input type="number" id="number-of-prereq-in-major-'+no_majors+'" placeholder="Number of courses" required/></br>'+
                                            '<label>Prerequisites <span>*</span></label>'+
                                            '<div id="major-prereq-courses"></div>'+

                                            '<label>Number of Core Courses: <span>*</span></label>'+
                                            '<input type="number" id="number-of-core-in-major-'+no_majors+'" placeholder="Number of courses" required/></br>'+
                                            '<label>Core Courses <span>*</span></label>'+
                                            '<div id="major-core-courses"></div>'+

                                            '<label>Number of Elective Courses: <span>*</span></label>'+
                                            '<input type="number" id="number-of-elective-in-major-'+no_majors+'" placeholder="Number of courses" required/></br>'+
                                            '<label>Electives <span>*</span></label>'+
                                            '<div id="major-elective-courses"></div>'+

                                            '<button class="prospective-save-btn" id="save-major-form">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-major-form">Close</button>'+
                                            '<br/>'+
                                        '</form>'+
                                    '</div>';

                var stringMajorRow = '<div>' +
                                        '<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                        '<button class="add-major" inputId="my-prospective-major-'+ (no_majors) +'" >Add</button>' +
                                        '<button id="edit-major">Edit</button>' +
                                        '<button class="remove-major">Remove</button>' +
                                    '</div>';

                $(".major-inputs").append(stringMajorRow);
                $(".major-inputs").append(stringMajorForm);
                $("#MajorDiv-"+no_majors).css("display", "none");

                /*registers pop up function for dynamically created major forms*/
                addMajor();
                close_major_form();
            });

            /*removes row along with major*/
            $(".major-inputs").on("click", ".remove-major", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_majors--;
            });

            $('#number-of-prereq-in-major').change(function () {
                var noCourses = $(this).val();
                var htmlString = '';
                var proMinorCourse = "<input type=\"text\" id=\"major-course-prereq-prefix\" placeholder=\"Prefix\" size=\"3\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"major-course-prereq-id\" placeholder=\"ID\" size=\"4\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"major-course--prereq-name\" placeholder=\"Course Name\" size=\"40\" required/></br>";
                while (noCourses > 0) {
                    htmlString = htmlString + proMinorCourse;
                    noCourses--;
                }
                $('#major-prereq-courses').html(htmlString);

            });

            $('#number-of-core-in-major').change(function () {
                var noCourses = $(this).val();
                var htmlString = '';
                var proMinorCourse = "<input type=\"text\" id=\"major-course-core-prefix\" placeholder=\"Prefix\" size=\"3\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"major-course-core-id\" placeholder=\"ID\" size=\"4\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"major-course--core-name\" placeholder=\"Course Name\" size=\"40\" required/></br>";
                while (noCourses > 0) {
                    htmlString = htmlString + proMinorCourse;
                    noCourses--;
                }
                $('#major-core-courses').html(htmlString);
            });

            $('#number-of-elective-in-major').change(function () {
                var noCourses = $(this).val();
                var htmlString = '';
                var proMinorCourse = "<input type=\"text\" id=\"major-course-elective-prefix\" placeholder=\"Prefix\" size=\"3\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"major-course-elective-id\" placeholder=\"ID\" size=\"4\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"major-course--elective-name\" placeholder=\"Course Name\" size=\"40\" required/></br>";
                while (noCourses > 0) {
                    htmlString = htmlString + proMinorCourse;
                    noCourses--;
                }
                $('#major-elective-courses').html(htmlString);
            });
        }

        /*Minor functions*/
        {
            var no_minors = 0;

            /*closes current minor form*/
            var close_minor_form = function(){
                $("#MinorDiv-"+no_minors).on("click", "#close-minor-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the minor on the row*/
            var addMinor = function(){
                $(".minor-inputs .add-minor").click(function(e){
                    if (e.target !== this)
                    {
                        return;
                    }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentMinorForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out minor field name first. It cannot be empty.");
                        return;
                    }

                    $("#MinorDiv-"+currentMinorForm).css("display", "block");
                    $("#MinorDiv-"+currentMinorForm +" #minor-name-"+currentMinorForm).val(value);
                });
            }

            addMinor();
            close_minor_form();

            /*add row for minor with its corresponding minor pop up form*/
            $(".add-minor-field-rows").click(function(e){
                e.preventDefault();
                ++no_minors;

                var stringMinorForm = '<div id="MinorDiv-'+(no_minors)+'">' +
                                        '<form class="prospectiveForm" action="#" id="MinorForm">'+
                                            '<h3>Minor Form</h3>'+
                                            '<label>Minor Name </label>'+
                                            '<input type="text" id="minor-name-'+no_minors+'" required readonly/></br>'+
                                            '<label>Number of Courses: <span>*</span></label>'+
                                            '<input type="number" id="number-of-courses-in-minor-'+no_minors+'" placeholder="Number of courses" required/></br>'+
                                            '<label>Courses in the Minor </label>'+
                                            '<div id="minor-courses"></div>'+
                                            '<button class="prospective-save-btn" id="save-minor-form">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-minor-form">Close</button>'+
                                            '<br/>'+
                                        '</form>'+
                                    '</div>';

                var stringMinorRow = '<div>'+
                                        '<input type="text" name="my-prospective-minors[]" id="my-prospective-minor-'+no_minors+'"/>'+
                                        '<button class="add-minor" inputId="my-prospective-minor-'+no_minors+'">Add</button>'+
                                        '<button id="edit-minor">Edit</button>'+
                                        '<button id="remove-minor">Remove</button>'+
                                    '</div>';

                $(".minor-inputs").append(stringMinorRow);

                $(".minor-inputs").append(stringMinorForm);
                $("#MinorDiv-"+no_minors).css("display", "none");

                /*registers pop up function for dynamically created minor forms*/
                addMinor();
                close_minor_form();
            });

            /*removes row along with minor*/
            $(".minor-inputs").on("click", ".remove-minor", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_minors--;
            });

            $('#number-of-courses-in-minor').change(function () {
                var noMinorCourses = $(this).val();
                var htmlString = '';
                var proMinorCourse = "<input type=\"text\" id=\"minor-course-prefix\" placeholder=\"Prefix\" size=\"3\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"minor-course-id\" placeholder=\"ID\" size=\"4\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"minor-course-name\" placeholder=\"Course Name\" size=\"40\" required/></br>";
                while (noMinorCourses > 0) {
                    htmlString = htmlString + proMinorCourse;
                    noMinorCourses--;
                }
                $('#minor-courses').html(htmlString);
            });
        }

        /*Track functions*/
        {
            var no_tracks = 0;

            /*closes track minor form*/
            var close_track_form = function(){
                $("#TrackDiv-"+no_tracks).on("click", "#close-track-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the track on the row*/
            var addTrack = function(){
                $(".track-inputs .add-track").click(function(e){
                    if (e.target !== this)
                    {
                        return;
                    }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentTrackForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out track field name first. It cannot be empty.");
                        return;
                    }

                    $("#TrackDiv-"+currentTrackForm).css("display", "block");
                    $("#TrackDiv-"+currentTrackForm +" #track-name-"+currentTrackForm).val(value);
                });
            }

            addTrack();
            close_track_form();

            /*add row for minor with its corresponding minor pop up form*/
            $(".add-track-field-rows").click(function(e){
                e.preventDefault();
                ++no_tracks;

                var stringTrackForm = '<div id="TrackDiv-'+no_tracks+'">'+
                                            '<form class="prospectiveForm" action="#" id="TrackForm">'+
                                            '<h3>Track Form</h3>'+
                                            '<label>Track Name </label>'+
                                            '<input type="text" id="track-name-'+no_tracks+'" placeholder="Track Name" required readonly/></br>'+
                                            '<button class="prospective-save-btn" id="save-track-form">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-track-form">Close</button>'+
                                            '<br/>'+
                                            '</form>'+
                                        '</div>';

                var stringTrackRow = '<div>'+
                                        '<input type="text" name="my-prospective-tracks[]" id="my-prospective-track-'+no_tracks+'"/>'+
                                        '<button class="add-track" inputId="my-prospective-track-'+no_tracks+'">Add</button>'+
                                        '<button id="edit-track">Edit</button>'+
                                        '<button id="remove-track">Remove</button>'+
                                    '</div>';

                $(".track-inputs").append(stringTrackRow);

                $(".track-inputs").append(stringTrackForm);
                $("#TrackDiv-"+no_tracks).css("display", "none");

                /*registers pop up function for dynamically created minor forms*/
                addTrack();
                close_track_form();
            });

            /*removes row along with minor*/
            $(".track-inputs").on("click", ".remove-track", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_tracks--;
            });
        }

        /*Certificate functions*/
        {
            $('#add-certificate').click(function () {
                var field = $.trim($('#prospective-certificate-name').val());
                if (field.length === 0) {
                    alert('Prospective certificate name cannot be empty!!!');
                    return
                }
                $('#add-certificate').hide();
                $('#remove-certificate').show();
                $('#CertificateDiv').css("display", "block");
                $('#certificate-name').val($('#prospective-certificate-name').val());
            });

            $('#remove-certificate').click(function () {
                $('#add-certificate').show();
                $('#remove-certificate').hide();
            });

            $("#close-certificate-form").click(function () {
                $("#CertificateDiv").css("display", "none");
                $("#add-certificate").show();
                $("#remove-certificate").hide();
            });
        }

        /*Group functions*/
        {
            $('#add-group').click(function () {
                var field = $.trim($('#prospective-group-name').val());
                if (field.length === 0) {
                    alert('Prospective group name cannot be empty!!!');
                    return
                }
                $('#add-group').hide();
                $('#remove-group').show();
                $('#GroupDiv').css("display", "block");
                $('#group-name').val($('#prospective-group-name').val());
            });

            $('#remove-group').click(function () {
                $('#add-group').show();
                $('#remove-group').hide();
            });

            $("#close-group-form").click(function () {
                $("#GroupDiv").css("display", "none");
                $("#add-group").show();
                $("#remove-group").hide();
            });

            $('#number-of-courses-in-group').change(function () {
                var noMinorCourses = $(this).val();
                var htmlString = '';
                var proMinorCourse = "<input type=\"text\" id=\"group-course-prefix\" placeholder=\"Prefix\" size=\"3\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"group-course-id\" placeholder=\"ID\" size=\"4\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"group-course-name\" placeholder=\"Course Name\" size=\"40\" required/></br>";
                while (noMinorCourses > 0) {
                    htmlString = htmlString + proMinorCourse;
                    noMinorCourses--;
                }
                $('#group-courses').html(htmlString);
            });
        }

        /*Sets functions*/
        {
            $('#add-set').click(function () {
                var field = $.trim($('#prospective-set-name').val());
                if (field.length === 0) {
                    alert('Prospective set name cannot be empty!!!');
                    return
                }
                $('#add-set').hide();
                $('#remove-set').show();
                $('#SetDiv').css("display", "block");
                $('#set-name').val($('#prospective-set-name').val());
            });

            $('#remove-set').click(function () {
                $('#add-set').show();
                $('#remove-set').hide();
            });

            $("#close-set-form").click(function () {
                $("#SetDiv").css("display", "none");
                $("#add-set").show();
                $("#remove-set").hide();
            });

            $('#number-of-courses-in-set').change(function () {
                var noMinorCourses = $(this).val();
                var htmlString = '';
                var proMinorCourse = "<input type=\"text\" id=\"set-course-prefix\" placeholder=\"Prefix\" size=\"3\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"set-course-id\" placeholder=\"ID\" size=\"4\" required/>";
                proMinorCourse = proMinorCourse + "<input type=\"text\" id=\"set-course-name\" placeholder=\"Course Name\" size=\"40\" required/></br>";
                while (noMinorCourses > 0) {
                    htmlString = htmlString + proMinorCourse;
                    noMinorCourses--;
                }
                $('#set-courses').html(htmlString);
            });
        }

        /*Course functions*/
        {
            $('#add-course').click(function () {

                var field = $.trim($('#prospective-course-name').val());
                if (field.length === 0) {
                    alert('Prospective course name cannot be empty!!!');
                    return
                }
                $('#add-course').hide();
                $('#remove-course').show();
                $('#CourseDiv').css("display", "block");
                $('#course-name').val($('#prospective-course-name').val());


            });

            $('#edit-course').click(function () {
                alert('Please edit the following file');
            });

            $('#remove-course').click(function () {
                $('#add-course').show();
                $('#remove-course').hide();
            });

            $("#close-course-form").click(function () {
                $("#CourseDiv").css("display", "none");
                $("#add-course").show();
                $("#remove-course").hide();
            });
        }

        /*tables trials*/
        {
            $('#course-table').jtable({
                title: 'Table of people',
                actions: {}, /*
                 listAction: '/GettingStarted/PersonList',
                 createAction: '/GettingStarted/CreatePerson',
                 updateAction: '/GettingStarted/UpdatePerson',
                 deleteAction: '/GettingStarted/DeletePerson'
                 },*/
                fields: {
                    PersonId: {
                        key: true,
                        list: false
                    },
                    Name: {
                        title: 'Author Name',
                        width: '40%'
                    },
                    Age: {
                        title: 'Age',
                        width: '20%'
                    },
                    RecordDate: {
                        title: 'Record date',
                        width: '30%',
                        type: 'date',
                        create: false,
                        edit: false
                    }
                }
            });

            //Load student list from server
            $('#course-table').jtable('load');


            /*
             jQuery("#course-table").jqGrid({
             datatype: "xml",
             colNames:['Index','Prefix', 'ID', 'Name','Description'],
             colModel:[
             {name:'id',index:'id', width:55, editable:false, editoptions:{readonly:true,size:10}},
             {name:'prefix',index:'prefix', width:90, editable:true,editoptions:{size:10}},
             {name:'courseid',index:'courseid', width:80, align:"right",editable:true,editoptions:{size:10}},
             {name:'name',index:'name', width:80, align:"right",editable:true,editoptions:{size:10}},
             {name:'description',index:'description', width:255,align:"right",editable:true,editoptions:{size:10}}
             ],
             rowNum:10,
             rowList:[10,20,30],
             pager: '#prospective-course-pager',
             sortname: 'id',
             viewrecords: true,
             sortorder: "des",
             editurl: "server.php",
             caption: "Prospective Course"
             });

             $("#course-table").jqGrid('navGrid','#prospective-course-pager',{},{width:300});

             jQuery("#course-table")
             .navGrid('#prospective-course-pager',{edit:true,add:true,del:true,search:true}, {width:300})
             .navButtonAdd('#prospective-course-pager',{
             caption:"Add",
             onClickButton: function(){
             alert("Adding Row");
             },
             position:"last"
             })
             .navButtonAdd('#prospective-course-pager',{
             caption:"Del",
             onClickButton: function(){
             alert("Deleting Row");
             },
             position:"last"
             });*/
        }

});
</script>

<?php
/* @var $this ProspectiveController */
/* @var $model Catalog */
/* @var $form CActiveForm*/

    

    $this->breadcrumbs=array(
	'Prospective'=>array('/catalog/prospective'),
	'Create',
    );
    
    $dgus = $dgu->findAllBySql("select name from curr_dgu");
    $data = array();

/*foreach($users as $u){
    $data[$u->name] = $u->name;
}*/
?>




<div class="form">
    <?php  /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'prospective-catalog-form',
	'enableAjaxValidation'=>true,
    'enableClientValidation' =>true,
));*/ ?>
    
    <?php /*echo $form->errorSummary($model);*/ ?>

<!-- MAIN FORM --->
    <div class="contentContainer">
            <div class="row">
                    <label>Select Your DGU</label>
                    <select id="dguSelected">
                        <?php
                        foreach($dgus as $row)
                        {
                            $r1 = $row['name'];
                            echo "<option value='$r1'> $r1 </option>";
                        }
                        ?>
                    </select>
            </div>
        
            <div class="row">
                <label>Catalog Name</label>
                <input type="text" name="prospective-catalog-name"/>
            </div>
        
            <div class="row">
                <div>
                    <label>Add Majors</label>
                    <button class="add-major-field-rows">+</button>
                </div>
                <div class="major-inputs">
                    <div>
                        <input type="text" name="my-prospective-majors[]" id="my-prospective-major-0">
                        <button class="add-major" inputId="my-prospective-major-0">Add</button>
                        <button id="edit-major">Edit</button>
                        <button id="remove-major">Remove</button>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <label>Add Minors</label>
                <button class="add-minor-field-rows">+</button>
                <div class="minor-inputs">
                    <div>
                        <input type="text" name="my-prospective-minors[]" id="my-prospective-minor-0"/>
                        <button class="add-minor" inputId="my-prospective-minor-0">Add</button>
                        <button id="edit-minor">Edit</button>
                        <button id="remove-minor">Remove</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <label>Add Tracks</label>
                <button class="add-track-field-rows">+</button>
                <div class="track-inputs">
                    <div>
                        <input type="text" name="my-prospective-tracks[]" id="my-prospective-track-0"/>
                        <button class="add-track" inputId="my-prospective-track-0">Add</button>
                        <button id="edit-track">Edit</button>
                        <button id="remove-track">Remove</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <label>Add Certificates</label>
                <button class="add-certificate-field-rows">+</button>
                <div class="certificate-inputs">
                    <div>
                        <input type="text" name="my-prospective-certificates[]" id="my-prospective-certificate-0"/>
                        <button class="add-certificate" inputId="my-prospective-certificate-0">Add</button>
                        <button id="edit-certificate">Edit</button>
                        <button id="remove-certificate">Remove</button>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <label>Add Groups</label>
                <button class="add-group-field-rows">+</button>
                <div class="group-inputs">
                    <div>
                        <input type="text" name="my-prospective-groups[]" id="prospective-group-name"/>
                        <button class="add-group" inputId="my-prospective-group-0">Add</button>
                        <button id="edit-group">Edit</button>
                        <button id="remove-group">Remove</button>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <label>Add Sets</label>
                <button class="add-set-field-rows">+</button>
                <div class="set-inputs">
                    <div>
                        <input type="text" name="my-prospective-sets[]" id="prospective-set-name"/>
                        <button class="add-set" inputId="my-prospective-set-0">Add</button>
                        <button id="edit-set">Edit</button>
                        <button id="remove-set">Remove</button>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <label>Add Courses</label>
                <button class="add-course-field-rows">+</button>
                <div class="course-inputs">
                    <div>
                        <input type="text" name="my-prospective-courses[]" id="prospective-course-name"/>
                        <button class="add-course" inputId="my-prospective-course-0">Add</button>
                        <button id="edit-course">Edit</button>
                        <button id="remove-course">Remove</button>
                    </div>
                </div>
            </div>

            <div>
                <?php /*echo CHtml::ajaxButton ("Update data",
                    array('/catalog/prospective/courseProspectiveForm', array()),
                    array('update' => '#data'));*/
                ?>
            </div>


            <div class="row buttons">
                    <?php echo CHtml::submitButton('Create'); ?>
            </div>


 
    <?php /*$this->endWidget();*/ ?>
  </div><!-- form -->

    <!-- Major Form -->
    <div id="MajorDiv-0">
        <form class="prospectiveForm" action="#" id="MajorForm">
            <h3>Major Form</h3>
            <label>Major Name </label>
            <input type="text" id="major-name-0" placeholder="Major Name" required readonly/></br>
            <label>Number of Pre-requisite Courses: <span>*</span></label>
            <input type="number" id="number-of-prereq-in-major-0" placeholder="Number of courses" required/></br>
            <label>Prerequisites <span>*</span></label>
            <div id="major-prereq-courses"></div>

            <label>Number of Core Courses: <span>*</span></label>
            <input type="number" id="number-of-core-in-major-0" placeholder="Number of courses" required/></br>
            <label>Core Courses <span>*</span></label>
            <div id="major-core-courses"></div>

            <label>Number of Elective Courses: <span>*</span></label>
            <input type="number" id="number-of-elective-in-major-0" placeholder="Number of courses" required/></br>
            <label>Electives <span>*</span></label>
            <div id="major-elective-courses"></div>

            <button class="prospective-save-btn" id="save-major-form">Save</button>
            <button class="prospective-close-btn" id="close-major-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Minor Form -->
    <div id="MinorDiv-0">
        <form class="prospectiveForm" action="#" id="MinorForm">
            <h3>Minor Form</h3>
            <label>Minor Name </label>
            <input type="text" id="minor-name-0" required readonly/></br>
            <label>Number of Courses: <span>*</span></label>
            <input type="number" id="number-of-courses-in-minor-0" placeholder="Number of courses" required/></br>
            <label>Courses in the Minor </label>
            <div id="minor-courses"></div>
            <button class="prospective-save-btn" id="save-minor-form">Save</button>
            <button class="prospective-close-btn" id="close-minor-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Track Form -->
    <div id="TrackDiv-0">
        <form class="prospectiveForm" action="#" id="TrackForm">
            <h3>Track Form</h3>
            <label>Track name </label>
            <input type="text" id="track-name-0" placeholder="track Name" required readonly/></br>
            <button class="prospective-save-btn" id="save-track-form">Save</button>
            <button class="prospective-close-btn" id="close-track-form">Close</button>
            <br/>
        </form>
    </div>


    <!-- Certificate Form -->
    <div id="CertificateDiv-0">
        <form class="prospectiveForm" action="#" id="CertificateForm">
            <h3>Certificate Form</h3>
            <label>Certificate Name </label>
            <input type="text" id="certificate-name-0" placeholder="Certificate Name" required readonly/></br>
            <button class="prospective-save-btn" id="save-certificate-form">Save</button>
            <button class="prospective-close-btn" id="close-certificate-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Group Form -->
    <div id="GroupDiv-0">
        <form class="prospectiveForm" action="#" id="GroupForm">
            <h3>Group Form</h3>
            <label>Group Name: </label>
            <input type="text" id="group-name-0" placeholder="Group Name" required readonly/></br>
            <label>Number of Courses: <span>*</span></label>
            <input type="number" id="number-of-courses-in-group-0" placeholder="Number of courses" required/></br>
            <label>Courses in the Group </label>
            <div id="group-courses"></div>
            <button class="prospective-save-btn" id="save-group-form">Save</button>
            <button class="prospective-close-btn" id="close-group-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Set Form -->
    <div id="SetDiv-0">
        <form class="prospectiveForm" action="#" id="SetForm">
            <h3>Set Form</h3>
            <label>Set Name: </label>
            <input type="text" id="set-name-0" placeholder="Set Name" required readonly/></br>
            <label>Select your Group</label>
            <select id="group-selected">
                <?php
                $groups = $group->findAllBySql("select name from curr_group");
                $data = array();

                foreach($groups as $row)
                {
                    $r1 = $row['name'];
                    echo "<option value='$r1'> $r1 </option>";
                }
                ?>
            </select>
            <label>Number of Courses: <span>*</span></label>
            <input type="number" id="number-of-courses-in-set-0" placeholder="Number of courses" required/></br>
            <label>Courses in the Set </label>
            <div id="set-courses"></div>
            <button class="prospective-save-btn" id="save-set-form">Save</button>
            <button class="prospective-close-btn" id="close-set-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Course Form -->
    <div id="CourseDiv-0">
        <form class="prospectiveForm" action="#" id="CourseForm">
            <h3>Course Form</h3>
            <label>Prefix: <span>*</span></label>
            <input type="text" id="course-prefix-0" placeholder="Course Prefix" required/></br>
            <label>Code: <span>*</span></label>
            <input type="text" id="course-code-0" placeholder="Course Code" required/></br>
            <label>Name: </label>
            <input type="text" id="course-name-0" placeholder="Course Name" required readonly/></br>
            <label>Description: <span>*</span></label>
            <input type="text" id="course-description-0" placeholder="Course Description" required readonly/></br>
            <button class="prospective-save-btn" id="save-course-form">Save</button>
            <button class="prospective-close-btn" id="close-course-form">Close</button>
            <br/>
        </form>
    </div>




  

   
            
        
            
        