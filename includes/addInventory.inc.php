<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    $type = $_POST['type'];
    $type = str_replace("\\","\\\\","$type");
    $type = str_replace("'","\'","$type");

    error_reporting(E_ALL ^ E_NOTICE);
    $columnNames = array();
    $receivedValues = array();
    $serialNumbers = array();
    $columnTypes = array();

    $sql = "SHOW COLUMNS FROM inventory";
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
                WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
        $result2 = mysqli_query($conn, $sql2);
        $rowType = mysqli_fetch_array($result2);
        array_push($columnTypes, $rowType['DATA_TYPE']);
    }

    $sql = "SELECT `Serial Number` FROM inventory"; //checks if new item already exists
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($serialNumbers, $row['Serial Number']);
    }

    if(in_array($receivedValues[0], $serialNumbers)){
        header("Location: ../addInventory.php?error=exists");
        exit();
    }
    if($receivedValues[1] == ""){
        header("Location: ../addInventory.php?error=empty");
        exit();
    }

    $sql = "INSERT INTO inventory (";

    for ($count = 0; $count < count($columnNames); $count++) {
        if ($count < count($columnNames) - 1) {
            $sql .= "`" . $columnNames[$count] . "`" . ", ";
        } else {
            $sql .= "`" . $columnNames[$count] . "`" . ") ";
        }
    }

    $sql .= "VALUES (";

    for ($count = 0; $count < count($columnNames); $count++) {
        if ($count < 9) {
            $receivedValues[$count] = str_replace("\\","\\\\","$receivedValues[$count]");
            $receivedValues[$count] = str_replace("'","\'","$receivedValues[$count]");
            $sql .= "'".$receivedValues[$count]."'";
        }
        elseif($count === 9){
            $sql .= "'" . $time."'";
        }
        elseif($count === 10){
            $sql .= "'" . $uid."'";
        }
        else {
            if($columnTypes[$count] !== "tinyint"){
                $receivedValues[$count] = str_replace("\\","\\\\","$receivedValues[$count]");
                $receivedValues[$count] = str_replace("'","\'","$receivedValues[$count]");
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
    $sql2 = "SELECT Subtype FROM subtypes WHERE Subtype = '$receivedValues[2]';";
    $result2 = mysqli_query($conn, $sql2);
    if(mysqli_num_rows($result2) !== 0){ //subtype found
        $sql2 = "SELECT Subtype, Type FROM subtypes WHERE Subtype = '$receivedValues[2]' AND Type = '$type';";
        $result2 = mysqli_query($conn, $sql2);
        if(mysqli_num_rows($result2) == 0){ // matching type not found
            $sql2 = "SELECT Type from subtypes WHERE Subtype ='$receivedValues[2]';";
            $result2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_array($result2)) {
                $type = $row2['Type'];
            }
            header("Location: ../addInventory.php?error=typeMismatch&subtype=$receivedValues[2]&type=$type");
            exit();
        }
        else{
            $sql2 = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $receivedValues[2] . "','" . $type . "','Inventory');";
            $result2 = mysqli_query($conn, $sql2);
            $result = mysqli_query($conn, $sql); //add the item
        }
    }
    else{ //subtype not found
        $sql2 = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $receivedValues[2] . "','" . $type . "','Inventory');";
        $result2 = mysqli_query($conn, $sql2);
        $result = mysqli_query($conn, $sql); //add the item
    }

    //Reports
    $sql = "INSERT INTO reports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Add Inventory',";

    $sql .= "'" . $receivedValues[1] . "'" . ", ";
    $sql .= "'" . $receivedValues[2] . "'" . ", ";
    $sql .= "'" . $receivedValues[6] . "'" . ", ";

    $sql .= "'" . $time . "'" . ", ";
    $sql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql);
    header("Location: ../inventory.php");
    exit();
}
else{
    header("Location: ./login.php");
}
?>