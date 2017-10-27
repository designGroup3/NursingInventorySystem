<?php
session_start();

include '../dbh.php';

$serialNumber = $_POST['serialNumber'];

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    $sql = "DELETE FROM inventory WHERE `Serial Number` = '$serialNumber';";

    //Reports
    $reportSql = "INSERT INTO reports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Delete Inventory',";

    $sql2 = "SELECT Item, Subtype, `Number in Stock` FROM inventory WHERE `Serial Number` = '". $serialNumber."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();

    $reportSql .= "'" . $row2['Item'] . "'" . ", ";
    $reportSql .= "'" . $row2['Subtype'] . "'" . ", ";
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