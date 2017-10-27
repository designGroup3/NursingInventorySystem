<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];

    echo "<head><Title>Delete Service Agreement</Title></head>";

    echo "Are you sure you want to delete ".$name."? This action cannot be undone.
        <form action ='includes/deleteServiceAgreement.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='serviceAgreements.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    header("Location: ./login.php");
}
?>