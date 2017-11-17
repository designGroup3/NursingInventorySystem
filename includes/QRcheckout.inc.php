<?php
session_start();

include '../dbh.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['Id'];

    $sql = "SELECT `Serial Number`, Item, subtypes.Type, inventory.Subtype FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype WHERE `Id` = '" . $id."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    header("Location: ../checkout.php?type=".$row['Type']."&subtype=".$row['Subtype']."&item=".$row['Item']."&serial=".$row['Serial Number']);
}
else{
    header("Location: ./login.php");
}
?>