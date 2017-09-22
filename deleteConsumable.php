<?php

include 'header.php';

$id = $_GET['id'];
$item = $_GET['item'];

if(isset($_SESSION['id'])) {
    echo "Are you sure you want to delete ".$item."? This action cannot be undone.
        <form action ='includes/deleteConsumable.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='consumables.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>