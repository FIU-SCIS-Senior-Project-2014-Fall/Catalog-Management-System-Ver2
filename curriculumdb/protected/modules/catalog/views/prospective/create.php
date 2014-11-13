<style xmlns="http://www.w3.org/1999/html">
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
        width:50%;
    }

    .prospective-close-btn{
        background-color:slategray;
        border:1px solid white;
        font-family: 'Fauna One', serif;
        font-Weight:bold;
        font-size:18px;
        color:white;
        width:50%;
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
        height: 500px;
        left: 50%;
        top: 50%;
        margin-left:-200px;
        margin-top:-250px;
    }

    #CourseDiv-0 input {
        width: 100%;
        border: 1px solid #999;
        border-radius: 3px;
    }


</style>
<script>
    $(document).ready(function() {

        var catalogName = $("#catalog-name").val();

        var catalogID = 0;

        $.ajax({
            type: 'GET',
            url: '<?php echo  Yii::app()->createUrl('catalog/prospective/GetLastCatalogID'); ?>',
            dataType: 'json',
            data: {},
            success: function (data) {
                catalogID = data["catalogId"];
                alert('next catalog id is ' + catalogID);

                //data returned from php
            },
            error: function(data){
                alert('error getting catalog id');
            }
        });



        /*Major functions*/
        {
            var no_majors = 0;
            var no_emajors = 0

            /*closes current major form*/
            var close_major_form = function(){
                $("#MajorDiv-"+no_majors).on("click", "#close-major-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*closes current major edit form*/
            var close_emajor_form = function(){
                $("#eMajorDiv-"+no_emajors).on("click", "#close-emajor-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new major edit form for the major on the row*/
            var addeMajor = function()
            {
                $(".emajor-inputs .edit-major").click(function(e){
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

                    $("#eMajorDiv-"+currentMajorForm).css("display", "block");
                    $("#eMajorDiv-"+currentMajorForm +" #emajor-name-"+currentMajorForm).val(value);
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

            /*add a row to put tracks in major*/
            var addTrackRowInMajor = function(){

                $(".add-tracks-to-major-field-rows").click(function(){
                    var trackToMajorDiv = '<div>'+
                        '<input type="text" name="my-prospective-major-'+no_majors+'[]" id="my-prospective-set-0"/>'+
                        '<button class="remove-track-in-new-major">Remove</button>'+
                        '</div>';

                    $(".tracks-to-major").append(trackToMajorDiv);
                });
            };

            addMajor();
            close_major_form();

            /*adds a major-track new relation*/
            var addtrackToMajor = function()
            {
                $(".add-track-to-major").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var major = $("#eMajorDiv-"+formIdno+ " #emajor-name-"+formIdno).val();
                    var track = $("#eMajorDiv-"+formIdno+ " #track-selected-"+formIdno).val();
                    var data = 'major='+ encodeURI(major)  +  '&track='+ encodeURI(track);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/AddTrackMajor'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }

            var removeTrackFromMajor = function()
            {
                $(".remove-track-from-major").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var major = $("#eMajorDiv-"+formIdno+ " #emajor-name-"+formIdno).val();
                    var track = $("#eMajorDiv-"+formIdno+ " #track-selected-"+formIdno).val();
                    var data = 'major='+ encodeURI(major)  +  '&track='+ encodeURI(track);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RemoveTrackMajor'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {

                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }

            /*add a new edit major row*/
            $(".edit-major-field-rows").click(function(e){
                e.preventDefault();
                var MajorList = <?php echo json_encode(getMajors()) ?>;
                var TrackList = <?php echo json_encode(getTracks()) ?>;

                var stringeMajorRow = '<div>' +
                                        '<select id="my-prospective-emajor-' + (no_emajors) + '">'+
                                        MajorList +
                                        '</select>'+
                                        //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                        '<button class="edit-major" inputId="my-prospective-emajor-'+ (no_emajors) +'" >Edit</button>' +
                                        '<button class="remove-major">Remove</button>' +
                                    '</div>';

                var stringeMajorForm = '<div id="eMajorDiv-'+(no_emajors)+'">'+
                                            '<form class="prospectiveForm" action="#" id="MajorForm">' +
                                            '<h3>Major Form</h3>'+
                                            '<label>Major Name </label>'+
                                            '<div>'+
                                                '<input type="text" id="emajor-name-'+ (no_emajors) +'" required readonly/>'+
                                                '<h4>Select Track</h4>'+
                                                '<select id="track-selected-'+no_emajors+'">'+
                                                TrackList +
                                                '</select>'+
                                                '<button class="add-track-to-major" id="add-track-to-major" name="add-track-to-major-'+ (no_emajors) + '">Add this track</button>'+
                                                '<button class="remove-track-from-major" id="remove-track-from-major" name="remove-track-from-major-' + (no_emajors) + '">Remove this track</button>'+
                                            '</div>'+
                                            '<button class="prospective-save-btn" id="save-emajor-form">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-emajor-form">Close</button>'+
                                            '<br/>'+
                                            '</form>'+
                                        '</div>';

                $(".emajor-inputs").append(stringeMajorRow);
                $(".emajor-inputs").append(stringeMajorForm);
                $("#eMajorDiv-"+no_emajors).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});

                /*registers pop up function for dynamically created major forms*/
                addeMajor();
                close_emajor_form();
                addtrackToMajor();
                removeTrackFromMajor();
                no_emajors++;

            })

            /*add row for major with its corresponding major pop up form*/
            $(".add-major-field-rows").click(function(e){
                e.preventDefault();
                ++no_majors;
                var stringMajorForm = '<div id="MajorDiv-'+(no_majors)+'">'+
                                        '<form class="prospectiveForm" action="#" id="MajorForm">' +
                                            '<h3>Major Form</h3>'+
                                            '<label>Major Name </label>'+
                                            '<input type="text" id="major-name-'+no_majors+'" placeholder="Major Name" required readonly/></br>'+
                                            '<label>Tracks in the Major</label>' +
                                            '<button class="add-tracks-to-major-field-rows">+</button>' +
                                            '<div class="tracks-to-major">' +
                                                '<div>'+
                                                    '<input type="text" name="my-prospective-major-'+no_majors+'[]" />'+
                                                    '<button class="remove-track-in-new-major">Remove</button>'+
                                                '</div>'+
                                            '</div>' +


                                            '<button class="prospective-save-btn" id="save-major-form">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-major-form">Close</button>'+
                                            '<br/>'+
                                        '</form>'+
                                    '</div>';

                var stringMajorRow = '<div>' +
                                        '<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                        '<button class="add-major" inputId="my-prospective-major-'+ (no_majors) +'" >Add</button>' +
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
                                                "display": "none",
                                                "overflow": "scroll"});

                /*registers pop up function for dynamically created emajor forms*/
                addMajor();
                close_major_form();
                addTrackRowInMajor();
                removeRowTrackInMajor();
            });

            /*removes row for new major*/
            var removeRowTrackInMajor = function(){
            $(".major-inputs #MajorDiv-"+(no_majors)).on("click", ".remove-track-in-new-major", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_majors--;
            });
            };

            /*removes row along with major*/
            $(".major-inputs").on("click", ".remove-major", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_majors--;
            });

            /*removes row along with emajor*/
            $(".emajor-inputs").on("click", ".remove-major", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_emajors--;
            });
        }

        /*Minor functions*/
        {
            var no_minors = 0;
            var no_eminors = 0;

            /*closes current minor form*/
            var close_minor_form = function(){
                $("#MinorDiv-"+no_minors).on("click", "#close-minor-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*closes current minor edit form*/
            var close_eminor_form = function(){
                $("#eMinorDiv-"+no_eminors).on("click", "#close-eminor-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new minor edit form for the minor on the row*/
            var addeMinor = function()
            {
                $(".eminor-inputs .edit-minor").click(function(e){
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

                    $("#eMinorDiv-"+currentMinorForm).css("display", "block");
                    $("#eMinorDiv-"+currentMinorForm +" #eminor-name-"+currentMinorForm).val(value);
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

            /*add a row to put tracks in major*/
            var addGroupRowInMinor = function(){

                $(".add-group-to-minor-field-rows").click(function(){
                    var groupToMinorDiv = '<div>'+
                        '<input type="text" name="my-prospective-minor-'+no_minors+'[]" id="my-prospective-set-0"/>'+
                        '<button class="remove-group-in-new-minor">Remove</button>'+
                        '</div>';

                    $(".groups-to-minor").append(groupToMinorDiv);
                });
            };

            addMinor();
            close_minor_form();

            /*adds a major-track new relation*/
            var addGroupToMinor = function()
            {
                $(".add-group-to-minor").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var minor = $("#eMinorDiv-"+formIdno+ " #eminor-name-"+formIdno).val();
                    var group = $("#eMinorDiv-"+formIdno+ " #group-selected-in-minor-"+formIdno).val();
                    var data = 'minor='+ encodeURI(minor)  +  '&group='+ encodeURI(group);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/AddGroupMinor'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {

                            //data returned from php
                        }
                    });
                });
            }

            var removeGroupFromMinor = function()
            {
                $(".remove-group-from-minor").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var minor = $("#eMinorDiv-"+formIdno+ " #eminor-name-"+formIdno).val();
                    var group = $("#eMinorDiv-"+formIdno+ " #group-selected-in-minor-"+formIdno).val();
                    var data = 'minor='+ encodeURI(minor)  +  '&group='+ encodeURI(group);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RemoveGroupMinor'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {

                            //data returned from php
                        }
                    });
                });
            }

            /*add row for minor with its corresponding minor pop up form*/
            $(".add-minor-field-rows").click(function(e){
                e.preventDefault();
                ++no_minors;

                var stringMinorForm = '<div id="MinorDiv-'+(no_minors)+'">' +
                                        '<form class="prospectiveForm" action="#" id="MinorForm">'+
                                            '<h3>Minor Form</h3>'+
                                            '<label>Minor Name </label>'+
                                            '<input type="text" id="minor-name-'+no_minors+'" required readonly/></br>'+

                                            '<label>Groups in the Minor </label>'+
                                            '<button class="add-group-to-minor-field-rows">+</button>' +
                                            '<div class="groups-to-minor">' +
                                                '<div>'+
                                                '<input type="text" name="my-prospective-minor-'+no_minors+'[]" />'+
                                                '<button class="remove-group-in-new-minor">Remove</button>'+
                                                '</div>'+
                                            '</div>' +
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
                removeRowGroupInMinor();
                addGroupRowInMinor();

            });

            /*add a new edit minor row*/
            $(".edit-minor-field-rows").click(function(e){
                e.preventDefault();
                var MinorList = <?php echo json_encode(getMinors()) ?>;
                var GroupList = <?php echo json_encode(getGroups()) ?>;

                var stringeMinorRow = '<div>' +
                                            '<select id="my-prospective-eminor-' + (no_eminors) + '">'+
                                            MinorList +
                                            '</select>'+
                                                //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                            '<button class="edit-minor" inputId="my-prospective-eminor-'+ (no_eminors) +'" >Edit</button>' +
                                            '<button class="remove-minor">Remove</button>' +
                                        '</div>';

                var stringeMinorForm = '<div id="eMinorDiv-'+(no_eminors)+'">'+
                                                '<form class="prospectiveForm" action="#" id="MinorForm">' +
                                                '<h3>Minor Form</h3>'+
                                                '<label>Minor Name </label>'+
                                                '<div>'+
                                                    '<input type="text" id="eminor-name-'+no_eminors+'" placeholder="Minor Name" required readonly/></br>'+
                                                    '<h4>Select Track</h4>'+
                                                    '<select id="group-selected-in-minor-'+no_eminors+'">'+
                                                    GroupList +
                                                    '</select>'+
                                                    '<button class="add-group-to-minor" id="add-group-to-minor" name="add-group-to-certificate-'+ (no_eminors) + '">Add this track</button>'+
                                                    '<button class="remove-group-from-minor" id="remove-group-from-minor" name="remove-group-from-certificate-'+ (no_eminors) + '">Remove this track</button>'+
                                                    '</div>'+
                                                '<button class="prospective-save-btn" id="save-eminor-form">Save</button>'+
                                                '<button class="prospective-close-btn" id="close-eminor-form">Close</button>'+
                                                '<br/>'+
                                                '</form>'+
                                            '</div>';

                $(".eminor-inputs").append(stringeMinorRow);
                $(".eminor-inputs").append(stringeMinorForm);
                $("#eMinorDiv-"+no_eminors).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});

                /*registers pop up function for dynamically created major forms*/
                addeMinor();
                close_eminor_form();
                addGroupToMinor();
                removeGroupFromMinor();
                no_eminors++;

            })

            /*removes row for new minor*/
            var removeRowGroupInMinor = function(){
                $(".minor-inputs #MinorDiv-"+(no_minors)).on("click", ".remove-group-in-new-minor", function(e){
                    e.preventDefault();
                    $(this).parent('div').remove();
                    //no_majors--;
                });
            };

            /*removes row along with minor*/
            $(".minor-inputs").on("click", ".remove-minor", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_minors--;
            });

            /*removes row along with emajor*/
            $(".eminor-inputs").on("click", ".remove-minor", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_emajors--;
            });
        }

        /*Certificate functions*/
        {
            var no_certificates = 0;
            var no_ecertificates = 0;

            /*closes certificate form*/
            var close_certificate_form = function(){
                $("#CertificateDiv-"+no_certificates).on("click", "#close-certificate-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*closes current certificate edit form*/
            var close_ecertificate_form = function(){
                $("#eCertificateDiv-"+no_ecertificates).on("click", "#close-ecertificate-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*pops up a new certificate edit form for the certificate on the row*/
            var addeCertificate = function()
            {
                $(".ecertificate-inputs .edit-certificate").click(function(e){
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
                        alert("Please fill out certficate field name first. It cannot be empty.");
                        return;
                    }

                    $("#eCertificateDiv-"+currentCertificateForm).css("display", "block");
                    $("#eCertificateDiv-"+currentCertificateForm +" #ecertificate-name-"+currentCertificateForm).val(value);
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

            /*add a row to put tracks in major*/
            var addGroupRowInCertificate = function(){

                $(".add-group-to-certificate-field-rows").click(function(){
                    var groupToCertificateDiv = '<div>'+
                        '<input type="text" name="my-prospective-certificate-'+no_certificates+'[]" id="my-prospective-set-0"/>'+
                        '<button class="remove-group-in-new-certificate">Remove</button>'+
                        '</div>';

                    $(".groups-to-certificate").append(groupToCertificateDiv);
                });
            };

            addCertificate();
            close_certificate_form();

            /*adds a major-track new relation*/
            var addGroupToCertificate = function()
            {
                $(".add-group-to-certificate").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var certificate = $("#eCertificateDiv-"+formIdno+ " #ecertificate-name-"+formIdno).val();
                    var group = $("#eCertificateDiv-"+formIdno+ " #group-selected-in-certificate"+formIdno).val();
                    var data = 'certificate='+ encodeURI(certificate)  +  '&group='+ encodeURI(group);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/AddGroupCertificate'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {

                            //data returned from php
                        }
                    });
                });
            }

            var removeGroupFromCertificate = function()
            {
                $(".remove-group-from-certificate").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var certificate = $("#eCertificateDiv-"+formIdno+ " #ecertificate-name-"+formIdno).val();
                    var group = $("#eCertificateMDiv-"+formIdno+ " #group-selected-in-certificate"+formIdno).val();
                    var data = 'certificate='+ encodeURI(certificate)  +  '&group='+ encodeURI(group);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RemoveGroupCertificate'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {

                            //data returned from php
                        }
                    });
                });
            }


            /*add row for certficate with its corresponding certificate pop up form*/
            $(".add-certificate-field-rows").click(function(e){
                e.preventDefault();
                ++no_certificates;

                var stringCertificateForm = '<div id="CertificateDiv-'+no_certificates+'">'+
                                                '<form class="prospectiveForm" action="#" id="CertificateForm">'+
                                                '<h3>Certificate Form</h3>'+
                                                '<label>Certificate Name </label>'+
                                                '<input type="text" id="certificate-name-'+no_certificates+'" placeholder="Certificate Name" required readonly/></br>'+
                                                '<label>Groups in the Minor </label>'+
                                                '<button class="add-group-to-certificate-field-rows">+</button>' +
                                                '<div class="groups-to-certificate">' +
                                                    '<div>'+
                                                        '<input type="text" name="my-prospective-certificate-'+no_minors+'[]" />'+
                                                        '<button class="remove-group-in-new-minor">Remove</button>'+
                                                    '</div>'+
                                                '</div>' +
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
                addGroupRowInCertificate();
                removeRowGroupInCertificate();
            });

            /*add a new edit minor row*/
            $(".edit-certificate-field-rows").click(function(e){
                e.preventDefault();
                var CertificateList = <?php echo json_encode(getCertificates()) ?>;
                var GroupList = <?php echo json_encode(getGroups()) ?>;

                var stringeCertficateRow = '<div>' +
                                                '<select id="my-prospective-ecertificate-' + (no_ecertificates) + '">'+
                                                CertificateList +
                                                '</select>'+
                                                    //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                                '<button class="edit-certificate" inputId="my-prospective-ecertificate-'+ (no_ecertificates) +'" >Edit</button>' +
                                                '<button class="remove-certificate">Remove</button>' +
                                            '</div>';

                var stringeCertificateForm = '<div id="eCertificateDiv-'+(no_ecertificates)+'">'+
                                                '<form class="prospectiveForm" action="#" id="CertificateForm">' +
                                                    '<h3>Certificate Form</h3>'+
                                                    '<label>Certificate Name </label>'+
                                                    '<div>'+
                                                        '<input type="text" id="ecertificate-name-'+no_ecertificates+'" placeholder="Minor Name" required readonly/></br>'+
                                                        '<h4>Select Track</h4>'+
                                                        '<select id="group-selected-in-certificate-'+no_ecertificates+'">'+
                                                        GroupList +
                                                        '</select>'+
                                                        '<button class="add-group-to-certificate" id="add-group-to-certificate">Add this track</button>'+
                                                        '<button class="remove-group-from-certificate" id="remove-group-from-certificate">Remove this track</button>'+
                                                    '</div>'+
                                                    '<button class="prospective-save-btn" id="save-ecertificate-form">Save</button>'+
                                                    '<button class="prospective-close-btn" id="close-ecertificate-form">Close</button>'+
                                                    '<br/>'+
                                                '</form>'+
                                             '</div>';

                $(".ecertificate-inputs").append(stringeCertficateRow);
                $(".ecertificate-inputs").append(stringeCertificateForm);
                $("#eCertificateDiv-"+no_ecertificates).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});

                /*registers pop up function for dynamically created major forms*/
                addeCertificate();
                close_ecertificate_form();
                addGroupToCertificate();
                removeGroupFromCertificate();
                no_ecertificates++;

            })


            /*removes row for new certificate*/
            var removeRowGroupInCertificate = function(){
                $(".certificate-inputs #CertificateDiv-"+(no_certificates)).on("click", ".remove-group-in-new-certificate", function(e){
                    e.preventDefault();
                    $(this).parent('div').remove();
                    //no_majors--;
                });
            };

            /*removes row along with certificate*/
            $(".certificate-inputs").on("click", ".remove-certificate", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_certificates--;
            });

            /*removes row along with emajor*/
            $(".ecertificate-inputs").on("click", ".remove-certificate", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_emajors--;
            });
        }

        /*Track functions*/
        {
            var no_tracks = 0;
            var no_etracks = 0;

            /*closes current track edit form*/
            var close_etrack_form = function(){
                $("#eTrackDiv-"+no_ecertificates).on("click", "#close-etrack-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

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

            /*pops up a new certificate edit form for the certificate on the row*/
            var addeTrack = function()
            {
                $(".etrack-inputs .edit-track").click(function(e){
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

                    $("#eTrackDiv-"+currentTrackForm).css("display", "block");
                    $("#eTrackDiv-"+currentTrackForm +" #etrack-name-"+currentTrackForm).val(value);
                });
            }

            /*add a row to put tracks in major*/
            var addGroupRowInTrack = function(){

                $(".add-group-to-track-field-rows").click(function(){
                    var groupToTrackDiv = '<div>'+
                        '<input type="text" name="my-prospective-track-'+no_tracks+'[]" id="my-prospective-set-0"/>'+
                        '<button class="remove-group-in-new-track">Remove</button>'+
                        '</div>';

                    $(".groups-to-track").append(groupToTrackDiv);
                });
            };

            addTrack();
            close_track_form();

            /*adds a major-track new relation*/
            var addGroupToTrack = function()
            {
                $(".add-group-to-track").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var track = $("#eTrackDiv-"+formIdno+ " #etrack-name-"+formIdno).val();
                    var group = $("#eTrackDiv-"+formIdno+ " #group-selected-in-track-"+formIdno).val();
                    var data = /*'{}'; */'track='+ encodeURI(track)  +  '&group='+ encodeURI(group);
/*
                    var jsonData = {};
                    jsonData.track = track;
                    jsonData.group = group;
                    data = JSON.stringify(jsonData);*/

                    var url = '<?php echo  Yii::app()->createUrl('catalog/prospective/AddGroupTrack'); ?>';
                    $.ajax({
                        type: 'GET',
                        url: url,
                        dataType: 'json',
                        data: data,
                        success: function (data) {

                            //data returned from php
                            alert('success');
                        },
                        error: function(){
                            alert('error');
                        }
                    });
                });
            }

            var removeGroupFromTrack = function()
            {
                $(".remove-group-from-track").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var track = $("#eTrackDiv-"+formIdno+ " #etrack-name-"+formIdno).val();
                    var group = $("#eTrackDiv-"+formIdno+ " #group-selected-in-track-"+formIdno).val();
                    var data = 'track='+ encodeURI(track)  +  '&group='+ encodeURI(group);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RemoveGroupTrack'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }


            /*add row for minor with its corresponding minor pop up form*/
            $(".add-track-field-rows").click(function(e){
                e.preventDefault();
                ++no_tracks;

                var stringTrackForm = '<div id="TrackDiv-'+no_tracks+'">'+
                                            '<form class="prospectiveForm" action="#" id="TrackForm">'+
                                            '<h3>Track Form</h3>'+
                                            '<label>Track Name </label>'+
                                            '<input type="text" id="track-name-'+no_tracks+'" placeholder="Track Name" required readonly/></br>'+
                                            '<button class="add-group-to-track-field-rows">+</button>' +
                                            '<div class="group-to-track">' +
                                                '<div>'+
                                                '<input type="text" name="my-prospective-track-'+no_tracks+'[]" />'+
                                                '<button class="remove-group-in-new-track">Remove</button>'+
                                                '</div>'+
                                            '</div>' +
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
                addGroupRowInTrack();
                removeRowGroupInTrack();

            });

            /*add a new edit track row*/
            $(".edit-track-field-rows").click(function(e){
                e.preventDefault();
                var TrackList = <?php echo json_encode(getTracks()) ?>;
                var GroupList = <?php echo json_encode(getGroups()) ?>;

                var stringeTrackRow = '<div>' +
                                                '<select id="my-prospective-etrack-' + (no_etracks) + '">'+
                                                TrackList +
                                                '</select>'+
                                                    //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                                '<button class="edit-track" inputId="my-prospective-etrack-'+ (no_etracks) +'" >Edit</button>' +
                                                '<button class="remove-track">Remove</button>' +
                                            '</div>';

                var stringeTrackForm = '<div id="eTrackDiv-'+(no_etracks)+'">'+
                                                    '<form class="prospectiveForm" action="#" id="TrackForm">' +
                                                        '<h3>Track Form</h3>'+
                                                        '<label>Track Name </label>'+
                                                        '<div>'+
                                                            '<input type="text" id="etrack-name-'+no_etracks+'" placeholder="Track Name" required readonly/></br>'+
                                                            '<h4>Select Group</h4>'+
                                                            '<select id="group-selected-in-track-'+no_etracks+'">'+
                                                            GroupList +
                                                            '</select>'+
                                                            '<button class="add-group-to-track" id="add-group-to-track" name="add-group-to-track-'+ (no_etracks) + '">Add this group</button>'+
                                                            '<button class="remove-group-from-track" id="remove-group-from-certificate" name="remove-group-from-track-'+ (no_etracks) + '">Remove this group</button>'+
                                                        '</div>'+
                                                        '<button class="prospective-save-btn" id="save-etrack-form">Save</button>'+
                                                        '<button class="prospective-close-btn" id="close-etrack-form">Close</button>'+
                                                        '<br/>'+
                                                    '</form>'+
                                                '</div>';

                $(".etrack-inputs").append(stringeTrackRow);
                $(".etrack-inputs").append(stringeTrackForm);
                $("#eTrackDiv-"+no_etracks).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});

                /*registers pop up function for dynamically created major forms*/
                addeTrack();
                close_etrack_form();
                addGroupToTrack();
                removeGroupFromTrack();
                no_etracks++;

            })

            /*removes row for new certificate*/
            var removeRowGroupInTrack = function(){
                $(".track-inputs #TrackDiv-"+(no_tracks)).on("click", ".remove-group-in-new-track", function(e){
                    e.preventDefault();
                    $(this).parent('div').remove();
                    //no_majors--;
                });
            };

            /*removes row along with track*/
            $(".track-inputs").on("click", ".remove-track", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
               // no_tracks--;
            });

            /*removes row along with emajor*/
            $(".etrack-inputs").on("click", ".remove-track", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_emajors--;
            });
        }

        /*Group functions*/
        {
            var no_groups = 0;
            var no_egroups = 0;

           /*closes group form*/
            var close_group_form = function(){
                $("#GroupDiv-"+no_groups).on("click", "#close-group-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*closes group form*/
            var close_egroup_form = function(){
                $("#eGroupDiv-"+no_groups).on("click", "#close-egroup-form", function(e){
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

            /*adds a major-track new relation*/
            var addSetToGroup = function()
            {
                $(".add-set-to-group").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var group = $("#eGroupDiv-"+formIdno+ " #egroup-name-"+formIdno).val();
                    var set = $("#eGroupDiv-"+formIdno+ " #set-selected-in-group-"+formIdno).val();
                    var data = 'group='+ encodeURI(group)  +  '&set='+ encodeURI(set);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/AddSetGroup'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }

            var removeSetFromGroup = function()
            {
                $(".remove-set-from-group").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var group = $("#eGroupDiv-"+formIdno+ " #egroup-name-"+formIdno).val();
                    var set = $("#eGroupDiv-"+formIdno+ " #set-selected-in-group-"+formIdno).val();
                    var data = 'group='+ encodeURI(group)  +  '&set='+ encodeURI(set);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RemoveSetGroup'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }
            /*add a row to put tracks in major*/
            var addSetRowInGroup = function(){

                $(".add-set-to-group-field-rows").click(function(){
                    var groupToTrackDiv = '<div>'+
                        '<input type="text" name="my-prospective-group-'+no_egroups+'[]" id="my-prospective-set-0"/>'+
                        '<button class="remove-set-in-new-group">Remove</button>'+
                        '</div>';

                    $(".set-to-group").append(groupToTrackDiv);
                });
            };

            /*pops up a new form for the group on the row*/
            var addeGroup = function(){
                $(".egroup-inputs .edit-group").click(function(e){
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

                    $("#eGroupDiv-"+currentGroupForm).css("display", "block");
                    $("#eGroupDiv-"+currentGroupForm +" #egroup-name-"+currentGroupForm).val(value);
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
                                        '<button class="add-set-to-group-field-rows">+</button>' +
                                        '<div class="set-to-group">' +
                                            '<div>'+
                                            '<input type="text" name="my-prospective-group-'+no_groups+'[]" />'+
                                            '<button class="remove-set-in-new-group">Remove</button>'+
                                            '</div>'+
                                        '</div>' +
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
                addSetRowInGroup();
                removeSetRowInGroup();
            });

            /*add a new edit track row*/
            $(".edit-group-field-rows").click(function(e){
                e.preventDefault();
                var SetList = <?php echo json_encode(getSets()) ?>;
                var GroupList = <?php echo json_encode(getGroups()) ?>;

                var stringeGroupRow = '<div>' +
                                            '<select id="my-prospective-egroup-' + (no_egroups) + '">'+
                                            GroupList +
                                            '</select>'+
                                                //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                            '<button class="edit-group" inputId="my-prospective-egroup-'+ (no_egroups) +'" >Edit</button>' +
                                            '<button class="remove-group">Remove</button>' +
                                        '</div>';

                var stringeGroupForm = '<div id="eGroupDiv-'+(no_egroups)+'">'+
                                            '<form class="prospectiveForm" action="#" id="GroupForm">' +
                                                '<h3>Group Form</h3>'+
                                                '<label>Group Name </label>'+
                                                '<div>'+
                                                    '<input type="text" id="egroup-name-'+no_egroups+'" placeholder="Track Name" required readonly/></br>'+
                                                    '<h4>Select Group</h4>'+
                                                    '<select id="set-selected-in-group-'+no_egroups+'">'+
                                                    SetList +
                                                    '</select>'+
                                                    '<button class="add-set-to-group" id="add-set-to-group" name="add-set-to-group-'+ (no_egroups) + '">Add this group</button>'+
                                                    '<button class="remove-set-from-group" id="remove-set-from-group" name="remove-set-from-group-'+ (no_egroups) + '">Remove this group</button>'+
                                                '</div>'+
                                                '<button class="prospective-save-btn" id="save-egroup-form">Save</button>'+
                                                '<button class="prospective-close-btn" id="close-egroup-form">Close</button>'+
                                                '<br/>'+
                                            '</form>'+
                                        '</div>';

                $(".egroup-inputs").append(stringeGroupRow);
                $(".egroup-inputs").append(stringeGroupForm);
                $("#eGroupDiv-"+no_egroups).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});

                /*registers pop up function for dynamically created major forms*/
                addeGroup();
                close_egroup_form();
                addSetToGroup();
                removeSetFromGroup();
                no_egroups++;

            })

            /*removes row along with group*/
            $(".group-inputs").on("click", ".remove-group", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_groups--;
            });

            /*removes row along with edit group*/
            $(".egroup-inputs").on("click", ".remove-group", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                //no_groups--;
            });

            /*removes row for new group*/
            var removeSetRowInGroup = function(){
                $(".group-inputs #GroupDiv-"+(no_groups)).on("click", ".remove-set-in-new-group", function(e){
                    e.preventDefault();
                    $(this).parent('div').remove();
                    //no_majors--;
                });
            };

        }

        /*Sets functions*/
        {
            var no_sets = 0;
            var no_esets = 0;

            /*closes set form*/
            var close_eset_form = function(){
                $("#eSetDiv-"+no_sets).on("click", "#close-eset-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*closes set form*/
            var close_set_form = function(){
                $("#SetDiv-"+no_sets).on("click", "#close-set-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
            }

            /*adds a major-track new relation*/
            var addCourseToSet = function()
            {
                $(".add-course-to-set").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var set = $("#eSetDiv-"+formIdno+ " #eset-name-"+formIdno).val();
                    var course = $("#eSetDiv-"+formIdno+ " #course-selected-in-set-"+formIdno).val();
                    var data = 'set='+ encodeURI(set)  +  '&course='+ encodeURI(course);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/AddCourseSet'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }

            var removeCourseFromSet = function()
            {
                $(".remove-course-from-set").click(function(e) {

                    var btn = $(this);
                    var name = $(btn).attr('name');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var set = $("#eSetDiv-"+formIdno+ " #eset-name-"+formIdno).val();
                    var course = $("#eSetDiv-"+formIdno+ " #course-selected-in-set-"+formIdno).val();
                    var data = 'set='+ encodeURI(set)  +  '&course='+ encodeURI(course);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RemoveCourseSet'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('success');
                            //data returned from php
                        }
                    });
                });
            }

            /*add a row to put tracks in major*/
            var addCourseRowInSet = function(){

                $(".add-course-to-set-field-rows").click(function(){
                    var groupToTrackDiv = '<div>'+
                        '<input style="width:65%" type="text" name="my-prospective-set-'+no_sets+'[]" id="my-prospective-set-0"/>'+
                        '<button style="width:30%" class="remove-course-in-new-set">Remove</button>'+
                        '</div>';

                    $(".course-to-set").append(groupToTrackDiv);
                });
            };

            /*pops up a new form for the group on the row*/
            var addeSet = function(){
                $(".eset-inputs .edit-set").click(function(e){
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

                    $("#eSetDiv-"+currentGroupForm).css("display", "block");
                    $("#eSetDiv-"+currentGroupForm +" #eset-name-"+currentGroupForm).val(value);
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

            var saveNewSet = function()
            {
                $("#save-set-form").click(function(d) {

                    var btn = $(this);
                    var name = $(btn).attr('inputId');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var name  = $("#SetDiv-"+formIdno+ " #set-name-"+formIdno).val();
                    var description  = $("#SetDiv-"+formIdno+ " #set-description-"+formIdno).val();
                    var credits  = $("#SetDiv-"+formIdno+ " #set-credits-"+formIdno).val();

                    var data = 'name='+ encodeURI(name)  +
                        '&description='+ encodeURI(description) + '&credits='+ encodeURI(credits) +
                        '&catalogID='+ encodeURI(''+catalogID);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/SaveNewSet'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('Save was successful');
                            //data returned from php
                        },
                        error: function(data){
                            alert('error');
                        }
                    });
                    return false;
                });
            }

            addSet();
            close_set_form();
            saveNewSet();

            /*add row for set with its corresponding set pop up form*/
            $(".add-set-field-rows").click(function(e){
                e.preventDefault();
                ++no_sets;

                var stringSetForm = '<div id="SetDiv-'+no_sets+'">'+
                                        '<form class="prospectiveForm" action="#" id="SetForm">'+
                                        '<h3>New Set Form</h3>'+
                                        '<label>Set Name: </label>'+
                                        '<input type="text" id="set-name-'+no_sets+'" placeholder="Set Name" required readonly/></br>'+
                                        '<lable>Min Credits: </label>'+
                                        '<input type="text" id="set-credits-'+no_sets+'" placeholder="Set Name" /></br>'+
                                        '<label>Description: <span>*</span></label>'+
                                        '<textarea id="set-description-'+no_sets+'" placeholder="Set Description" required/></br>'+
                                        '<button class="add-course-to-set-field-rows">+</button>' +
                                        '<div class="course-to-set">' +
                                        '<div>'+
                                        '<input type="text" name="my-prospective-set-'+no_sets+'[]" />'+
                                        '<button class="remove-course-in-new-set">Remove</button>'+
                                        '</div>'+
                                        '</div>' +
                                        '<button class="prospective-save-btn" id="save-set-form" inputId="save-course-form-'+no_sets+'">Save</button>'+
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
                $("#SetDiv-"+no_sets +" input").css({"width":"100%",
                                                    "border":"1px solid #999",
                                                    "border-radius":"3px"});

                /*registers pop up function for dynamically created set forms*/
                addSet();
                close_set_form();
                addCourseRowInSet();
                removeCourseRowInSet();
                saveNewSet();
            });

            /*add a new edit track row*/
            $(".edit-set-field-rows").click(function(e){
                e.preventDefault();
                var CourseList = <?php echo json_encode(getCourses()) ?>;
                var SetList = <?php echo json_encode(getSets()) ?>;

                var stringeSetRow = '<div>' +
                                        '<select id="my-prospective-eset-' + (no_esets) + '">'+
                                        SetList +
                                        '</select>'+
                                            //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                        '<button class="edit-set" inputId="my-prospective-eset-'+ (no_esets) +'" >Edit</button>' +
                                        '<button class="remove-set">Remove</button>' +
                                    '</div>';

                var stringeSetForm = '<div id="eSetDiv-'+(no_esets)+'">'+
                                            '<form class="prospectiveForm" action="#" id="SetForm">' +
                                                '<h3>Set Form</h3>'+
                                                '<label>Set Name </label>'+
                                                '<div>'+
                                                    '<input type="text" id="eset-name-'+no_esets+'" placeholder="Track Name" required readonly/></br>'+
                                                    '<h4>Select Course</h4>'+
                                                    '<select id="course-selected-in-set-'+no_esets+'">'+
                                                    CourseList +
                                                    '</select>'+
                                                    '<button class="add-course-to-set" id="add-course-to-set" name="add-course-to-set-'+ (no_esets) + '">Add this group</button>'+
                                                    '<button class="remove-course-from-set" id="remove-course-from-set" name="remove-course-from-set-'+ (no_esets) + '">Remove this group</button>'+
                                                '</div>'+
                                                '<button class="prospective-save-btn" id="save-eset-form">Save</button>'+
                                                '<button class="prospective-close-btn" id="close-eset-form">Close</button>'+
                                                '<br/>'+
                                            '</form>'+
                                    '</div>';

                $(".eset-inputs").append(stringeSetRow);
                $(".eset-inputs").append(stringeSetForm);
                $("#eSetDiv-"+no_esets).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});

                /*registers pop up function for dynamically created major forms*/
                addeSet();
                close_eset_form();
                addCourseToSet();
                removeCourseFromSet();
                no_esets++;

            })

            /*removes row along with group*/
            $(".set-inputs").on("click", ".remove-set", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                return false;
            });

            /*removes row along with edit group*/
            $(".eset-inputs").on("click", ".remove-set", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                return false;
            });

            /*removes row for new group*/
            var removeCourseRowInSet = function(){
                $(".set-inputs #SetDiv-"+(no_sets)).on("click", ".remove-course-in-new-set", function(e){
                    e.preventDefault();
                    $(this).parent('div').remove();
                    //no_majors--;
                });
                return false;
            };

        }

        /*Course functions*/
        {
            var no_course = 0;
            var no_ecourse = 0;

            /*closes group form*/
            var close_course_form = function(){
                $("#CourseDiv-"+no_course).on("click", "#close-course-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
                return false;
            }

            /*closes editable group form*/
            var close_ecourse_form = function(){
                $("#eCourseDiv-"+no_ecourse).on("click", "#close-ecourse-form", function(e){
                    $(this).parent('form').parent('div').css("display", "none");
                });
                return false;
            }

            /*pops up a new course edit form for the course on the row*/
            var addeCourse = function()
            {
                $(".ecourse-inputs .edit-course").click(function(e){
                    e.preventDefault();
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
                        alert("Please fill out major field name first. It cannot be empty.");
                        return;
                    }

                    var data = 'mycourse='+ encodeURI(value);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/RetrieveCourseFields'); ?>',
                        dataType: "json",
                        data: data,
                        async: false,
                        success:function(result){
                            $("#eCourseDiv-"+currentCourseForm +" #ecourse-prefix-"+currentCourseForm).val(result["myCoursePrefixID"]);
                            $("#eCourseDiv-"+currentCourseForm +" #ecourse-code-"+currentCourseForm).val(result["myCourseNumber"]);
                            $("#eCourseDiv-"+currentCourseForm +" #ecourse-description-"+currentCourseForm).val(result["myCourseAbstract"]);
                            $("#eCourseDiv-"+currentCourseForm +" #ecourse-notes-"+currentCourseForm).val(result["myCourseNote"]);
                            $("#eCourseDiv-"+currentCourseForm +" #ecourse-credits-"+currentCourseForm).val(result["myCourseCredits"]);
                        },
                        error:function(){
                            alert('error');
                        }
                    });

                    $("#eCourseDiv-"+currentCourseForm).css("display", "block");
                    $("#eCourseDiv-"+currentCourseForm +" #ecourse-name-"+currentCourseForm).val(value);
                });
                return false;
            }

            var updateCourse = function()
            {
                $("#save-ecourse-form").click(function(d) {

                    var btn = $(this);
                    var name = $(btn).attr('inputId');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var name  = $("#eCourseDiv-"+formIdno+ " #ecourse-name-"+formIdno).val();
                    var prefix  = $("#eCourseDiv-"+formIdno+ " #ecourse-prefix-"+formIdno).val();
                    var code  = $("#eCourseDiv-"+formIdno+ " #ecourse-code-"+formIdno).val();
                    var description  = $("#eCourseDiv-"+formIdno+ " #ecourse-description-"+formIdno).val();
                    var credits  = $("#eCourseDiv-"+formIdno+ " #ecourse-credits-"+formIdno).val();
                    var note  = $("#eCourseDiv-"+formIdno+ " #ecourse-notes-"+formIdno).val();

                    var data = 'name='+ encodeURI(name)  +  '&prefix='+ encodeURI(prefix) +  '&code='+ encodeURI(code)+
                                    '&description='+ encodeURI(description) + '&credits='+ encodeURI(credits) +  '&note='+ encodeURI(note) +
                                    '&catalogID='+ encodeURI(''+catalogID);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/UpdateCourse'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('Update was successful');
                            //data returned from php
                        },
                        error: function(data){
                            alert('error');
                        }
                    });
                    return false;
                });
            }

            var saveNewCourse = function()
            {
                $("#save-course-form").click(function(d) {

                    var btn = $(this);
                    var name = $(btn).attr('inputId');
                    //alert ( name);
                    var formIdno = name.substring(name.length - 1, name.length);

                    var name  = $("#CourseDiv-"+formIdno+ " #course-name-"+formIdno).val();
                    var prefix  = $("#CourseDiv-"+formIdno+ " #course-prefix-"+formIdno).val();
                    var code  = $("#CourseDiv-"+formIdno+ " #course-code-"+formIdno).val();
                    var description  = $("#CourseDiv-"+formIdno+ " #course-description-"+formIdno).val();
                    var credits  = $("#CourseDiv-"+formIdno+ " #course-credits-"+formIdno).val();
                    var note  = $("#CourseDiv-"+formIdno+ " #course-notes-"+formIdno).val();

                    var data = 'name='+ encodeURI(name) + '&prefix='+ encodeURI(prefix) + '&code='+ encodeURI(code) + '&description='+ encodeURI(description) +
                            '&credits='+ encodeURI(credits) + '&note='+ encodeURI(note)+
                            '&catalogID='+ encodeURI(''+catalogID);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo  Yii::app()->createUrl('catalog/prospective/SaveNewCourse'); ?>',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            alert('Save was successful' );
                            //data returned from php
                        },
                        error: function(data){
                            alert('error');
                        }
                    });
                    return false;
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
            saveNewCourse();

            /*add a new edit course row*/
            $(".edit-course-field-rows").click(function(e){
                e.preventDefault();
                var CourseList = <?php echo json_encode(getCourses()) ?>;

                var stringeCourseRow = '<div>' +
                                            '<select id="my-prospective-ecourse-' + (no_ecourse) + '">'+
                                            CourseList +
                                            '</select>'+
                                                //'<input type="text" name="my-prospective-majors[]" id="my-prospective-major-'+ (no_majors) +'">'  +
                                            '<button class="edit-course" inputId="my-prospective-ecourse-'+ (no_ecourse) +'" >Edit</button>' +
                                            '<button class="remove-course">Remove</button>' +
                                        '</div>';

                var stringeCourseForm = '<div id="eCourseDiv-'+(no_ecourse)+'">'+
                                            '<form class="prospectiveForm" action="#" id="CourseForm">' +
                                            '<h3>Edit Course Form</h3>'+
                                            '<label>Name: </label>'+
                                            '<input type="text" id="ecourse-name-'+no_ecourse+'" placeholder="Course Name" required readonly/></br>'+
                                            '<label>Prefix: <span>*</span></label>'+
                                            '<input type="text" id="ecourse-prefix-'+no_ecourse+'" placeholder="Course Prefix" required/></br>'+
                                            '<label>Code: <span>*</span></label>'+
                                            '<input type="text" id="ecourse-code-'+no_ecourse+'" placeholder="Course Code" required/></br>'+
                                            '<label>Number of Credits: </label>'+
                                            '<input type="text" id="ecourse-credits-'+no_ecourse+'" placeholder="Number of credits" required/></br>'+
                                            '<label>Description: <span>*</span></label>'+
                                            '<textarea id="ecourse-description-'+no_ecourse+'" placeholder="Course Description" required/></br>'+
                                            '<label>Notes <span>*</span></label>'+
                                            '<textarea id="ecourse-notes-'+no_ecourse+'" placeholder="Course Notes" required/></br>'+
                                            '<button class="prospective-save-btn" id="save-ecourse-form" inputId="save-ecourse-form-'+no_ecourse+'">Save</button>'+
                                            '<button class="prospective-close-btn" id="close-ecourse-form">Close</button>'+
                                            '<br/>'+
                                            '</form>'+
                                        '</div>';



                $(".ecourse-inputs").append(stringeCourseRow);
                $(".ecourse-inputs").append(stringeCourseForm);
                $("#eCourseDiv-"+no_ecourse).css({"opacity":"0.92",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "height": "100%",
                    "width": "100%",
                    "background": "#ffffff",
                    "display": "none"});
                $("#eCourseDiv-"+no_ecourse +" input").css({"width":"100%",
                                                            "border":"1px solid #999",
                                                            "border-radius":"3px"});

                /*registers pop up function for dynamically created major forms*/
                addeCourse();
                close_ecourse_form();
                updateCourse();
                no_ecourse++;
            })

            /*add row for group with its corresponding group pop up form*/
            $(".add-course-field-rows").click(function(e){
                e.preventDefault();
                ++no_course;

                var stringCourseForm = '<div id="CourseDiv-'+(no_course)+'">'+
                                            '<form class="prospectiveForm" action="#" id="CourseForm">' +
                                                '<h3>New Course Form</h3>'+
                                                '<label>Name: </label>'+
                                                '<input type="text" id="course-name-'+no_course+'" placeholder="Course Name" required/></br>'+
                                                '<label>Prefix: <span>*</span></label>'+
                                                '<input type="text" id="course-prefix-'+no_course+'" placeholder="Course Prefix" required/></br>'+
                                                '<label>Code: <span>*</span></label>'+
                                                '<input type="text" id="course-code-'+no_course+'" placeholder="Course Code" required/></br>'+
                                                '<label>Number of Credits: </label>'+
                                                '<input type="text" id="course-credits-'+no_course+'" placeholder="Number of credits" required/></br>'+
                                                '<label>Description: <span>*</span></label>'+
                                                '<textarea id="course-description-'+no_course+'" placeholder="Course Description" required/></br>'+
                                                '<label>Notes <span>*</span></label>'+
                                                '<textarea id="course-notes-'+no_course+'" placeholder="Course Notes" required/></br>'+
                                                '<button class="prospective-save-btn" id="save-course-form" inputId="save-course-form-'+no_course+'">Save</button>'+
                                                '<button class="prospective-close-btn" id="close-course-form">Close</button>'+
                                                '<br/>'+
                                            '</form>'+
                                        '</div>';

                var stringCourseRow = '<div>'+
                                            '<input type="text" name="my-prospective-courses[]" id="my-prospective-course-'+no_course+'"/>'+
                                            '<button class="add-course" inputId="my-prospective-course-'+no_course+'">Add</button>'+
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
                $("#CourseDiv-"+no_course +" input").css({"width":"100%",
                                                            "border":"1px solid #999",
                                                            "border-radius":"3px"});

                /*registers pop up function for dynamically created group forms*/
                addCourse();
                close_course_form();
                saveNewCourse();
            });

            /*removes row along with group*/
            $(".course-inputs").on("click", ".remove-course", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                return false;
            });

            /*removes edit row course*/
            $(".ecourse-inputs").on("click", ".remove-course", function(e){
                e.preventDefault();
                $(this).parent('div').remove();
                return false;
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

    /*get a majors select list*/
    function getMajors()
    {
        $majors = CurrMajor::model()->findAllBySql("select name from curr_major");
        $menu = '';

        foreach($majors as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

    /*get a list of minors*/
    function getMinors()
    {
        $minor = CurrMinor::model()->findAllBySql("select name from curr_minor");
        $menu = '';

        foreach($minor as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

    /*get a list of certificates*/
    function getCertificates()
    {
        $certificate = CurrCertificate::model()->findAllBySql("select name from curr_certificate");
        $menu = '';

        foreach($certificate as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

    /*get a list of tracks*/
    function getTracks()
    {
        $tracks = CurrTrack::model()->findAllBySql("select name from curr_track");
        $menu = '';

        foreach($tracks as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

    /*get a list of the current groups*/
    function getGroups()
    {
        $groups = CurrGroup::model()->findAllBySql("select name from curr_group");
        $menu = '';

        foreach($groups as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

    /*get a list of the current sets*/
    function getSets()
    {
        $sets = CurrSet::model()->findAllBySql("select name from curr_set");
        $menu = '';

        foreach($sets as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

    /*get a list of the current courses*/
    function getCourses()
    {
        $courses = CurrCourse::model()->findAllBySql("select name from curr_course");
        $menu = '';

        foreach($courses as $row)
        {
            $r1 = $row['name'];
            $menu .= '<option value="' . $r1 . '">' . $r1 . '</option>';
        }
        return $menu;
    }

/*foreach($users as $u){
    $data[$u->name] = $u->name;
}*/
?>




<div class="form">

<script type="text/javascript">
    window.onbeforeunload = function() {
        return "are you sure to leave this page";
    }
</script>
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
                <input type="text" class="catalog-name" name="prospective-catalog-name"/>
            </div>
        
            <div class="row">
                <div>
                    <label>Add Majors</label>
                    <button class="add-major-field-rows">+</button>
                    <button class="edit-major-field-rows">+edit</button>
                </div>
                <div class="major-inputs">
                    <div>
                        <input type="text" name="my-prospective-majors[]" id="my-prospective-major-0">
                        <button class="add-major" inputId="my-prospective-major-0">Add</button>
                        <!--<button id="edit-major">Edit</button>
                        <button id="remove-major">Remove</button>-->
                    </div>
                </div>
                <div class="emajor-inputs">
                </div>
            </div>
        
            <div class="row">
                <label>Add Minors</label>
                <button class="add-minor-field-rows">+</button>
                <button class="edit-minor-field-rows">+edit</button>
                <div class="minor-inputs">
                    <div>
                        <input type="text" name="my-prospective-minors[]" id="my-prospective-minor-0"/>
                        <button class="add-minor" inputId="my-prospective-minor-0">Add</button>
                        <!--<button id="edit-minor">Edit</button>
                        <button id="remove-minor">Remove</button>-->
                    </div>
                </div>
                <div class="eminor-inputs">
                </div>
            </div>

            <div class="row">
                <label>Add Certificates</label>
                <button class="add-certificate-field-rows">+</button>
                <button class="edit-certificate-field-rows">+edit</button>
                <div class="certificate-inputs">
                    <div>
                        <input type="text" name="my-prospective-certificates[]" id="my-prospective-certificate-0"/>
                        <button class="add-certificate" inputId="my-prospective-certificate-0">Add</button>
                        <!--<button id="edit-certificate">Edit</button>
                        <button id="remove-certificate">Remove</button>-->
                    </div>
                </div>
                <div class="ecertificate-inputs">
                </div>
            </div>

            <div class="row">
                <label>Add Tracks</label>
                <button class="add-track-field-rows">+</button>
                <button class="edit-track-field-rows">+edit</button>
                <div class="track-inputs">
                    <div>
                        <input type="text" name="my-prospective-tracks[]" id="my-prospective-track-0"/>
                        <button class="add-track" inputId="my-prospective-track-0">Add</button>
                        <!--<button id="edit-track">Edit</button>
                        <button id="remove-track">Remove</button>-->
                    </div>
                </div>
                <div class="etrack-inputs">
                </div>
            </div>

            
            <div class="row">
                <label>Add Groups</label>
                <button class="add-group-field-rows">+</button>
                <button class="edit-group-field-rows">+edit</button>
                <div class="group-inputs">
                    <div>
                        <input type="text" name="my-prospective-groups[]" id="my-prospective-group-0"/>
                        <button class="add-group" inputId="my-prospective-group-0">Add</button>
                        <!--<button id="edit-group">Edit</button>
                        <button id="remove-group">Remove</button>-->
                    </div>
                </div>
                <div class="egroup-inputs">
                </div>
            </div>
        
            <div class="row">
                <label>Add Sets</label>
                <button class="add-set-field-rows">+</button>
                <button class="edit-set-field-rows">+edit</button>
                <div class="set-inputs">
                    <div>
                        <input type="text" name="my-prospective-sets[]" id="my-prospective-set-0"/>
                        <button class="add-set" inputId="my-prospective-set-0">Add</button>
                        <!--<button id="edit-set">Edit</button>
                        <button id="remove-set">Remove</button>-->
                    </div>
                </div>
                <div class="eset-inputs">
                </div>
            </div>
        
            <div class="row">
                <label>Add Courses</label>
                <button class="add-course-field-rows">+</button>
                <button class="edit-course-field-rows">+edit</button>
                <div class="course-inputs">
                    <div>
                        <input type="text" name="my-prospective-courses[]" id="my-prospective-course-0"/>
                        <button class="add-course" inputId="my-prospective-course-0">Add</button>
                        <!--<button id="edit-course">Edit</button>
                        <button id="remove-course">Remove</button>-->
                    </div>
                </div>
                <div class="ecourse-inputs">
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
            <select id="group-selected-0">
                <?php
                    echo getGroups();
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
        <h3>New Course Form</h3>
        <label>Name: </label>
        <input type="text" id="course-name-0" placeholder="Course Name" required/></br>
        <label>Prefix: <span>*</span></label>
        <input type="text" id="course-prefix-0" placeholder="Course Prefix" required/></br>
        <label>Code: <span>*</span></label>
        <input type="text" id="course-code-0" placeholder="Course Code" required/></br>
        <label>Number of Credits: </label>
        <input type="text" id="course-credits-0" placeholder="Number of credits" required/></br>
        <label>Description: <span>*</span></label>
        <textarea id="course-description-0" placeholder="Course Description" required/></textarea></br>
        <label>Notes <span>*</span></label>
        <textarea id="course-notes-0" placeholder="Course Notes" required/></textarea></br>
        <button class="prospective-save-btn" id="save-course-form" inputId="save-course-form-0">Save</button>
        <button class="prospective-close-btn" id="close-course-form">Close</button>
        <br/>
    </form>
</div>';


  

   
            
        
            
        