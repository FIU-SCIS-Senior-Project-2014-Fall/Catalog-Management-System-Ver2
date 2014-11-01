<style>
    @import url(http://fonts.googleapis.com/css?family=Fauna+One|Muli);
    h3{
        font-size:18px;
        text-align:center;
        text-shadow:1px 0px 3px gray;
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
                $("#MajorDiv-"+no_majors).css({"opacity":"0.92",
                                                "position": "absolute",
                                                "top": "0px",
                                                "left": "0px",
                                                "height": "100%",
                                                "width": "100%",
                                                "background": "#ffffff",
                                                "display": "none"});

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
                                        '<button class="remove-minor">Remove</button>'+
                                    '</div>';

                $(".minor-inputs").append(stringMinorRow);

                $(".minor-inputs").append(stringMinorForm);
                $("#MinorDiv-"+no_minors).css({"opacity":"0.92",
                                                "position": "absolute",
                                                "top": "0px",
                                                "left": "0px",
                                                "height": "100%",
                                                "width": "100%",
                                                "background": "#ffffff",
                                                "display": "none"});

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
                                        '<button class="remove-track">Remove</button>'+
                                    '</div>';

                $(".track-inputs").append(stringTrackRow);

                $(".track-inputs").append(stringTrackForm);
                $("#TrackDiv-"+no_tracks).css({"opacity":"0.92",
                                                "position": "absolute",
                                                "top": "0px",
                                                "left": "0px",
                                                "height": "100%",
                                                "width": "100%",
                                                "background": "#ffffff",
                                                "display": "none"});

                /*registers pop up function for dynamically created track forms*/
                addTrack();
                close_track_form();
            });

            /*removes row along with track*/
            $(".track-inputs").on("click", ".remove-track", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_tracks--;
            });
        }

        /*Certificate functions*/
        {
            var no_certificates = 0;

            /*closes certificate form*/
            var close_certificate_form = function(){
                $("#CertificateDiv-"+no_certificates).on("click", "#close-certificate-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the certificate on the row*/
            var addCertificate = function(){
                $(".certificate-inputs .add-certificate").click(function(e){
                    if (e.target !== this)
                    {
                        return;
                    }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentCertificateForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out certificate field name first. It cannot be empty.");
                        return;
                    }

                    $("#CertificateDiv-"+currentCertificateForm).css("display", "block");
                    $("#CertificateDiv-"+currentCertificateForm +" #certificate-name-"+currentCertificateForm).val(value);
                });
            }

            addCertificate();
            close_certificate_form();

            /*add row for certficate with its corresponding certificate pop up form*/
            $(".add-certificate-field-rows").click(function(e){
                e.preventDefault();
                ++no_certificates;

                var stringCertificateForm = '<div id="CertificateDiv-'+no_certificates+'">'+
                                                '<form class="prospectiveForm" action="#" id="CertificateForm">'+
                                                '<h3>Certificate Form</h3>'+
                                                '<label>Certificate Name </label>'+
                                                '<input type="text" id="certificate-name-'+no_certificates+'" placeholder="Certificate Name" required readonly/></br>'+
                                                '<button class="prospective-save-btn" id="save-certificate-form">Save</button>'+
                                                '<button class="prospective-close-btn" id="close-certificate-form">Close</button>'+
                                                '<br/>'+
                                                '</form>'+
                                            '</div>';

                var stringCertificateRow = '<div>'+
                                                '<input type="text" name="my-prospective-certificates[]" id="my-prospective-certificate-'+no_certificates+'"/>'+
                                                ' <button class="add-certificate" inputId="my-prospective-certificate-'+no_certificates+'">Add</button>'+
                                                ' <button id="edit-certificate">Edit</button>'+
                                                ' <button class="remove-certificate">Remove</button>'+
                                            '</div>';

                $(".certificate-inputs").append(stringCertificateRow);

                $(".certificate-inputs").append(stringCertificateForm);
                $("#CertificateDiv-"+no_certificates).css({"opacity":"0.92",
                                                            "position": "absolute",
                                                            "top": "0px",
                                                            "left": "0px",
                                                            "height": "100%",
                                                            "width": "100%",
                                                            "background": "#ffffff",
                                                            "display": "none"});

                /*registers pop up function for dynamically created certificate forms*/
                addCertificate();
                close_certificate_form();
            });

            /*removes row along with certificate*/
            $(".certificate-inputs").on("click", ".remove-certificate", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_certificates--;
            });
        }

        /*Group functions*/
        {
            var no_groups = 0;

            /*closes group form*/
            var close_group_form = function(){
                $("#GroupDiv-"+no_groups).on("click", "#close-group-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the group on the row*/
            var addGroup = function(){
                $(".group-inputs .add-group").click(function(e){
                    if (e.target !== this)
                    {
                        return;
                    }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentGroupForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out group field name first. It cannot be empty.");
                        return;
                    }

                    $("#GroupDiv-"+currentGroupForm).css("display", "block");
                    $("#GroupDiv-"+currentGroupForm +" #group-name-"+currentGroupForm).val(value);
                });
            }

            addGroup();
            close_group_form();

            /*add row for group with its corresponding group pop up form*/
            $(".add-group-field-rows").click(function(e){
                e.preventDefault();
                ++no_groups;

                var stringGroupForm = '<div id="GroupDiv-'+no_groups+'">'+
                                        '<form class="prospectiveForm" action="#" id="GroupForm">'+
                                        '<h3>Group Form</h3>'+
                                        '<label>Group Name: </label>'+
                                        '<input type="text" id="group-name-'+no_groups+'" placeholder="Group Name" required readonly/></br>'+
                                        '<label>Number of Courses: <span>*</span></label>'+
                                        '<input type="number" id="number-of-courses-in-group-'+no_groups+'" placeholder="Number of courses" required/></br>'+
                                        '<label>Courses in the Group </label>'+
                                        '<div id="group-courses"></div>'+
                                        '<button class="prospective-save-btn" id="save-group-form">Save</button>'+
                                        '<button class="prospective-close-btn" id="close-group-form">Close</button>'+
                                        '<br/>'+
                                        '</form>'+
                                    '</div>';

                var stringGroupRow = '<div>'+
                                        '<input type="text" name="my-prospective-groups[]" id="my-prospective-group-'+no_groups+'"/>'+
                                        '<button class="add-group" inputId="my-prospective-group-'+no_groups+'">Add</button>'+
                                        '<button id="edit-group">Edit</button>'+
                                        '<button class="remove-group">Remove</button>'+
                                    '</div>';

                $(".group-inputs").append(stringGroupRow);

                $(".group-inputs").append(stringGroupForm);
                $("#GroupDiv-"+no_groups).css({"opacity":"0.92",
                                                "position": "absolute",
                                                "top": "0px",
                                                "left": "0px",
                                                "height": "100%",
                                                "width": "100%",
                                                "background": "#ffffff",
                                                "display": "none"});

                /*registers pop up function for dynamically created group forms*/
                addGroup();
                close_group_form();
            });

            /*removes row along with group*/
            $(".group-inputs").on("click", ".remove-group", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_groups--;
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
            var no_sets = 0;

            /*closes group form*/
            var close_set_form = function(){
                $("#SetDiv-"+no_sets).on("click", "#close-set-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the set on the row*/
            var addSet = function(){
                $(".set-inputs .add-set").click(function(e){
                    if (e.target !== this)
                    {
                        return;
                    }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentSetForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out set field name first. It cannot be empty.");
                        return;
                    }

                    $("#SetDiv-"+currentSetForm).css("display", "block");
                    $("#SetDiv-"+currentSetForm +" #set-name-"+currentSetForm).val(value);
                });
            }

            addSet();
            close_set_form();

            /*add row for set with its corresponding set pop up form*/
            $(".add-set-field-rows").click(function(e){
                e.preventDefault();
                ++no_sets;

                var stringSetForm = '<div id="SetDiv-'+no_sets+'">'+
                                        '<form class="prospectiveForm" action="#" id="SetForm">'+
                                        '<h3>Set Form</h3>'+
                                        '<label>Set Name: </label>'+
                                        '<input type="text" id="set-name-'+no_sets+'" placeholder="Set Name" required readonly/></br>'+
                                        '<label>Select your Group</label>'+
                                        '<select id="group-selected">'+

                                        '</select>'+
                                        '<label>Number of Courses: <span>*</span></label>'+
                                        '<input type="number" id="number-of-courses-in-set-'+no_sets+'" placeholder="Number of courses" required/></br>'+
                                        '<label>Courses in the Set </label>'+
                                        '<div id="set-courses"></div>'+
                                        '<button class="prospective-save-btn" id="save-set-form">Save</button>'+
                                        '<button class="prospective-close-btn" id="close-set-form">Close</button>'+
                                        '<br/>'+
                                        '</form>'+
                                    '</div>';

                var stringSetRow = '<div>'+
                                        '<input type="text" name="my-prospective-sets[]" id="my-prospective-set-'+no_sets+'"/>'+
                                        '<button class="add-set" inputId="my-prospective-set-'+no_sets+'">Add</button>'+
                                        '<button id="edit-set">Edit</button>'+
                                        '<button class="remove-set">Remove</button>'+
                                   '</div>';

                $(".set-inputs").append(stringSetRow);

                $(".set-inputs").append(stringSetForm);
                $("#SetDiv-"+no_sets).css({"opacity":"0.92",
                                            "position": "absolute",
                                            "top": "0px",
                                            "left": "0px",
                                            "height": "100%",
                                            "width": "100%",
                                            "background": "#ffffff",
                                            "display": "none"});

                /*registers pop up function for dynamically created set forms*/
                addSet();
                close_set_form();
            });

            /*removes row along with group*/
            $(".set-inputs").on("click", ".remove-set", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_sets--;
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
            var no_course = 0;

            /*closes group form*/
            var close_course_form = function(){
                $("#CourseDiv-"+no_course).on("click", "#close-course-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new form for the group on the row*/
            var addCourse = function(){
                $(".course-inputs .add-course").click(function(e){
                    if (e.target !== this)
                    {
                        return;
                    }
                    e.stopImmediatePropagation();
                    var btn = $(this);
                    var input = $(btn).attr('inputId');
                    var value = $('#'+input).val();

                    var currentCourseForm = input.substring(input.length - 1, input.length);
                    if ( value.length === 0)
                    {
                        alert("Please fill out course field name first. It cannot be empty.");
                        return;
                    }

                    $("#CourseDiv-"+currentCourseForm).css("display", "block");
                    $("#CourseDiv-"+currentCourseForm +" #course-name-"+currentCourseForm).val(value);
                });
            }

            addCourse();
            close_course_form();

            /*add row for group with its corresponding group pop up form*/
            $(".add-course-field-rows").click(function(e){
                e.preventDefault();
                ++no_course;

                var stringCourseForm = '<div id="CourseDiv-'+no_course+'">'+
                                            '<form class="prospectiveForm" action="#" id="CourseForm">'+
                                            '<h3>Course Form</h3>'+
                                            '<label>Prefix: <span>*</span></label>'+
                                            '<input type="text" id="course-prefix-'+no_course+'" placeholder="Course Prefix" required/></br>'+
                                            '<label>Code: <span>*</span></label>'+
                                            '<input type="text" id="course-code-'+no_course+'" placeholder="Course Code" required/></br>'+
                                            '<label>Name: </label>'+
                                            '<input type="text" id="course-name-'+no_course+'" placeholder="Course Name" required readonly/></br>'+
                                            '<label>Description: <span>*</span></label>'+
                                            '<input type="text" id="course-description-'+no_course+'" placeholder="Course Description" required readonly/></br>'+
                                            '<button class="prospective-save-btn" id="save-course-form">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-course-form">Close</button>'+
                                            '<br/>'+
                                            '</form>'+
                                        '</div>';

                var stringCourseRow = '<div>'+
                                            '<input type="text" name="my-prospective-courses[]" id="my-prospective-course-'+no_course+'"/>'+
                                            '<button class="add-course" inputId="my-prospective-course-'+no_course+'">Add</button>'+
                                            '<button id="edit-course">Edit</button>'+
                                            '<button class="remove-course">Remove</button>'+
                                        '</div>';

                $(".course-inputs").append(stringCourseRow);

                $(".course-inputs").append(stringCourseForm);
                $("#CourseDiv-"+no_course).css({"opacity":"0.92",
                                                "position": "absolute",
                                                "top": "0px",
                                                "left": "0px",
                                                "height": "100%",
                                                "width": "100%",
                                                "background": "#ffffff",
                                                "display": "none"});

                /*registers pop up function for dynamically created group forms*/
                addCourse();
                close_course_form();
            });

            /*removes row along with group*/
            $(".course-inputs").on("click", ".remove-course", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                no_course--;
            });
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
                        <input type="text" name="my-prospective-groups[]" id="my-prospective-group-0"/>
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
                        <input type="text" name="my-prospective-sets[]" id="my-prospective-set-0"/>
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
                        <input type="text" name="my-prospective-courses[]" id="my-prospective-course-0"/>
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




  

   
            
        
            
        