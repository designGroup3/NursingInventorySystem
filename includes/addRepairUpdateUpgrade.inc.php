<?php
session_start();

include '../dbh.php';

$type = $_POST['type'];
$serialNumber = $_POST['serialNumber'];
$part = $_POST['part'];
$cost = $_POST['cost'];
$date = $_POST['date'];
$supplier = $_POST['supplier'];
$reason = $_POST['reason'];

$sql = "INSERT INTO `repairs/updates/upgrades` (Type, `Serial Number`, Part, Cost, Date, Supplier, Reason) 
    VALUES ('$type', '$serialNumber', '$part', '$cost', '$date', '$supplier', '$reason');";

$result = mysqli_query($conn, $sql);

header("Location: ../repairsUpdatesUpgrades.php");

?>