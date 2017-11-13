<?php
include 'header.php';
//include "inputJS.php";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/v2.3.8/angular-strap.min.js"></script>
<body>
<script>
    $(document).ready(function() {
        $('#contact_form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        regexp: {
                            regexp: /^[a-z\s]+$/i,
                            message: 'The full name can consist of alphabetical characters and spaces only'
                        }
                    }
                },
            }
        })
            .on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    console.log(result);
                }, 'json');
            });
    });
</script>
<?php
if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Add Inventory Column</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspA column already exists by that name.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the column.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspColumn added successfully.<br>";
    }

    echo "<div class=\"container\"><form class=\"well form-horizontal\" id=\"contact_form\"
          action ='includes/addInventoryColumn.inc.php' method = 'POST'><fieldset><h2 align=\"center\">
          Add Inventory Column</h2><br/><div class=\"form-group\"><label class=\"col-md-4 control-label\">Column Name:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-columns\"></i></span>
          <input type='text' class=\"form-control\" required name='name'></div></div></div>
          
          <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Data Type:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-server\"></i></span>
          <select name ='type' required class=\"form-control selectpicker\">
          <option value=''></option><option value='varchar'>Letters & Numbers</option>
          <option value='tinyint'>Yes or No</option></select></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
          <button type=\"submit\" class=\"btn btn-warning btn-block\">Add Column</button></div></div><br><br></fieldset>
          </form></div>";
}
else{
    header("Location: ./login.php");
}

?>