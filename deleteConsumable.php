<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $item = $_GET['item'];

    echo "<head><Title>Delete Consumable</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $item = str_replace("\\","\\\\","$item");
    $item = str_replace("'","\'","$item");
    $checkSql = "SELECT * FROM consumables WHERE `Item` = '$item';";
    $checkResult = mysqli_query($conn, $checkSql);
    if(mysqli_num_rows($checkResult) == 0){
        echo "<br>
        <h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
        <div style='text-align: center'>
            <input onclick=\"window.location.href='consumables.php';\" class='btn btn-warning' value='Back'>
        </div>";
        exit();
    }

    $itemName = str_replace("\\\\","\\","$item");
    $itemName = str_replace("\'","'","$itemName");
    $item = str_replace("\"","&quot;","$item");

    echo "<div class=\"container\"><form action ='includes/deleteConsumable.inc.php' class=\"well form-horizontal\" method ='POST' id=\"contact_form\">
          <fieldset><h3 align=\"center\">Are you sure you want to delete ".$itemName."?</h3>
          <p align=\"center\" style=\"color:red;\">*This action cannot be undone.</p>
          <div class=\"form-group\" style='text-align: center;'><label class=\"col-md-4 control-label\"></label>
          <div class=\"col-md-4\"><input type='hidden' name='item' value = \"$item\">
          <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
          <input onclick=\"window.location.href='consumables.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
          </span></form></div></div></div>";
}
else{
    header("Location: ./login.php");
}
?>