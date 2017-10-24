<?php
session_start();

include '../dbh.php';

$number = $_POST['number'];
$last = $_POST['last'];
$first = $_POST['first'];
$ext = $_POST['ext'];
$email = $_POST['email'];
$office = $_POST['office'];

$sql = "UPDATE clients SET Last = '$last', First = '$first', Ext = '$ext', Email = '$email', Office = '$office' WHERE Number = '$number'";

$result = mysqli_query($conn, $sql);

header("Location: ../clients.php");

?>