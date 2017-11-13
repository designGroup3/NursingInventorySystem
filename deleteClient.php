<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $number = $_GET['number'];
    $last = $_GET['last'];
    $first = $_GET['first'];

    echo "<head><Title>Delete Client</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "Are you sure you want to delete ".$first. " ". $last ."? This action cannot be undone.
        <form action ='includes/deleteClient.inc.php' method ='POST'><br>
            <input type='hidden' name='number' value = $number>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='clients.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    header("Location: ./login.php");
}
?>