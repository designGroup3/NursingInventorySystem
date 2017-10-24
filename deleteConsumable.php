<?php

include 'header.php';

$item = $_GET['item'];

if(isset($_SESSION['id'])) {
    echo "Are you sure you want to delete ".$item."? This action cannot be undone.
        <form action ='includes/deleteConsumable.inc.php' method ='POST'><br>
            <input type='hidden' name='item' value = '$item'>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='consumables.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    header("Location: ./login.php");
}
?>