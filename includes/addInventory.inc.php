<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    error_reporting(E_ALL ^ E_NOTICE);
    $columnNames = array();
    $receivedValues = array();
    $inventoryNames = array();

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

    $sql = "SELECT Item FROM inventory"; //checks if new item already exists
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($inventoryNames, $row['Item']);
    }

    if(in_array($receivedValues[1], $inventoryNames)){
        header("Location: ../addInventory.php?error=exists");
        exit();
    }
    if($receivedValues[1] == ""){
        header("Location: ../addInventory.php?error=empty");
        exit();
    }

    $sql = "INSERT INTO inventory (";

    for ($count = 1; $count < count($columnNames); $count++) {
        if ($count < count($columnNames) - 1) {
            $sql .= "`" . $columnNames[$count] . "`" . ", ";
        } else {
            $sql .= "`" . $columnNames[$count] . "`" . ") ";
        }
    }

    $sql .= "VALUES (";

    for ($count = 1; $count < count($columnNames); $count++) {
        if ($count < count($columnNames) - 1) {
            $sql .= "'" . $receivedValues[$count] . "'" . ", ";
        } else {
            $sql .= "'" . $receivedValues[$count] . "'" . ");";
        }
    }

    $result = mysqli_query($conn, $sql);

    //Reports
    $sql = "INSERT INTO reports (`Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Add Inventory','0',";

    $sql .= "'" . $receivedValues[1] . "'" . ", ";
    $sql .= "'" . $receivedValues[2] . "'" . ", ";
    $sql .= "'" . $receivedValues[7] . "'" . ", ";

    $sql2 = "SELECT CURRENT_TIMESTAMP;";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $time = $row2['CURRENT_TIMESTAMP'];

    $sql .= "'" . $time . "'" . ", ";
    $sql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql);
    header("Location: ../inventory.php");
}
else{
    header("Location: ./login.php");
}
?>