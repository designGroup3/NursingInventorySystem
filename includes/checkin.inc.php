<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    //get update person
    $id = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id = ". $id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $uid = $row['uid'];

    $id = $_GET['Id'];

    $sql = "SELECT CURDATE();";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $today = $row['CURDATE()'];

    $sql = "SELECT `Serial Number` FROM inventory WHERE `Inv Id` = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $serialNumber = $row['Serial Number'];
    $serialNumber = str_replace("\\","\\\\","$serialNumber");
    $serialNumber = str_replace("'","\'","$serialNumber");

    $sql = "SELECT Item, `Quantity Borrowed` FROM checkouts WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $item = $row['Item'];
    $Borrowed = $row['Quantity Borrowed'];

    $sql2 = "SELECT `Number in Stock` FROM inventory WHERE `Inv Id` = '".$id."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    $stock = $row2['Number in Stock'];
    $newStock = $stock + $Borrowed;

    $sql = "UPDATE inventory SET `Number in Stock` = ".$newStock.", `Last Processing Date` = '".$today."', `Last Processing Person` = '" . $uid . "' WHERE `Inv Id` = '".$id."';";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE checkouts SET `Return Date` = '".$today."' WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);

    header("Location: ../checkout.php?checkin");
    exit();
}
else{
    header("Location: ./login.php");
}
?>