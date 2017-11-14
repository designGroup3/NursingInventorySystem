<?php
include 'header.php';
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/v2.3.8/angular-strap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <body>
    <style>
        #message {
            display:none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }
        /*makes the success message go away*/
        #success_message{ display: none;}
        /* The message box is shown when the user clicks on the password field */
        #message {
            display:none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 15px;
            text-align:center;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>
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
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Please add an email address'
                            },
                            emailAddress: {
                                message: 'Please supply a valid email address'
                            }
                        }
                    }
                }
            })
        });
    </script>
<?php

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Change Password</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    error_reporting(E_ALL ^ E_NOTICE);
    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    if(strpos($url, 'error=wrongPassword') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Old password is incorrect.</div><br><br><br>";
        //echo "<br>&nbsp&nbspOld password is incorrect.<br>";
    }
    if(strpos($url, 'error=noPassword') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              New password cannot be empty.</div><br><br><br>";
        //echo "<br>&nbsp&nbspNew password cannot be empty.<br>";
    }
    if(strpos($url, 'error=noMatch') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Your new password does not match.</div><br><br><br>";
        //echo "<br>&nbsp&nbspYour new password does not match.<br>";
    }
    if(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Your password has been changed successfully. Please log in with your new password.</div><br><br><br>";
        //echo "<br>&nbsp&nbspYour password has been changed successfully, please log in with your new password.<br>";
    }

    echo "<div class=\"container\"><form action ='includes/changePassword.inc.php' method ='POST'
          class=\"well form-horizontal\" id=\"contact_form\"><fieldset><h2 align=\"center\">Change Password</h2><br/>
          
          <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Old Password:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-unlock-alt\"></i></span>
          <input type='password' name='oldPassword' class=\"form-control\"id='pwd'
          pattern=\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
          title=\"Must contain at least one number and one uppercase and lowercase letter,
          and at least 8 or more characters\" required></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">New Password:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-lock\"></i></span>
          <input type='password' name='newPassword' class=\"form-control\" id='pwd'
          pattern=\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
          title=\"Must contain at least one number and one uppercase and lowercase letter,
          and at least 8 or more characters\" required></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">Confirm New Password:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-lock\"></i></span>
          <input type='password' name='confirmNewPassword' class=\"form-control\" id='pwd'
          pattern=\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
          title=\"Must contain at least one number and one uppercase and lowercase letter,
          and at least 8 or more characters\" required></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
          <button type=\"submit\" class=\"btn btn-warning btn-block\">Change Password</button></div></div><br><br></fieldset>
          </form></div>";
}
else{
    header("Location: ./login.php");
}
?>