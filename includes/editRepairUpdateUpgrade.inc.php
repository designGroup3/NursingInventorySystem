<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
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

$sql = "UPDATE `repairs/updates/upgrades` SET Type = '$type', `Serial Number` = '$serialNumber', Part = '$part', Cost = '$cost', Date = '$date', Supplier = '$supplier', Reason = '$reason' WHERE Id = '$id';";
$result = mysqli_query($conn, $sql);

header("Location: ../repairsUpdatesUpgrades.php");
?>