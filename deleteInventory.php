<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $serialNumber = $_GET['serialNumber'];
    $item = $_GET['item'];

    echo "<head><Title>Delete Inventory</Title></head>";

    echo "<div class='container'>
        <form action ='includes/deleteInventory.inc.php' class='well form-horizontal' id='contact_form' method ='POST'>
        <h2 align='center'>Are you sure you want to delete ".$item."?</h2>
        <br><div class=\"form-group\" style=\"text-align: center;\"><label class=\"col-md-4 control-label\"></label>
        <div class=\"col-md-4\"><input type='hidden' name='serialNumber' value = $serialNumber>
            <button class=\"btn btn-danger btn-lg\"  type='submit'>Yes</button>
            
        <button onclick=\"history.go(-1);\" name=\"submit\" type=\"submit\" class=\"nobtn btn btn-warning btn-lg\" 
         id=\"contact-submit\" data-submit=\"...Sending\" > No</button></form></div></div></div>";
}
else{
    header("Location: ./login.php");
}
?>