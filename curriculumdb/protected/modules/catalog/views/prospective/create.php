
<?php
Include 'createProspectiveJs.php';
Include 'createProspectiveCSS.php';
?>


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
   /* window.onbeforeunload = function() {
        return "are you sure to leave this page";
    }*/
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
                <input type="text" class="catalog-name" id="prospective-catalog-name" required/>
            </div>
            <div class="row">
                <label>Description</label>
                <textarea id="catalog-description"></textarea>
            </div>
            <div class="row">
                <label>Term to be Activated</label>
                <select id="catalog-term">
                    <option value="SPRING">SPRING</option>
                    <option value="SUMMER">SUMMER</option>
                    <option value="FALL">FALL</option>
                </select>
            </div>
            <div class="row">
                <label>Year to be Activated</label>
                <input type="text" id="catalog-year" required/>
            </div>
            <div>
                <button class="new-catalog" id="new-catalog">Create New Catalog</button>
            </div>


            <div class="prospective-fields">
                <div class="row">
                    <div>
                        <label>Add Majors</label>
                        <button class="add-major-field-rows">+</button>
                        <button class="edit-major-field-rows">+edit</button>
                    </div>
                    <div class="major-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-majors[]" id="my-prospective-major-0">
                            <button class="add-major" inputId="my-prospective-major-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Majors</label>
                    <div class="emajor-inputs">
                    </div>
                </div>

                <div class="row">
                    <label>Add Minors</label>
                    <button class="add-minor-field-rows">+</button>
                    <button class="edit-minor-field-rows">+edit</button>
                    <div class="minor-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-minors[]" id="my-prospective-minor-0"/>
                            <button class="add-minor" inputId="my-prospective-minor-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Minors</label>
                    <div class="eminor-inputs">
                    </div>
                </div>

                <div class="row">
                    <label>Add Certificates</label>
                    <button class="add-certificate-field-rows">+</button>
                    <button class="edit-certificate-field-rows">+edit</button>
                    <div class="certificate-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-certificates[]" id="my-prospective-certificate-0"/>
                            <button class="add-certificate" inputId="my-prospective-certificate-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Certificate</label>
                    <div class="ecertificate-inputs">
                    </div>
                </div>

                <div class="row">
                    <label>Add Tracks</label>
                    <button class="add-track-field-rows">+</button>
                    <button class="edit-track-field-rows">+edit</button>
                    <div class="track-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-tracks[]" id="my-prospective-track-0"/>
                            <button class="add-track" inputId="my-prospective-track-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Tracks</label>
                    <div class="etrack-inputs">
                    </div>
                </div>

                <div class="row">
                    <label>Add Groups</label>
                    <button class="add-group-field-rows">+</button>
                    <button class="edit-group-field-rows">+edit</button>
                    <div class="group-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-groups[]" id="my-prospective-group-0"/>
                            <button class="add-group" inputId="my-prospective-group-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Groups</label>
                    <div class="egroup-inputs">
                    </div>
                </div>

                <div class="row">
                    <label>Add Sets</label>
                    <button class="add-set-field-rows">+</button>
                    <button class="edit-set-field-rows">+edit</button>
                    <div class="set-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-sets[]" id="my-prospective-set-0"/>
                            <button class="add-set" inputId="my-prospective-set-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Sets</label>
                    <div class="eset-inputs">
                    </div>
                </div>

                <div class="row">
                    <label>Add Courses</label>
                    <button class="add-course-field-rows">+</button>
                    <button class="edit-course-field-rows">+edit</button>
                    <div class="course-inputs">
                        <div>
                            <!--<input type="text" name="my-prospective-courses[]" id="my-prospective-course-0"/>
                            <button class="add-course" inputId="my-prospective-course-0">Add</button>-->
                        </div>
                    </div>
                    <label>Editable Courses</label>
                    <div class="ecourse-inputs">
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
                <button class="prospective-fields" id="new-prospective-catalog">Propose Prospective Catalog</button>
            </div>



    <?php /*$this->endWidget();*/ ?>
  </div><!-- form -->

    <!-- Major Form -->
    <div id="MajorDiv-0">
        <form class="prospectiveForm" action="#" id="MajorForm">
            <h3>Major Form</h3>
            <label>Major Name </label>
            <input type="text" id="major-name-0" placeholder="Major Name" required readonly/></br>
            <label>Description: <span>*</span></label>
            <textarea id="major-description-0" placeholder="Major Description" required/></textarea></br>
            <button class="add-track-to-major-field-rows">+</button>
            <div class="track-to-major-0">
                <div>
                    <input style="width:65%" type="text" name="my-prospective-major-0[]" />
                    <button style="width:30%" class="remove-track-in-new-major">Remove</button>
                </div>
            </div>
            <button class="prospective-save-btn" id="save-major-form" inputId="save-minor-form-0">Save</button>
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
            <label>Description: <span>*</span></label>
            <textarea id="minor-description-0" placeholder="Minor Description" required/></textarea></br>
            <label>Min Credits: <span>*</span></label>
            <input type="text" id="minor-mincredits-0" placeholder="Min credits" required/></br>
            <button class="add-group-to-minor-field-rows">+</button>
            <div class="group-to-minor-0">
                <div>
                    <input style="width:65%" type="text" name="my-prospective-minor-0[]" />
                    <button style="width:30%" class="remove-group-in-new-minor">Remove</button>
                </div>
            </div>
            <button class="prospective-save-btn" id="save-minor-form" inputId="save-minor-form-0">Save</button>
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
            <label>Description: <span>*</span></label>
            <textarea id="track-description-0" placeholder="Track Description" required/></textarea></br>
            <label>Min Credits: <span>*</span></label>
            <input type="text" id="track-mincredits-0" placeholder="Min credits" required/></br>
            <button class="add-group-to-track-field-rows">+</button>
            <div class="group-to-track-0">
                <div>
                    <input style="width:65%" type="text" name="my-prospective-track-0[]" />
                    <button style="width:30%" class="remove-group-in-new-track">Remove</button>
                </div>
            </div>
            <button class="prospective-save-btn" id="save-track-form" inputId="save-track-form-0">Save</button>
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
            <label>Description: <span>*</span></label>
            <textarea id="certificate-description-0" placeholder="Certificate Description" required/></textarea></br>
            <label>Min Credits: <span>*</span></label>
            <input type="text" id="certificate-mincredits-0" placeholder="Min credits" required/></br>
            <button class="add-group-to-certificate-field-rows">+</button>
            <div class="group-to-certificate-0">
                <div>
                    <input style="width:65%" type="text" name="my-prospective-certificate-0[]" />
                    <button style="width:30%" class="remove-group-in-new-certificate">Remove</button>
                </div>
            </div>
            <button class="prospective-save-btn" id="save-certificate-form" inputId="save-certificate-form-0">Save</button>
            <button class="prospective-close-btn" id="close-certificate-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Group Form -->
    <div id="GroupDiv-0">
        <form class="prospectiveForm" action="#" id="GroupForm">
            <h3>New Group Form</h3>
            <label>Group Name: </label>
            <input type="text" id="group-name-0" placeholder="Group Name" required readonly/></br>
            <label>Description: <span>*</span></label>
            <textarea id="group-description-0" placeholder="Group Description" required/></textarea></br>
            <label>Min Credits: <span>*</span></label>
            <input type="text" id="group-mincredits-0" placeholder="Min credits" required/></br>
            <label>Max Credits: <span>*</span></label>
            <input type="text" id="group-maxcredits-0" placeholder="Max credits" required/></br>
            <button class="add-set-to-group-field-rows">+</button>
            <div class="set-to-group-0">
                <div>
                    <input style="width:65%" type="text" name="my-prospective-group-0[]" />
                    <button style="width:30%" class="remove-set-in-new-group">Remove</button>
                </div>
            </div>
            <button class="prospective-save-btn" id="save-group-form" inputId="save-group-form-0">Save</button>
            <button class="prospective-close-btn" id="close-group-form">Close</button>
            <br/>
        </form>
    </div>

    <!-- Set Form -->
    <div id="SetDiv-0">
        <form class="prospectiveForm" action="#" id="SetForm">
            <h3>New Set Form</h3>
            <label>Set Name: </label>
            <input type="text" id="set-name-0" placeholder="Set Name" required readonly/></br>
            <label>Description: <span>*</span></label>
            <textarea id="set-description-0" placeholder="Set Description" required/></textarea></br>
            <label>Min Credits: <span>*</span></label>
            <input type="text" id="set-mincredits-0" placeholder="Min credits" required/></br>
            <label>Max Credits: <span>*</span></label>
            <input type="text" id="set-maxcredits-0" placeholder="Max credits" required/></br>
            <button class="add-course-to-set-field-rows">+</button>
            <div class="course-to-set-0">
                <div>
                    <input style="width:65%" type="text" name="my-prospective-set-0[]" />
                    <button style="width:30%" class="remove-course-in-new-set">Remove</button>
                </div>
            </div>
            <button class="prospective-save-btn" id="save-set-form" inputId="save-set-form-0">Save</button>
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
</div>


  

   
            
        
            
        