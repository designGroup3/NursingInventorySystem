<?php
include 'header.php';
$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'error=email') !== false){
    echo "<br>&nbsp&nbspThere is no account with this email address. Please create an account.<br>";
    exit();
}
if(strpos($url, 'sent') !== false){
    echo "<br>&nbsp&nbsp A recovery email has been sent to your email address. Please check your email.<br>";
    exit();
}
echo "<br>&nbsp&nbspIf you have forgotten your password, please type in your email address and we will send you a password reset email.
<form action ='includes/forgotPassword.inc.php' method ='POST'><br>
    &nbsp&nbsp<label>Email:</label> <br>&nbsp&nbsp<input type='email' name='email'><br><br>
    &nbsp&nbsp<button type='submit'>Submit</button>
 </form>";
?>