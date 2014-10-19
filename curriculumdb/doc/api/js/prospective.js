
$(document).ready(function(){

    $('#add-course').click(function(){
        $('#add-course').hide();
        $('#courseForm').css("display", "block");
        $('#remove-course').show();
    });

    $('#edit-course').click(function(){
        alert('Please edit the following file');
    });

    $('#remove-course').click(function(){
        $('#add-course').show();
        $('#remove-course').hide();
    });
});