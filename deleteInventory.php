<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $serialNumber = $_GET['serialNumber'];
    $item = $_GET['item'];

    echo "<head><Title>Delete Inventory</Title></head><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div><div class='container'>
        <form action ='includes/deleteInventory.inc.php' class='well form-horizontal' method ='POST'>
        <h2 align='center'>Are you sure you want to delete ".$item."?</h2>
        <br><div class=\"form-group\" style='text-align: center;'><label class=\"col-md-4 control-label\"></label>
        <div class=\"col-md-4\"><input type='hidden' name='serialNumber' value = $serialNumber>
        <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
        <input onclick=\"window.location.href='inventory.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
        </span></form></div></div></div>";
}
else{
    header("Location: ./login.php");
}
?>