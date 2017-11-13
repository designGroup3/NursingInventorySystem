<?php
include 'header.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
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
                first_name: {
                    validators: {
                        stringLength: {
                            min: 2,
                        },
                        notEmpty: {
                            message: 'Please supply your first name'
                        }
                    }
                },
                last_name: {
                    validators: {
                        stringLength: {
                            min: 2,
                        },
                        notEmpty: {
                            message: 'Please supply your last name'
                        }
                    }
                },cost: {
                    validators: {
                        numeric:{
                            decimalSeparator : true,
                            thousandsSeparator :true,
                            message: 'Please add a valid Cost'



                        },
                        notEmpty: {
                            message: 'Please add a valid Cost'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your email address'
                        },
                        emailAddress: {
                            message: 'Please supply a valid email address'
                        }
                    }
                }
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
<?php if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $id = $_GET['edit'];
    echo "<head><Title>Edit Service Agreement</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";
    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=wrongType') !== false){
        echo "<br>&nbsp&nbspApproval forms must a .pdf file.<br>";
    }
    $sql="SELECT * FROM serviceAgreements WHERE Id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo "<div class=\"container\"><form class=\"well form-horizontal\" action ='includes/editServiceAgreement.inc.php'
        method ='POST' id=\"contact_form\" enctype='multipart/form-data'><fieldset>
        <h2 align=\"center\">Edit Service Agreement</h2><br/>
        <input type='hidden' name='id' value = $id><div class=\"form-group\">
        <label class=\"col-md-4 control-label\">Name:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label><div class=\"col-md-4 inputGroupContainer\">
        <div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-tag\"></i></span>
        <input name=\"name\" class=\"form-control\" required type=\"text\" value=\"".$row['Name']."\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\" >Annual Cost:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-usd\"></i></span>
        <input name='cost' class='form-control data-fv-numeric-decimalseparator' required 
        title=\"A valid number should not contain letters or commas or more than one decimal point e.g. 50.50 for fifty dollars and fifty cents\" 
        value='".$row['Annual Cost']."'>
        </div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Duration:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
        <input type='text' name='duration' required value=\"".$row['Duration']."\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Expiration Date:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-calendar-times-o\"></i></span>
        <input type='date' name='date' required value=\"".$row['Expiration Date']."\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"> Approval Form:</label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <label for=\"file-upload\" class=\"custom-file-upload\"></label><input type='file' name='file' id='file'
        style='position:relative; bottom:13px;'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button type='submit' class='btn btn-warning btn-block'>Edit Service Agreement</button></div></div></fieldset></form></div>";
}
else{
    header("Location: ./login.php");
}
?>
