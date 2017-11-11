<?php
include 'header.php';
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
            fields: {email: {
                validators: {
                    notEmpty: {
                        message: 'Please input your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            }
            }
        }).on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow");// Do something ...
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
echo"<head><Title>Forgot Password</Title></head><div class=\"parent\">
<button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
<i class='fa fa-question'></i></button></div>";

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'error=email') !== false){
    echo "<br>&nbsp&nbspThere is no account with this email address in the system.<br>";
    exit();
}
if(strpos($url, 'sent') !== false){
    echo "<br>&nbsp&nbsp A recovery email has been sent to your email address. Please check your email.<br>";
    exit();
}
echo "<div class=\"container\"><form action ='includes/forgotPassword.inc.php' class=\"well form-horizontal\" 
    method ='POST' id='contact_form'><fieldset><h2 align='center'>Forgot Password? No worries,</h2><p align='center'
    style=\"text-size:13pt;\">just type in your email address and we will send you a password reset email.</p><br/>
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">E-Mail</label>  
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>
    <input type='email' name='email' placeholder='E-Mail Address' class=\"form-control\"></div></div></div>
    <br/><div class=\"form-group\" align=\"center\"><label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\"><input name=\"export\" type=\"submit\" class=\"btn btn-warning\" value='Send Password Reset Email'>
    </div></div></fieldset></form></div>";
?>