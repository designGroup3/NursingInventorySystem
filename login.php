<?php

//include 'includes/bootstrap.inc.php';
include 'header.php';

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'error=input') !== false){
    echo "<br> &nbsp Your username or password is incorrect!<br>";
}

if(isset($_SESSION['id'])){
    echo "<br><p class='pCenter'>You are already logged in!</p>";
} else {
    echo "<br><form action='includes/login.inc.php' method='POST'>
        &nbsp&nbsp<input type='text' name='uid' placeholder='Username'><br>
        &nbsp&nbsp<input type='password' name='pwd' placeholder='Password'><br><br>
        &nbsp&nbsp<button type='submit'>Log In</button>
    </form>";
}

?>