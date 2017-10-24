<?php
include 'header.php';
include 'dbh.php';

$columnNames = array();
$Types = array();

if(isset($_SESSION['id'])) {
    $sql="SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<br>&nbsp&nbspEnter what criteria you would like to see any matching items for.
        <form action ='searchConsumablesResults.php' method ='POST'><br>";
    for($count = 0; $count < 3; $count++){
        $columnName = $columnNames[$count];
        if($count == 1){
            echo "&nbsp&nbsp<label>Type</label> <br>&nbsp&nbsp<select name='Type'><option value=''></option>";
            $sql2 = "SELECT Type FROM subtypes;";
            $result2 = mysqli_query($conn, $sql2);
            while($TypeRow = mysqli_fetch_array($result2)){
                if(!in_array($TypeRow['Type'], $Types)){
                    array_push($Types, $TypeRow['Type']);
                    echo "<option value= '". $TypeRow['Type']."'>".$TypeRow['Type']."</option>";
                }
            }
            echo "</select><br><br>";
//        }
//        elseif($count == 2){
            $sql3 = "SELECT Subtype FROM subtypes";
            $result3 = mysqli_query($conn, $sql3);
            echo "&nbsp&nbsp<label>Subtype</label> <br>&nbsp&nbsp<select name='Subtype'><option value=''></option>";
            while($SubtypeRow = mysqli_fetch_array($result3)){
                echo "<option value= '". $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
            }
            echo "</select><br><br>";
        }
        else{
            echo "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=".$columnName
                . " value=" . $row[$columnNames[$count]] . "><br><br>";
        }
    }
    for($count = 3; $count< count($columnNames); $count++){
        $isSelect = false;
        $columnName = $columnNames[$count];
        $sql4 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$count]';";
        $result4 = mysqli_query($conn, $sql4);
        $rowType = mysqli_fetch_array($result4);
        if($rowType['DATA_TYPE'] == "tinyint"){
            $isSelect = true;
            $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
        }
        elseif($rowType['DATA_TYPE'] == "date"){
            $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='date' name=";
        }
        elseif($rowType['DATA_TYPE'] == "int"){
            $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='number' name=";
        }
        else {
            $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
        }
        if (strpos($columnName, ' ')) {
            $columnName = str_replace(" ", "", $columnName);
        }
        if($isSelect){
            $inputs .= $columnName . "><option value=''></option>
                            <option value=1>Yes</option><option value=0>No</option></select><br><br>";
        }
        else{
            $inputs .= $columnName . " value=" . $row[$columnNames[$count]] . "><br><br>";
        }
        echo $inputs;
    }
    echo "&nbsp&nbsp<button type='submit'>Submit</button></form>";
}
else{
    header("Location: ./login.php");
}
?>