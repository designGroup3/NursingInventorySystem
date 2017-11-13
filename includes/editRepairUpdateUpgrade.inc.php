<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
$type = $_POST['type'];
$serialNumber = $_POST['serialNumber'];
$item = $_POST['item'];
$part = $_POST['part'];
$cost = $_POST['cost'];
$date = $_POST['date'];
$supplier = $_POST['supplier'];
$reason = $_POST['reason'];

$sql = "UPDATE `repairs/updates/upgrades` SET Type = '$type', `Serial Number` = '$serialNumber', Item = '$item', Part = '$part', Cost = '$cost', Date = '$date', Supplier = '$supplier', Reason = '$reason' WHERE Id = '$id';";

$result = mysqli_query($conn, $sql);

header("Location: ../repairsUpdatesUpgrades.php");

?>