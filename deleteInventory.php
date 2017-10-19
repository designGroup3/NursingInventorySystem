<?php

include 'header.php';

$serialNumber = $_GET['serialNumber'];
$item = $_GET['item'];

if(isset($_SESSION['id'])) {
    echo "Are you sure you want to delete ".$item."? This action cannot be undone.
        <form action ='includes/deleteInventory.inc.php' method ='POST'><br>
            <input type='hidden' name='serialNumber' value = $serialNumber>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='inventory.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    header("Location: ./login.php");
}
?>