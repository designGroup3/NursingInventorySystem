<?php
session_start();

include '../dbh.php';

error_reporting(E_ALL ^ E_NOTICE);

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];
    $columnNames = array();
    $receivedValues = array();
    $consumableNames = array();
    $type = $_POST['type'];
    $columnTypes = array();

    $sql = "SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
        if (strpos($row['Field'], ' ')) {
            $columnName = str_replace(" ", "", $row['Field']);
            array_push($receivedValues, $_POST[$columnName]);
        } else {
            array_push($receivedValues, $_POST[$row['Field']]);
        }
    }

    $sql2 = "SELECT CURRENT_TIMESTAMP;"; //gets current time
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $time = $row2['CURRENT_TIMESTAMP'];

    for ($count = 0; $count < count($columnNames); $count++) {
        $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$count]';";
        $result2 = mysqli_query($conn, $sql2);
        $rowType = mysqli_fetch_array($result2);
        array_push($columnTypes, $rowType['DATA_TYPE']);
    }

    $sql = "SELECT Item FROM consumables"; //checks if new consumable already exists
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($consumableNames, $row['Item']);
    }

    if(in_array($receivedValues[0], $consumableNames)){
        header("Location: ../addConsumable.php?error=exists");
        exit();
    }
    if($receivedValues[0] == ""){
        header("Location: ../addConsumable.php?error=empty");
        exit();
    }

    $sql = "INSERT INTO consumables (";

    for ($count = 0; $count < count($columnNames); $count++) {
        if ($count < count($columnNames) - 1) {
            $sql .= "`" . $columnNames[$count] . "`" . ", ";
        } else {
            $sql .= "`" . $columnNames[$count] . "`" . ") ";
        }
    }

    $sql .= "VALUES (";
    for ($count = 0; $count < count($columnNames); $count++) {
        if ($count < 5) {
            $sql .= "'".$receivedValues[$count]."'";
        }
        elseif($count === 5){
            $sql .= "'" . $time."'";
        }
        elseif($count === 6){
            $sql .= "'" . $uid."'";
        }
        else {
            if($columnTypes[$count] !== "tinyint"){
                $sql .= "'" . $receivedValues[$count]."'";
            }
            else{
                if($receivedValues[$count] !== ""){
                    $sql .= $receivedValues[$count];
                }
                else{
                    $sql .= 'NULL';
                }
            }
        }
        if($count != (count($columnNames)-1)){
            $sql .= ", ";
        }
        else{
            $sql .= ");";
        }
    }

    //Check subtypes table
    $sql2 = "SELECT Subtype FROM subtypes WHERE Subtype = '$receivedValues[1]';";
    $result2 = mysqli_query($conn, $sql2);
    if(mysqli_num_rows($result2) !== 0){ //subtype found
        $sql2 = "SELECT Subtype, Type FROM subtypes WHERE Subtype = '$receivedValues[1]' AND Type = '$type';";
        $result2 = mysqli_query($conn, $sql2);
        if(mysqli_num_rows($result2) == 0){ // matching type not found
            $sql2 = "SELECT Type from subtypes WHERE Subtype ='$receivedValues[1]';";
            $result2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_array($result2)) {
                $type = $row2['Type'];
            }
            header("Location: ../addConsumable.php?error=typeMismatch&subtype=$receivedValues[1]&type=$type");
            exit();
        }
        else{
            $sql2 = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $receivedValues[1] . "','" . $type . "','Consumables');";
            $result2 = mysqli_query($conn, $sql2);
            $result = mysqli_query($conn, $sql); //add the item
        }
    }
    else{ //subtype not found
        $sql2 = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $receivedValues[1] . "','" . $type . "','Consumables');";
        $result2 = mysqli_query($conn, $sql2);
        $result = mysqli_query($conn, $sql); //add the item
    }

    //Reports
    $sql = "INSERT INTO reports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Add Consumable',";

    $sql .= "'" . $receivedValues[1] . "'" . ", ";
    $sql .= "'" . $receivedValues[2] . "'" . ", ";
    $sql .= "'" . $receivedValues[4] . "'" . ", ";

    $sql2 = "SELECT CURRENT_TIMESTAMP;";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $time = $row2['CURRENT_TIMESTAMP'];

    $sql .= "'" . $time . "'" . ", ";
    $sql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql);

    header("Location: ../consumables.php");
}
else{
    header("Location: ./login.php");
}
?>