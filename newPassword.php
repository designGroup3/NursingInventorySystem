<?php
include 'header.php';
include 'dbh.php';
include 'inputJS.php';
error_reporting(E_ALL ^ E_NOTICE);

echo "<head><Title>New Password</Title></head><div class=\"parent\">
<button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
<i class='fa fa-question'></i></button></div>";

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$email = $_GET['email'];
$sentKey = $_GET['pwdRecoveryKey'];
$pwdRecoveryKey;
if(strpos($url, 'error=noMatch') !== false){
    echo "<br>&nbsp&nbspYour new password does not match.<br><br>";
}
if(strpos($url, 'success') !== false){
    echo "<br>&nbsp&nbspYour password has been changed successfully, please log in with your new password.<br>";
    exit();
}
$sql = "SELECT pwdRecoveryKey FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if($row = $result->fetch_assoc()) {
    $pwdRecoveryKey = $row['pwdRecoveryKey'];
    if($sentKey !== $pwdRecoveryKey){
        echo "Wrong recovery key sent back. Please contact administrator.";
        exit();
    }
}
echo "<div class=\"container\"><form action ='includes/newPassword.inc.php' method ='POST'
    class=\"well form-horizontal\"id=\"contact_form\"><fieldset><h2 align=\"center\">Change Password</h2><br/>
    <input type='hidden' name='email' value = $email>
    <input type='hidden' name='pwdRecoveryKey' value = $pwdRecoveryKey>
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">New Password:</label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-unlock-alt\"></i></span>
    <input type='password' name='newPassword' class=\"form-control\" required></div></div></div>
    <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Confirm New Password:</label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-lock\"></i></span>
    <input type='password' name='confirmNewPassword' class='form-control' required></div></div></div>
    <br/><div class=\"form-group\" align=\"center\"><label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\"><input name=\"export\" type=\"submit\" class=\"btn btn-warning\" value='Change Password'>
    </div></div></fieldset></form></div>";
?>