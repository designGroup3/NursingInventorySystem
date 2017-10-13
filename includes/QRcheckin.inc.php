<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    //get update person
    $uid = $_SESSION['id'];

    $id = $_GET['id'];

    $sql = "SELECT Item, `Quantity Borrowed` FROM checkouts WHERE Id = ".$id;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $item = $row['Item'];
    $Borrowed = $row['Quantity Borrowed'];
    $newBorrowed = $Borrowed - 1;

    $sql = "SELECT `Number in Stock` FROM inventory WHERE Item = '" . $item . "';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $stock = $row['Number in Stock'];
    $newStock = $stock + 1;

    $sql = "UPDATE inventory SET `Number in Stock` = ".$newStock.", `Last Processing Date` = '" . date('Y/m/d') . "', `Last Processing Person` = '" . $uid . "' WHERE `Item` = '" . $item . "';";
    $result = mysqli_query($conn, $sql);

    if($newBorrowed != 0){
        $sql = "UPDATE checkouts SET `Quantity Borrowed` = ".$newBorrowed." WHERE Id = ".$id;
        $result = mysqli_query($conn, $sql);
    }
   else{
       $sql = "DELETE FROM checkouts WHERE Id = ".$id;
       $result = mysqli_query($conn, $sql);
   }

    header("Location: ../checkout.php?checkin");
    exit();
}
else{
    header("Location: ./login.php");
}
?>