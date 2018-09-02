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
       </style>
       <meta charset="UTF-8">
    </head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
    <script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="js/bootstrapvalidator.min.js"></script>
    <script src="js/angular.min.js"></script>
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/v2.3.8/angular-strap.min.js"></script>-->
    <body>
    <script>
        $(document).ready(function() {
            $('#contact_form').bootstrapValidator({
                // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }
            })
        });
    </script>
<?php
error_reporting(E_ALL ^ E_NOTICE);

echo "<head>
          <Title>New Password</Title>
      </head>
      <div class=\"parent\">
          <button class='help' onclick=\"window.location.href='./UserManual.pdf#page=5'\">
              <i class='fa fa-question'></i>
          </button>
      </div><br>";

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$email = $_GET['email'];
$sentKey = $_GET['pwdRecoveryKey'];

$pwdRecoveryKey;
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

$checkSql = "SELECT * FROM users WHERE `Email` = '$email' AND `Pwd Recovery Key` = '$sentKey';";
$checkResult = mysqli_query($conn, $checkSql);
if(mysqli_num_rows($checkResult) == 0 && strpos($url, 'error=noMatch')){
    echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='login.php';\" class='btn btn-warning' value='Back'>
              </div>";
    exit();
}

$sql = "SELECT `Pwd Recovery Key` FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if($row = $result->fetch_assoc()) {
    $pwdRecoveryKey = $row['Pwd Recovery Key'];
    if($sentKey !== $pwdRecoveryKey){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Wrong recovery key sent back. Please contact administrator.</div><br><br><br>";
        exit();
    }
}
echo "<div class=\"container\">
          <form action='includes/newPassword.inc.php' method='POST' class=\"well form-horizontal\" id=\"contact_form\">
              <fieldset>
                  <h2 align=\"center\">New Password</h2><br/>
                  <input type='hidden' name='email' value=$email>
                  <input type='hidden' name='pwdRecoveryKey' value=$pwdRecoveryKey>
    
                  <div class=\"form-group\">
                      <label class=\"col-md-4 control-label\" for=\"psw\">New Password:
                          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                      </label>
                      <div class=\"col-md-4 inputGroupContainer\">
                          <div class=\"input-group\">
                              <span class=\"input-group-addon\">
                                  <i class=\"glyphicon glyphicon-lock\"></i>
                              </span>
                              <input name='newPassword' placeholder='New Password' class='form-control' type='password' id='pwd' pattern=\"(?!.*[\\\\])(?!.*[\'])(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" title=\"Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters. Passwords cannot contain \ or '.\" required>
                          </div>
                      </div>
                  </div>
    
                  <div class=\"form-group\">
                      <label class=\"col-md-4 control-label\" for=\"psw\">Confirm New Password:
                          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                      </label>
                      <div class=\"col-md-4 inputGroupContainer\">
                          <div class=\"input-group\">
                              <span class=\"input-group-addon\">
                                  <i class=\"glyphicon glyphicon-lock\"></i>
                              </span>
                              <input name='confirmNewPassword' placeholder='Confirm New Password' class='form-control' type='password' id='pwd' pattern=\"(?!.*[\\\\])(?!.*[\'])(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" title=\"Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters. Passwords cannot contain \ or '.\" required>
                          </div>
                      </div>
                  </div><br/>
                  
                  <div class=\"form-group\" align=\"center\">
                      <label class=\"col-md-4 control-label\"></label>
                      <div class=\"col-md-4\">
                          <input name=\"export\" type=\"submit\" class=\"btn btn-warning\" value='Change Password'>
                      </div>
                  </div><br>
                
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='login.php';\" class=\"btn btn-warning\" style='width: 100px;' value='Login Page'>
                  </div>
              </fieldset>
          </form>
      </div>";
?>