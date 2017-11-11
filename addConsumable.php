<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $columnNames = array();

    echo "<head><Title>Add Consumable</Title></head><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspAn item already exists by that name.<br>";
    }
    elseif(strpos($url, 'error=typeMismatch') !== false){
        $subtype= $_GET['subtype'];
        $type= $_GET['type'];
        echo "<br>&nbsp&nbspThe subtype $subtype already relates to the type $type. Subtypes can only have one type.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the item.<br>";
    }

    $sql="SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<div class=\"container\"><form class=\"well form-horizontal\" action ='includes/addConsumable.inc.php'
        method = 'POST'id=\"contact_form\"><fieldset><h1 align=\"center\">Add Consumable</h1><br>";
    for($count = 0; $count< count($columnNames); $count++){
        if($columnNames[$count] != "Last Processing Date" && $columnNames[$count] != "Last Processing Person") { //Last processing date & person should not be editable
            $isSelect = false;
            $columnName = $columnNames[$count];
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if ($rowType['DATA_TYPE'] == "tinyint" || $count == 1) {
                $isSelect = true;
                if($count == 1){
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Subtype:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
                        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th\"></i></span>
                        <input style='height:30px; width:100%;' list='Subtypes' required placeholder='   Subtype' name=";
                }
                else{
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">$columnNames[$count]:</label>
                        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-list\"></i></span>
                        <select class=\"form-control selectpicker\" name=";
                }

            } elseif ($rowType['DATA_TYPE'] == "int") {
                if($count == 3){
                    $inputs = '<div class="form-group"><label class="col-md-4 control-label">Number in Stock:
                    <a style="color:red;" title="This field must be filled">*</a></label><div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-question-sign"></i></span>
                    <input type="number" required placeholder="Number in Stock" min="0" class="form-control" name=';
                }
                elseif($count == 4){
                    $inputs = '<div class="form-group"><label class="col-md-4 control-label">Minimum Stock:
                    <a style="color:red;" title="This field must be filled">*</a></label><div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-question-sign"></i></span>
                    <input type="number" required placeholder="Number in Stock" min="0" class="form-control" name=';
                }
                else{
                    $inputs ="<div class=\"form-group\"><label class=\"col-md-4 control-label\">$columnNames[$count]:
                    </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                    <input type=\"number\" placeholder='$columnNames[$count]' min=\"0\" class=\"form-control\" name=";
                }
            } else {
                if($count == 0){
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\" >Item:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                    <input  placeholder='Item Name' required class='form-control' type='text' name=";
                }
                elseif($count == 2){
                    $inputs = '<div class="form-group"><label class="col-md-4 control-label">Location:
                    <a style="color:red;" title="This field must be filled">*</a></label><div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                    <input type="text" required placeholder="Item\'s Location" class=\'form-control\' name=';
                }
                else{
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">$columnNames[$count]:
                    </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                    <input type=\"text\" placeholder='$columnNames[$count]' class='form-control' name=";
                }
            }
            if (strpos($columnName, ' ')) {
                $columnName = str_replace(" ", "", $columnName);
            }
            if ($isSelect) {
                $inputs .= $columnName . "><datalist id=\"Subtypes\">";
                if ($count == 1) {
                    $sql3 = "SELECT Subtype FROM subtypes WHERE `Table` = 'Consumables'";
                    $result3 = mysqli_query($conn, $sql3);
                    while ($SubtypeRow = mysqli_fetch_array($result3)) {
                        $inputs .= "<option value= '".$SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
                    }
                    $inputs .= "</datalist></div></div></div><div class=\"form-group\">
                        <label class=\"col-md-4 control-label\">Type:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
                        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
                        <input style='height:30px; width:100%;' list='Types' required placeholder='   Type' name='type'>
                        <datalist id=\"Types\">";
                    $sql4 = "SELECT DISTINCT Type FROM subtypes WHERE `Table` = 'Consumables'";
                    $result4 = mysqli_query($conn, $sql4);
                    while ($TypeRow = mysqli_fetch_array($result4)) {
                        $inputs .= "<option value= '" . $TypeRow['Type']."'>".$TypeRow['Type']."</option>";
                    }
                    $inputs .= "</datalist></div></div></div>";
                } else {
                    $inputs .= "<option value =''></option><option value= 0>No</option><option value= 1>Yes</option>
                    </select></div></div></div>";
                }
            } else {
                $inputs .= $columnName . " value='".$row[$columnNames[$count]]."'></div></div></div>";
            }
            echo $inputs;
        }
    }
    echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
          <button type='submit' class='btn btn-warning btn-block'>Add to Inventory</button></div></div></fieldset></form></div>";
}

else{
    header("Location: ./login.php");
}
?>