<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    $item = $_GET['item'];

    //TODO Change item to DB read

    echo "<head><Title>Delete Repair/Update/Upgrade</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "Are you sure you want to delete this ".$item. " ". strtolower($type) ."? This action cannot be undone.
        <form action ='includes/deleteRepairUpdateUpgrade.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            <button type='submit'>Delete</button>
        </form><br>
        <form action='repairsUpdatesUpgrades.php'>
            <input type='submit' value='Cancel' />
         </form>";
}
else{
    header("Location: ./login.php");
}
?>