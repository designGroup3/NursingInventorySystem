<?php
session_start();

include '../dbh.php';

$originalItem = $_POST['originalItem'];
$consumableColumns = array();
$consumableValues = array();

if(isset($_SESSION['id'])) {
    error_reporting(E_ALL ^ E_NOTICE);
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    $sql2 = "SELECT CURRENT_TIMESTAMP;"; //gets current time
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $time = $row2['CURRENT_TIMESTAMP'];

    $sql="SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($consumableColumns, $row['Field']);
        if(strpos($row['Field'],' ')){
            $columnName = str_replace(" ","", $row['Field']);
            array_push($consumableValues, $_POST[$columnName]);
        }
        else{
            array_push($consumableValues, $_POST[$row['Field']]);
        }
    }

    $sql = "UPDATE consumables SET ";
    for($count = 0; $count< count($consumableColumns); $count++){
        if($consumableColumns[$count] != "Last Processing Date" && $consumableColumns[$count] != "Last Processing Person") {
            $sql .= "`" . $consumableColumns[$count] . "`" . " = '" . $consumableValues[$count] . "' ";
        }
        if($consumableColumns[$count] == "Last Processing Date"){
            $sql .= "`Last Processing Date` = '" .$time."'";
        }

        if($consumableColumns[$count] == "Last Processing Person"){
            $sql .= "`Last Processing Person` = '" .$uid."'";
        }

        if ($count !== count($consumableColumns) - 1) {
            $sql .= ", ";
        }
    }

    $sql .= " WHERE `Item` = '$originalItem';";

    //Reports
    $reportSql = "INSERT INTO reports (`Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Edit Consumable','1',";

    $reportSql .= "'" . $consumableValues[1] . "'" . ", ";
    $reportSql .= "'" . $consumableValues[2] . "'" . ", ";

    //Get old quantity
    $sql2 = "SELECT `Number in Stock` FROM consumables WHERE `Item` = '".$consumableValues[0]."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $current_quantity = $row2['Number in Stock'];

    $quantity = $consumableValues[4] - $current_quantity;
    $reportSql .= $quantity .", ";

    $sql3 = "SELECT CURRENT_TIMESTAMP;";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = $result3->fetch_assoc();
    $time = $row3['CURRENT_TIMESTAMP'];

    $reportSql .= "'" . $time . "'" . ", ";
    $reportSql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql);

    $result = mysqli_query($conn, $reportSql);

    header("Location: ../consumables.php");
}
else{
    header("Location: ./login.php");
}
?>