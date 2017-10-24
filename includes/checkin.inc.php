<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    //get update person
    $uid = $_SESSION['id'];

    $serialNumber = $_GET['serialNumber'];

    $sql = "SELECT Item, `Quantity Borrowed` FROM checkouts WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $item = $row['Item'];
    $Borrowed = $row['Quantity Borrowed'];

    $sql = "SELECT `Number in Stock` FROM inventory WHERE Item = '" . $item . "';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $stock = $row['Number in Stock'];
    $newStock = $stock + $Borrowed;

    $sql = "UPDATE inventory SET `Number in Stock` = ".$newStock.", `Last Processing Date` = '" . date('Y/m/d') . "', `Last Processing Person` = '" . $uid . "' WHERE `Item` = '" . $item . "';";
    $result = mysqli_query($conn, $sql);

    $sql = "DELETE FROM checkouts WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);

    header("Location: ../checkout.php?checkin");
    exit();
}
else{
    header("Location: ./login.php");
}
?>