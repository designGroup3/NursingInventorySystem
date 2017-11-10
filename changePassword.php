<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Change Password</Title></head><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    error_reporting(E_ALL ^ E_NOTICE);
    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    if(strpos($url, 'error=wrongPassword') !== false){
        echo "<br>&nbsp&nbspOld password is incorrect.<br>";
    }
    if(strpos($url, 'error=noPassword') !== false){
        echo "<br>&nbsp&nbspNew password cannot be empty.<br>";
    }
    if(strpos($url, 'error=noMatch') !== false){
        echo "<br>&nbsp&nbspYour new password does not match.<br>";
    }
    if(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspYour password has been changed successfully, please log in with your new password.<br>";
    }

    echo "<form action ='includes/changePassword.inc.php' method ='POST'><br>
        &nbsp&nbsp<label>Old Password:</label> <br>&nbsp&nbsp<input type='password' name='oldPassword'><br><br>
        &nbsp&nbsp<label>New Password:</label> <br>&nbsp&nbsp<input type='password' name='newPassword'><br><br>
        &nbsp&nbsp<label>Confirm New Password:</label> <br>&nbsp&nbsp<input type='password' name='confirmNewPassword'><br><br>
        &nbsp&nbsp<button type='submit'>Submit</button>
     </form>";
}
else{
    header("Location: ./login.php");
}
?>