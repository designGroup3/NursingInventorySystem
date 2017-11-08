<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $serialNumber = $_GET['edit'];
    $columnNames = array();
    $type;
    echo "<head><Title>Edit Inventory</Title><script src=\"./js/jquery.min.js\"></script></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspAn item with that serial number already exists.<br>";
    }
    elseif(strpos($url, 'error=typeMismatch') !== false){
        $subtype= $_GET['subtype'];
        $type= $_GET['type'];
        echo "<br>&nbsp&nbspThe subtype $subtype already relates to the type $type. Subtypes can only have one type.<br>";
    }

    $sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
    $result = mysqli_query($conn, $sql);
    $innerCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($innerCount < 2) {
            $innerCount++;
            array_push($columnNames, $row['Field']);
        }
    }
    $sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
    $result = mysqli_query($conn, $sql);
    $innerCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        $innerCount++;
        if ($innerCount > 2) {
            array_push($columnNames, $row['Field']);
        }
    }

    echo "<div class=\"container\"><form class=\"well form-horizontal\" action ='includes/editInventory.inc.php'
        id=\"contact_form\" method ='POST'><fieldset><h2 align=\"center\">Edit Inventory Item</h2><br/>";

    $sql="SELECT * FROM inventory WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    for($count = 0; $count < (count($columnNames)); $count++){
        if($columnNames[$count] != "Last Processing Date" && $columnNames[$count] != "Last Processing Person"){ //Last processing date & person should not be editable
            $isSelect = false;
            $columnName = $columnNames[$count];
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if($rowType['DATA_TYPE'] == "tinyint"){
                $isSelect = true;
                if($count == 5){
                    $inputs = '<div class="form-group"><label class="col-md-4 control-label">Checkoutable?</label>
                    <div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
                    <select class="form-control selectpicker" name=';
                }
                else{
                    $inputs = "<div class='form-group'><label class='col-md-4 control-label'>$columnNames[$count]:</label>
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-list\"></i></span>
                    <select class=\"form-control selectpicker\" name=";
                }
                //$inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
            } elseif ($rowType['DATA_TYPE'] == "int") {
                if($count == 6){
                    $inputs = '<div class="form-group"><label class="col-md-4 control-label">Number in Stock:
                    </label><div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-question-sign"></i></span>
                    <input type="number" placeholder="Number in Stock" min="0" class="form-control" name=';
                }
                //$inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='number' min='0' name=";
            }
            else {
                if($count == 0){
                    $inputs = "<div class='form-group'><label class='col-md-4 control-label'>Serial Number</label>  
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-tag\"></i></span>
                    <input class='form-control' type='text' name=";
                }
                elseif($count == 1){
                    $inputs ="<div class=\"form-group\"><label class=\"col-md-4 control-label\" >Item:</label> 
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                    <input type='text' placeholder=\"Item Name\" class=\"form-control\" name=";
                }
                elseif($count == 2){
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Subtype:</label>  
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th\"></i></span>
                    <input type='text' placeholder='Subtype' class=\"form-control\" name=";
                }
                elseif($count == 3){
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Assigned to:
                    </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                    <input type='text' placeholder=\"Assignee's Name\" class='form-control' name=";
                }
                elseif($count == 4){
                    $inputs = '<div class="form-group"><label class="col-md-4 control-label">Location:
                    </label><div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                    <input type="text" placeholder="Item\'s Location" class=\'form-control\' name=';
                }
                else{
                    $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">$columnNames[$count]:
                    </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                    <input type=\"text\" placeholder='$columnNames[$count]' class='form-control' name=";
                }
                //$inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
            }
            if (strpos($columnName, ' ')) { //changes column name for includes file
                $columnName = str_replace(" ", "", $columnName);
            }
            if($isSelect){
                $inputs .= $columnName . ">";
//                if($count == 2){
//                    $sqlSubtype = "SELECT Subtype FROM inventory WHERE `Serial Number` = '". $serialNumber."';";
//                    $resultSubtype = mysqli_query($conn, $sqlSubtype);
//                    $subRow = mysqli_fetch_array($resultSubtype);
//                    $Subtype = $subRow['Subtype'];
//
//                    $sql3 = "SELECT Subtype FROM subtypes";
//                    $result3 = mysqli_query($conn, $sql3);
//                    while($SubtypeRow = mysqli_fetch_array($result3)){
//                        if($Subtype === $SubtypeRow['Subtype']){
//                            $inputs .= "<option selected=\"selected\" value= '". $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
//                        }
//                        else{
//                            $inputs .= "<option value= '". $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
//                        }
//                    }
//                    $inputs .= "</select><br><br>";
//                }
//                else{
                    if($row[$columnNames[$count]] == 0 && $row[$columnNames[$count]] !== null){
                        $inputs .= "<option value=0>No</option><option value=1>Yes</option></select></div></div></div>";
                    }
                    elseif($row[$columnNames[$count]] !== null){
                        $inputs .= "<option value=1>Yes</option><option value=0>No</option></select></div></div></div>";
                    }
                    else{
                        $inputs .= "<option value=''></option><option value=1>Yes</option><option value=0>No</option>
                        </select></div></div></div>";
                    }
                //}
            }
            else{
                $inputs .= $columnName . " value=\"" . $row[$columnNames[$count]] . "\"></div></div></div>";
            }
            if($count == 2){
                $sql3 = "SELECT Type FROM subtypes WHERE Subtype = '$row[Subtype]';";
                $result3 = mysqli_query($conn, $sql3);
                $row3 = mysqli_fetch_array($result3);
                $type = $row3['Type'];

                $inputs.= "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Type:</label>  
                <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
               <input name='type' id='type' placeholder='Type' class='form-control' type='text' value='$type'></div></div></div>";

                //$inputs.= "&nbsp&nbsp<label>Type (Warning: Changing type will change the type for every item with this subtype)</label><br>&nbsp&nbsp<input type='text' name='type' id='type' value='$type'><br><br>";
            }
            echo $inputs;
        }
    }
    echo '<input type="hidden" name="originalSerialNumber" value = \''.$row['Serial Number']. '\'>
          <input type="hidden" name="originalSubtype" value = \''.$row['Subtype']. '\'>
          <input type="hidden" name="originalType" value = \''.$type. '\'>
          <div class="form-group"><label class="col-md-4 control-label"></label><div class="col-md-4">
          <button name="submit" type="submit" class="btn btn-warning btn-block" id="contact-submit" 
          data-submit="...Sending">Submit</button></div></div>';

    $retrievedData = $row['Serial Number'];

    echo '<br><img style="display:block; margin:auto;" src=QRCode.php?text='.$retrievedData.' width="135" height="125" 
        title="QR Code" alt="QR Code"></fieldset></form></div>';

    echo "<script>$('document').ready(function() {
   
    $('#type').on('change',function(){
        alert(\"Warning: Changing type will change the type for every item with this subtype.\");
    });
    
});</script>";

}
else{
    header("Location: ./login.php");
}
?>