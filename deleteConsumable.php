<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $item = $_GET['item'];

    echo "<head><Title>Delete Consumable</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

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