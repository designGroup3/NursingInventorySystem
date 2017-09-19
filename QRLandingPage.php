<?php

include 'header.php';
include 'dbh.php';

$inv_id = $_GET['show'];

$sql = "SELECT Item FROM inventory WHERE inv_id ='".$inv_id."';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$name = $row['Item'];

echo "<br>&nbsp&nbspYou scanned the code for ". $name;

?>