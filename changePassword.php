<?php
include 'header.php';
?>
    <script src="js/bootstrapvalidator.min.js"></script>
    <script src="js/angular.min.js"></script>
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/v2.3.8/angular-strap.min.js"></script>-->
    <body>
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
    echo "<head>
              <Title>Change Password</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    error_reporting(E_ALL ^ E_NOTICE);
    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    if(strpos($url, 'error=wrongPassword') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Old password is incorrect.</div><br><br><br>";
    }
    if(strpos($url, 'error=noPassword') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              New password cannot be empty.</div><br><br><br>";
    }
    if(strpos($url, 'error=noMatch') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Your new password does not match.</div><br><br><br>";
    }
    if(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Your password has been changed successfully. Please log in with your new password.</div><br><br><br>";
    }

    echo "<div class=\"container\">
              <form action ='includes/changePassword.inc.php' method ='POST'
              class=\"well form-horizontal\" id=\"contact_form\">
                  <fieldset>
                      <h2 align=\"center\">Change Password</h2><br/>
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Old Password:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-unlock-alt\"></i>
                                  </span>
                                  <input type='password' name='oldPassword' class=\"form-control\" id='pwd'
                                  pattern=\"(?!.*[\\\\])(?!.*[\'])(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
                                  title=\"Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters. Passwords cannot contain \ or '.\" required>
                              </div>
                          </div>
                      </div>
                      
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">New Password:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-lock\"></i>
                                  </span>
                                  <input type='password' name='newPassword' class=\"form-control\" id='pwd'
                                  pattern=\"(?!.*[\\\\])(?!.*[\'])(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
                                  title=\"Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters. Passwords cannot contain \ or '.\" required>
                              </div>
                          </div>
                      </div>
                      
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Confirm New Password:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-lock\"></i>
                                  </span>
                                  <input type='password' name='confirmNewPassword' class=\"form-control\" id='pwd'
                                  pattern=\"(?!.*[\\\\])(?!.*[\'])(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" 
                                  title=\"Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters. Passwords cannot contain \ or '.\" required>
                              </div>
                          </div>
                      </div>
                      
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <button type=\"submit\" class=\"btn btn-warning btn-block\">Change Password</button>
                          </div>
                      </div><br><br>
                  </fieldset>
              </form>
          </div>";
}
else{
    header("Location: ./login.php");
}
?>