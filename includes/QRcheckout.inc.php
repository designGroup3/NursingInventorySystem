<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT Item, subtypes.Type, inventory.Subtype FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype WHERE inv_id = " . $id;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    header("Location: ../checkout.php?type=" . $row['Type'] . "&subtype=" . $row['Subtype'] . "&item=" . $row['Item']);
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>