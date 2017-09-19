<?php

session_start();
include '../dbh.php';

$oldType = $_POST['oldType'];
if (strpos($oldType, '%20')) {
    $oldType = str_replace("%20", " ", $oldType);
}
$newType = $_POST['newType'];

$currentTypes = array();

$sql = "SELECT DISTINCT Type FROM subtypes"; //checks if new type already exists
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($currentTypes, $row['Type']);
}

if(in_array($newType, $currentTypes)){
    header("Location: ../editType.php?error=exists");
    exit();
}

$sql = "UPDATE `subtypes` SET `Type` = '".$newType."' WHERE `Type` = '".$oldType."';";

echo $oldType ."<br><br>";

echo $sql;

$result = mysqli_query($conn, $sql);
header("Location: ../editType.php?success");
exit();
?>