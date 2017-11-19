<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT Uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['Uid'];

    $sql = "DELETE FROM inventory WHERE `Inv Id` = '$id';";

    //Reports
    $reportSql = "INSERT INTO reports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Delete Inventory',";

    $sql2 = "SELECT Item, Subtype, `Number in Stock` FROM inventory WHERE `Inv Id` = '". $id."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();

    $item = $row2['Item'];
    $item = str_replace("\\","\\\\","$item");
    $item = str_replace("'","\'","$item");

    $subtype = $row2['Subtype'];
    $subtype = str_replace("\\","\\\\","$subtype");
    $subtype = str_replace("'","\'","$subtype");

    $reportSql .= "'" . $item . "'" . ", ";
    $reportSql .= "'" . $subtype . "'" . ", ";
    $reportSql .= "'" . $row2['Number in Stock'] . "'" . ", ";

    $sql3 = "SELECT CURRENT_TIMESTAMP;";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = $result3->fetch_assoc();
    $time = $row3['CURRENT_TIMESTAMP'];

    $reportSql .= "'" . $time . "'" . ", ";
    $reportSql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql); //Cannot be executed until needed info. is gotten.

    $result = mysqli_query($conn, $reportSql);

    header("Location: ../inventory.php");
}
else{
    header("Location: ./login.php");
}
?>