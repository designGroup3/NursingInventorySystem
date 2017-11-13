<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Edit Inventory Column</Title><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div></script></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspA column already exists by that name.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the column.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspColumn changed successfully.<br>";
    }

    $columnNames = array();

    $sql = "SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo '<div class="container"><form class="well form-horizontal" id="contact_form" method="post"><fieldset>
          <h2 align="center">Which column would you like to edit?</h2><br>
          <div class="form-group"><label class="col-md-4 control-label"></label>
          <div class="col-md-4 selectContainer"><div  class="input-group">
          <span class="input-group-addon"><i class="fa fa-columns"></i></span>
          <select name="column" onchange="this.form.submit()" class="form-control selectpicker"><option selected value=""></option>';

    for($columnsCount = 0; $columnsCount < count($columnNames); $columnsCount++) {
        if($columnsCount > 10){
            echo '<option value = "'.$columnNames[$columnsCount].'">'.$columnNames[$columnsCount].'</option>';
        }
    }
    echo '</select></form></div></div></div>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $oldColumn = $_POST['column'];
        $type = "";

        $sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'inventory' AND
        COLUMN_NAME = '". $oldColumn. "';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $type = $row['DATA_TYPE'];

        if (strpos($oldColumn, ' ')) {
            $oldColumn = str_replace(" ", "%20", $oldColumn);
        }
        echo "<br><form action ='includes/editInventoryColumn.inc.php' method = 'POST'><br>
        <input type='hidden' name='oldColumn' value = $oldColumn>
        <input type='hidden' name='oldType' value = $type>
        <input type='hidden' name='source' value = 'editPage'>";
        if (strpos($oldColumn, '%20')) {
            $oldColumn = str_replace("%20", " ", $oldColumn);
        }

        echo "<br><br><div class=\"form-group\"><label class=\"col-md-4 control-label\">
        Column Name:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-columns\"></i></span>
        <input type='text' class=\"form-control\" required name='newColumn' value='".$oldColumn."'></div></div></div>

        <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Data Type:
        <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-server\"></i></span>
        <select name='newType' id='newType' class=\"form-control selectpicker\">";
        if (strpos($oldColumn, '%20')) {
            $oldColumn = str_replace("%20", " ", $oldColumn);
        }
        if($type == "varchar") {
            echo '<option selected value="Letters & Numbers">Letters & Numbers</option><option value="Yes or No">Yes or No</option>';
        }
        else{
            echo '<option value="Letters & Numbers">Letters & Numbers</option><option selected value="Yes or No">Yes or No</option>';
        }
        echo "</select></div></div></div>
            <div class='form-group'><label class='col-md-4 control-label'></label><div class='col-md-4'>
            <button type='submit' class=\"btn btn-warning btn-block\">Edit Column</button><br><br></div></div></form></fieldset></form>";


        echo "<script>$('document').ready(function() {

    $('#newType').on('change',function(){
        alert(\"Warning: Changing type will delete all column data.\");
    });

});</script>";
    }
}
else{
    header("Location: ./login.php");
}
?>