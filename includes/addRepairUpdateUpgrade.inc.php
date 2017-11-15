<?php
session_start();

include '../dbh.php';

$type = $_POST['type'];
$type = str_replace("\\","\\\\","$type");
$type = str_replace("'","\'","$type");
$serialNumber = $_POST['serialNumber'];
$serialNumber = str_replace("\\","\\\\","$serialNumber");
$serialNumber = str_replace("'","\'","$serialNumber");
$part = $_POST['part'];
$part = str_replace("\\","\\\\","$part");
$part = str_replace("'","\'","$part");
$cost = $_POST['cost'];
$date = $_POST['date'];
$supplier = $_POST['supplier'];
$supplier = str_replace("\\","\\\\","$supplier");
$supplier = str_replace("'","\'","$supplier");
$reason = $_POST['reason'];
$reason = str_replace("\\","\\\\","$reason");
$reason = str_replace("'","\'","$reason");

$sql = "INSERT INTO `repairs/updates/upgrades` (Type, `Serial Number`, Part, Cost, Date, Supplier, Reason) 
    VALUES ('$type', '$serialNumber', '$part', '$cost', '$date', '$supplier', '$reason');";

echo $sql;

$result = mysqli_query($conn, $sql);

header("Location: ../repairsUpdatesUpgrades.php");

?>