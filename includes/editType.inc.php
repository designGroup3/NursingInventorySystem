<?php

session_start();
include '../dbh.php';

$oldType = $_POST['oldType'];
if (strpos($oldType, '%20')) {
    $oldType = str_replace("%20", " ", $oldType);
}
$newType = $_POST['newType'];
$isCheckoutable = $_POST['IsCheckoutable'];
$isConsumable = $_POST['IsConsumable'];

if($isCheckoutable != 1){
    $isCheckoutable = 0;
}

if($isConsumable != 1){
    $isConsumable = 0;
}

$currentTypes = array();

$sql = "SELECT DISTINCT Type FROM subtypes"; //checks if new type already exists
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($currentTypes, $row['Type']);
}

if(in_array($newType, $currentTypes) && $oldType != $newType){
    header("Location: ../editType.php?error=exists");
    exit();
}
elseif($isCheckoutable == 1 && $isConsumable == 1){
    header("Location: ../editType.php?error=both");
    exit();
}

$sql = "UPDATE `subtypes` SET `Type` = '".$newType."', `IsCheckoutable` = '".$isCheckoutable."', `IsConsumable` = '".$isConsumable."' WHERE `Type` = '".$oldType."';";

$result = mysqli_query($conn, $sql);
header("Location: ../editType.php?success");
exit();
?>