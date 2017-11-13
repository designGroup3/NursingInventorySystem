<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Consumables</Title></head><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $columnNames = array();
    $Types = array();

    $sql="SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<br><div class=\"container\">
        <form class='well form-horizontal' action ='searchConsumablesResults.php' method ='POST' id='contact_form'>
        <fieldset><h2 align='center'>Enter what criteria you would like to see any matching consumables for.</h2><br>";
    for($count = 0; $count < 3; $count++){
        $columnName = $columnNames[$count];
        if($count == 1){
            echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Type:</label>
                  <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
                  <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
                  <select name='Type' class=\"form-control selectpicker\"><option value=''></option>";
            $sql2 = "SELECT Type FROM subtypes;";
            $result2 = mysqli_query($conn, $sql2);
            while($TypeRow = mysqli_fetch_array($result2)){
                if(!in_array($TypeRow['Type'], $Types)){
                    array_push($Types, $TypeRow['Type']);
                    $type = str_replace("'","%27","$TypeRow[Type]");
                    echo "<option value= '". $type."'>".$TypeRow['Type']."</option>";
                }
            }
            echo "</select></div></div></div>";
        }
        elseif($count == 2){
            $sql3 = "SELECT Subtype FROM subtypes";
            $result3 = mysqli_query($conn, $sql3);
            echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Subtype:</label>
                  <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
                  <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th\"></i></span>
                  <select name='Subtype' class=\"form-control selectpicker\"><option value=''></option>";
            while($SubtypeRow = mysqli_fetch_array($result3)){
                $subtype = str_replace("'","%27","$SubtypeRow[Subtype]");
                echo "<option value= '". $subtype."'>".$SubtypeRow['Subtype']."</option>";
            }
            echo "</select></div></div></div>";
        }
        else{
            if (strpos($columnName, ' ')) {
                $columnName = str_replace(" ", "", $columnName);
            }

            if($count == 0){
                echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\" >Item:</label> 
                <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
                <input name='Item' placeholder=\"Item Name\" class=\"form-control\"  type=\"text\"></div></div></div>";
            }
        }
    }
    for($count = 2; $count< count($columnNames); $count++){
        $isSelect = false;
        $columnName = $columnNames[$count];
        $sql4 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$count]';";
        $result4 = mysqli_query($conn, $sql4);
        $rowType = mysqli_fetch_array($result4);
        if($rowType['DATA_TYPE'] == "tinyint"){
            $isSelect = true;
            $inputs = "<div class='form-group'><label class='col-md-4 control-label'>$columnNames[$count]:
                        </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                        <select class=\"form-control selectpicker\" name=";
        }
        elseif($rowType['DATA_TYPE'] == "date"){
            if($count == 5){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Last Processing Date:
                </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
                <input name=\"LastProcessingDate\" placeholder=\"MM/DD/YY\" class=\"form-control\" type='date'>
                </div></div></div>";
            }
        }
        elseif($rowType['DATA_TYPE'] == "int"){
            if($count == 3){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Number in Stock:
                        </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                        <input name='NumberinStock' placeholder='Number in Stock' class='form-control' type='number'>
                        </div></div></div>";
            }
            elseif($count == 4){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Minimum Stock:
                        </label><div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-question-sign\"></i></span>
                        <input name='MinimumStock' placeholder='Minimum Stock' class='form-control' type='number'>
                        </div></div></div>";
            }
        }
        else{
            if($count == 2){
                $inputs = "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Location:</label>  
                <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-home\"></i></span>
                <input name='Location' placeholder=\"Item's Location\" class=\"form-control\" type=\"text\"></div>
                </div></div>";
            }
            elseif($count == 6){
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
            $inputs .= $columnName . "><option value=''></option>
                            <option value=1>Yes</option><option value=0>No</option></select><br><br>";
        }
//        else{
//            $inputs .= $columnName . " value=" . $row[$columnNames[$count]] . "><br><br>";
//        }
        echo $inputs;
    }
    echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
    <button name=\"submit\" type=\"submit\" class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
    data-submit=\"...Sending\">Search</button></div></div></fieldset></form></div>";
}
else{
    header("Location: ./login.php");
}
?>