<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    $serialNumber = $_GET['serialNumber'];

    $sql = "SELECT Item, subtypes.Type, inventory.Subtype FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype WHERE `Serial Number` = '" . $serialNumber."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    header("Location: ../checkout.php?type=" . $row['Type'] . "&subtype=" . $row['Subtype'] . "&item=" . $row['Item']);
}
else{
    header("Location: ./login.php");
}
?>