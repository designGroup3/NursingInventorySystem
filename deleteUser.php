<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];
    $uid = $_GET['uid'];

    echo "<head><Title>Delete User</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "Are you sure you want to delete ".$uid."? This action cannot be undone.
        <form action ='includes/deleteUser.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='usersTable.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    header("Location: ./login.php");
}
?>