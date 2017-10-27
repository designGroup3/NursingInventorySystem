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

    $serialNumber = $_GET['serialNumber'];

    $sql = "SELECT Item, `Quantity Borrowed` FROM checkouts WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $item = $row['Item'];
    $Borrowed = $row['Quantity Borrowed'];

    $sql2 = "SELECT `Number in Stock` FROM inventory WHERE `Serial Number` = '".$serialNumber."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);

    $stock = $row2['Number in Stock'];
    $newStock = $stock + $Borrowed;

    $sql = "UPDATE inventory SET `Number in Stock` = ".$newStock.", `Last Processing Date` = '" . date('Y/m/d') . "', `Last Processing Person` = '" . $uid . "' WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE checkouts SET `Return Date` = '".date('Y/m/d')."' WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);

    header("Location: ../checkout.php?checkin");
    exit();
}
else{
    header("Location: ./login.php");
}
?>