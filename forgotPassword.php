<?php
ob_start();
session_start();
include './dbh.php';
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .parent {
            position: relative;
        }
        .help {
            position: absolute;
            right: 10px;
            top: 5px;
        }

        .nav-tabs {
            display: inline-block;
            border-bottom: none;
            padding-top: 15px;
            font-weight: bold;
        }
        .nav-tabs > li > a,
        .nav-tabs > li > a:hover,
        .nav-tabs > li > a:focus,
        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:hover,
        .nav-tabs > li.active > a:focus {
            border: none;
            border-radius: 0;
        }
        .nav-tabs > li > a:hover {
            color: #444444;
            TEXT-DECORATION: none; font-weight: none;
        }
        .nav-list {}
        .nav-list > li {
            padding: 20px 15px 15px;

        }
        .nav-list > li:last-child {}
        .nav-list > li > a:hover { text-decoration: none; }
        .nav-list > li > a > span {
            display: block;
            font-weight: bold;
            text-transform: uppercase;
        }

        .mega-dropdown { position: static !important; }
        .mega-dropdown-menu {
            padding: 20px 15px 15px;
            text-align: center;
            width: 100%;
        }


        #login-dp{
            min-width: 250px;
            padding: 14px 14px 0;
            overflow:hidden;
            background-color:rgba(255,255,255,.8);
        }
        #login-dp .help-block{
            font-size:12px
        }
        #login-dp .bottom{
            background-color:rgba(255,255,255,.8);
            border-top:1px solid #ddd;
            clear:both;
            padding:14px;
        }

        @media(max-width:768px){
            #login-dp{
                background-color: inherit;
                color: #fff;
            }
            #login-dp .bottom{
                background-color: inherit;
                border-top:0 none;
            }
        }
        .navbar-login
        {
            width: 305px;
            padding: 10px;
            padding-bottom: 0px;
        }

        .navbar-login-session
        {
            padding: 10px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .icon-size
        {
            font-size: 57px;
        }
        .navbar-brand {
            width: 100px;
            height: 50px;
            background-size: 50px;
            padding-top: 7px;
        }
        .navbar-nav {
            padding-left: 15px;
        }
        .navbar-default .navbar-collapse, .navbar-default .navbar-form {
            border-color: #EAAB00;
        }
        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            background-color: #981E32;
        }

        .navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:hover, .navbar-default .navbar-nav>.active>a:focus {
            color: white;
            background-color: #EAAB00;

        }
        .navbar-default .navbar-nav>li>a {
            color: white;
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0px;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0px;
            margin: 2px 0px 0px;
            font-size: 14px;
            list-style: none;
            background-color: white;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.14902);
            border-image-source: initial;
            border-image-slice: initial;
            border-image-width: initial;
            border-image-outset: initial;
            border-image-repeat: initial;
            border-radius: 4px;
            box-shadow: rgba(0, 0, 0, 0.172549) 0px 6px 12px;

        .nav-list > li {
            padding: 20px 15px 15px;
            border-left:0px;
        }
        .nav-list {
            border-bottom: 0px;
        }
    </style>
    <meta charset="UTF-8">
    <!--<title>Nursing Inventory System</title>
    <link rel="stylesheet" type="text/css" href="style.css">-->
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
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
<button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
<i class='fa fa-question'></i></button></div>";

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'error=email') !== false){
    echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
    col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
    There is no account with this email address in the system.</div><br><br><br>";
}
if(strpos($url, 'sent') !== false){
    echo "<br><div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2
    col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
    A recovery email has been sent to your email address. Please check your email.</div><br><br><br>";
    exit();
}
echo "<br><div class=\"container\"><form action ='includes/forgotPassword.inc.php' class=\"well form-horizontal\" 
    method ='POST' id='contact_form'><fieldset><h2 align='center'>Forgot Password? No worries,</h2><p align='center'
    style=\"text-size:13pt;\">Just type in your email address and we will send you a password reset email.</p><br/>
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">E-Mail:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>   
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>
    <input type='email' name='email' placeholder='E-Mail Address' class=\"form-control\"></div></div></div>
    <br/><div class=\"form-group\" align=\"center\"><label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\"><input name=\"export\" type=\"submit\" class=\"btn btn-warning\" value='Send Password Reset Email'>
    </div></div></fieldset></form></div>";
?>