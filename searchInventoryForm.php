<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Inventory</Title></head><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $columnNames = array();
    $Types = array();

    $sql="SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<br><div class=\"container\">
        <form action ='searchInventoryResults.php' class=\"well form-horizontal\" id=\"contact_form\" method ='POST'>
        <fieldset><h2 align=\"center\">Enter what criteria you would like to see any matching inventory for</h2><br>";
    for($count = 0; $count < 4; $count++){
        $columnName = $columnNames[$count];
        if($count == 2){
            echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Type:</label>
                <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
                <select name='Type' class=\"form-control selectpicker\"><option value=''></option>";
            $sql2 = "SELECT Type FROM subtypes;";
            $result2 = mysqli_query($conn, $sql2);
            while($TypeRow = mysqli_fetch_array($result2)){
                if(!in_array($TypeRow['Type'], $Types)){
                    array_push($Types, $TypeRow['Type']);
                    echo "<option value= '". $TypeRow['Type']."'>".$TypeRow['Type']."</option>";
                }
            }
            echo "</select></div></div></div>";
        }
        elseif($count == 3){
            $sql3 = "SELECT Subtype FROM subtypes";
            $result3 = mysqli_query($conn, $sql3);
            echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Subtype:</label>
                <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th\"></i></span>
                <select name='Subtype' class=\"form-control selectpicker\"><option value=''></option>";
            while($SubtypeRow = mysqli_fetch_array($result3)){
                echo "<option value= '". $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
            }
            echo "</select></div></div></div>";
        }
        else{
            if (strpos($columnName, ' ')) {
                $columnName = str_replace(" ", "", $columnName);
            }

            if($count == 0){
                echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Serial Number:</label>  
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-tag\"></i></span>
                    <input name='SerialNumber' placeholder=\"Serial Number\" class=\"form-control\" 
                    type=\"text\"></div></div></div>";
            }
            elseif($count == 1){
                echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\" >Item:</label> 
                    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                    <input name='Item' placeholder=\"Item Name\" class=\"form-control\"  type=\"text\"></div>
                    </div></div>";
            }
            else {
                echo "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name='".$columnName
                    ."' value='" . $row[$columnNames[$count]] . "'><br><br>";
            }
        }
    }
    //echo "<br><br>";
    for($count = 3; $count< count($columnNames); $count++){
        $isSelect = false;
        $columnName = $columnNames[$count];
        $sql4 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
        $result4 = mysqli_query($conn, $sql4);
        $rowType = mysqli_fetch_array($result4);
        if($rowType['DATA_TYPE'] == "tinyint"){
            $isSelect = true;
            if($count == 5){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Checkoutable:
                </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                <select name='Checkoutable' class=\"form-control selectpicker\"";
            }
            else{
                $inputs = "<div class='form-group'><label class='col-md-4 control-label'>$columnNames[$count]:
                </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                <select class=\"form-control selectpicker\" name=";
                //$inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
            }
        }
        elseif($rowType['DATA_TYPE'] == "date"){
            if($count == 9){
                $inputs = "<div class='form-group'><label class='col-md-4 control-label'>Last Processing Date:
                </label> <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
                <input name='LastProcessingDate' placeholder=\"MM/DD/YY\" class='form-control' type='date'>
                </div></div></div>";
            }
            else{
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='date' name=";
            }
        }
        elseif($rowType['DATA_TYPE'] == "int"){
            if($count == 6){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Number in Stock:
                </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                <input name='NumberinStock' placeholder='Number in Stock' class='form-control' type='number'>
                </div></div></div>";
            }
            else{
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='number' min='0' name=";
            }
        }
        else {
            if($count == 3){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Assigned to:</label>
                <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                <input name='Assignedto' placeholder=\"Assignee's Name\" class=\"form-control\" type=\"text\"></div>
                </div></div>";
            }
            elseif($count == 4){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Location:</label>  
                <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-home\"></i></span>
                <input name='Location' placeholder=\"Item's Location\" class=\"form-control\" type=\"text\"></div>
                </div></div>";
            }
            elseif($count == 7){
                $inputs = '<div class="form-group"><label class="col-md-4 control-label">MAC Address:
                    <p style="color:red; font-size:10px;">to view an example, hover over the field</p></label> 
                    <div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-microchip"></i></span>
                    <input placeholder="MAC Address" title="MAC address should look like 00-15-E9-2B-99-3C"
                    class="form-control" type="text" name="MACAddress" data-fv-mac="true"></div></div></div>';
            }
            elseif($count == 8){
                $inputs = '<div class="form-group"><label class="col-md-4 control-label">IP Address:
                    <p style="color:red; font-size:10px;">to view an example, hover over the field</p></label>   
                    <div class="col-md-4 inputGroupContainer"><div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                    <input placeholder="IP Address" title="IP addresses (IPv4) look like four blocks of digits ranging from 0 to 255 separated by a period like 192.168.0.255" 
                    class="form-control" type="text" name="IPAddress" data-fv-mac="true"></div></div></div>';
            }
            elseif($count == 10){
                $inputs= "<div class='form-group'><label class='col-md-4 control-label'>Last Processing Person: 
                </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class='input-group-addon'><i class='fa fa-user-circle' aria-hidden='true'></i></span>
                <input name='LastProcessingPerson' placeholder='Last Processing Person' class=\"form-control\" 
                type=\"text\"></div></div></div>";
            }
            else{
                $columnName = $columnNames[$count];
                if (strpos($columnName, ' ')) {
                    $columnName = str_replace(" ", "", $columnName);
                }
                $inputs = "<div class='form-group'><label class='col-md-4 control-label'>$columnNames[$count]
                </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                <input name='$columnName' placeholder=\"$columnNames[$count]\" class='form-control' 
                type='text'></div></div></div>";

            }
        }
        if (strpos($columnName, ' ')) {
            $columnName = str_replace(" ", "", $columnName);
        }
        if($isSelect){
            if($count == 5){
                $inputs .=  "><option value=''></option>
                    <option value=1>Yes</option><option value=0>No</option></select></div></div></div>";
            }
            else{
                $inputs .= $columnName . "><option value=''></option>
                    <option value=1>Yes</option><option value=0>No</option></select></div></div></div>";
            }
        }
        echo $inputs;
    }
    echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
          <button type='submit' class='btn btn-warning btn-block'>Search Inventory</button></div></div></fieldset></form></div>";
}
else{
    header("Location: ./login.php");
}
?>