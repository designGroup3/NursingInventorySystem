<?php
session_start();

include '../dbh.php';

error_reporting(E_ALL ^ E_NOTICE);
$columnNames = array();
$receivedValues = array();

$sql="SHOW COLUMNS FROM consumables";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($columnNames, $row['Field']);
    if(strpos($row['Field'],' ')){
        $columnName = str_replace(" ","", $row['Field']);
        array_push($receivedValues, $_POST[$columnName]);
    }
    else{
        array_push($receivedValues, $_POST[$row['Field']]);
    }
}

$sql = "INSERT INTO consumables (";

for($count = 1; $count< count($columnNames); $count++){
    if($count < count($columnNames) -1){
        $sql .= "`" . $columnNames[$count] . "`" . ", ";
    }
    else{
        $sql .= "`" . $columnNames[$count] . "`" . ") ";
    }
}

$sql .= "VALUES (";

for($count = 1; $count< count($columnNames); $count++){
    if($count < count($columnNames) -1){
        $sql .= "'" . $receivedValues[$count] . "'" . ", ";
    }
    else{
        $sql .= "'" . $receivedValues[$count] . "'" . ");";
    }
}

$result = mysqli_query($conn, $sql);

header("Location: ../consumables.php");

?>