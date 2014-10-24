<style>
    @import url(http://fonts.googleapis.com/css?family=Fauna+One|Muli);
    h3{
        font-size:18px;
        text-align:center;
        text-shadow:1px 0px 3px gray;
    }

    #remove-course, #remove-major, #remove-set, #remove-minor, #remove-certificate, #remove-group, #remove-track
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
        left: 30%;
        top: 30%;
        margin-left:-210px;
        margin-top:-255px;
    }

    textarea{
        width:100%;
        height:80px;
        margin-top:5px;
        border-radius:3px;
        padding:5px;
        resize:none;
    }

    #CourseDiv {
        opacity:0.92;
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;
        background: #ffffff;
        display: none;
    }

    #CourseForm{
        width:350px;
        margin:0px;
        background-color:white;
        font-family: 'Fauna One', serif;
        position: relative;
        border: 5px solid rgb(90, 158, 181);
    }


</style>
<script>
    $(document).ready(function(){

        $('#add-course').click(function(){
            $('#add-course').hide();
            $('#remove-course').show();
            $('#CourseDiv').css("display", "block");

        });

        $('#edit-course').click(function(){
            alert('Please edit the following file');
        });

        $('#remove-course').click(function(){
            $('#add-course').show();
            $('#remove-course').hide();
        });

        $("#close-course-form").click(function(){
            $("#CourseDiv").css("display", "none");
            $("#add-course").show();
            $("#remove-course").hide();
        });

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
                <label>Add Majors</label>
                <input type="text" name="prospective-major-name"/>
                <button id="add-major">Add</button>
                <button id="edit-major">Edit</button>
                <button id="remove-major">Remove</button>
            </div>
        
            <div class="row">
                <label>Add Minors</label>
                <input type="text" name="prospective-minor-name"/>
                <button id="add-minor">Add</button>
                <button id="edit-minor">Edit</button>
                <button id="remove-minor">Remove</button>
            </div>

            <div class="row">
                <label>Add Tracks</label>
                <input type="text" name="prospective-track-name"/>
                <button id="add-track">Add</button>
                <button id="edit-track">Edit</button>
                <button id="remove-track">Remove</button>
            </div>

            <div class="row">
                <label>Add Certificates</label>
                <input type="text" name="prospective-certificate-name"/>
                <button id="add-certificate">Add</button>
                <button id="edit-certificate">Edit</button>
                <button id="remove-certificate">Remove</button>
            </div>
            
            <div class="row">
                <label>Add Groups</label>
                <input type="text" name="prospective-group-name"/>
                <button id="add-group">Add</button>
                <button id="edit-group">Edit</button>
                <button id="remove-group">Remove</button>
            </div>
        
            <div class="row">
                <label>Add Sets</label>
                <input type="text" name="prospective-set-name"/>
                <button id="add-set">Add</button>
                <button id="edit-set">Edit</button>
                <button id="remove-set">Remove</button>
             </div>
        
            <div class="row">
                <label>Add Courses</label>
                <input type="text" name="prospective-course-name"/>
                <button id="add-course">Add</button>
                <button id="edit-course">Edit</button>
                <button id="remove-course">Remove</button>
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


    <!-- Course Form -->
    <div id="CourseDiv">
        <form class="prospectiveForm" action="#" id="CourseForm">
            <h3>Course Form</h3>
            <label>Prefix: <span>*</span></label>
            <input type="text" id="course-prefix" placeholder="Course Prefix"/></br>
            <label>Code: <span>*</span></label>
            <input type="text" id="course-code" placeholder="Course Code"/></br>
            <label>Name: <span>*</span></label>
            <input type="text" id="course-name" placeholder="Course Name"/></br>
            <label>Description: <span>*</span></label>
            <input type="text" id="course-description" placeholder="Course Description"/></br>
            <button id="save-course-form">Save</button>
            <button id="close-course-form">Close</button>
            <br/>
        </form>
    </div>


  

   
            
        
            
        