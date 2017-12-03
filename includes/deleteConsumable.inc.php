<?php
session_start();

include '../dbh.php';

$item = $_POST['item'];

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    $sql = "DELETE FROM consumables WHERE Item = '".$item."';";

    //Reports
    $reportSql = "INSERT INTO consumableReports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Delete Consumable',";

    $sql2 = "SELECT Subtype, `Number in Stock` FROM consumables WHERE Item = '". $item."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
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

    //Check subtypes table
    $subSql = "SELECT * FROM consumables WHERE Subtype = '$subtype';";
    $subResult = mysqli_query($conn, $subSql);
    if(mysqli_num_rows($subResult) == 0){
        $subSql = "DELETE FROM subtypes WHERE Subtype = '$subtype';";
        $subResult = mysqli_query($conn, $subSql);
    }

    header("Location: ../consumables.php");
}
else{
    header("Location: ./login.php");
}
?>