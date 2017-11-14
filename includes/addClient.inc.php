<?php
session_start();

include '../dbh.php';

$last = $_POST['last'];
$last = str_replace("\\","\\\\","$last");
$last = str_replace("'","\'","$last");
$first = $_POST['first'];
$first = str_replace("\\","\\\\","$first");
$first = str_replace("'","\'","$first");
$ext = $_POST['ext'];
$email = $_POST['email'];
$email = str_replace("\\","\\\\","$email");
$email = str_replace("'","\'","$email");
$office = $_POST['office'];
$office = str_replace("\\","\\\\","$office");
$office = str_replace("'","\'","$office");

$sql = "INSERT INTO clients (Last, First, Ext, Email, Office) 
    VALUES ('$last', '$first', '$ext', '$email', '$office');";

$result = mysqli_query($conn, $sql);

header("Location: ../clients.php");

?>