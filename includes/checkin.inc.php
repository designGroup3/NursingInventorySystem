<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    //get update person
    $uid = $_SESSION['id'];
//    $sql = "SELECT uid FROM users WHERE id = " . $uid . ";";
//    $result = mysqli_query($conn, $sql);
//    $row = mysqli_fetch_array($result);
//    $uid = $row['uid'];

    $id = $_GET['Id'];

    $sql = "SELECT Item, `Quantity Borrowed` FROM checkouts WHERE Id = ".$id;
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

    $sql = "DELETE FROM checkouts WHERE Id = ".$id;
    $result = mysqli_query($conn, $sql);

    header("Location: ../checkout.php?checkin");
    exit();
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>