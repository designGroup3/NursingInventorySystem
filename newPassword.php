<?php
include 'header.php';
include 'dbh.php';
error_reporting(E_ALL ^ E_NOTICE);
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
echo "Please type your new password below, and then again to confirm
<form action ='includes/newPassword.inc.php' method ='POST'><br>
    <input type='hidden' name='email' value = $email>
    <input type='hidden' name='pwdRecoveryKey' value = $pwdRecoveryKey>
    &nbsp&nbsp<label>New Password:</label> <br>&nbsp&nbsp<input type='password' name='newPassword'><br><br>
    &nbsp&nbsp<label>Confirm New Password:</label> <br>&nbsp&nbsp<input type='password' name='confirmNewPassword'><br><br>
    &nbsp&nbsp<button type='submit'>Submit</button>
 </form>";
?>