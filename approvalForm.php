<?php
include './dbh.php';

header("Content-type: image/jpeg");

$id = $_GET['id'];

$sql = "SELECT Approval FROM serviceAgreements WHERE Id = '".$id."';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$image = $row['Approval'];

echo $image;
?>