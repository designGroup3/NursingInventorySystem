<?php
session_start();

include '../dbh.php';

$last = $_POST['last'];
$first = $_POST['first'];
$ext = $_POST['ext'];
$email = $_POST['email'];
$office = $_POST['office'];

$sql = "INSERT INTO clients (Last, First, Ext, Email, Office) 
    VALUES ('$last', '$first', '$ext', '$email', '$office');";

$result = mysqli_query($conn, $sql);

header("Location: ../clients.php");

?>