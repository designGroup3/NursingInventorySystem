<?php

session_start();
include '../dbh.php';

$oldColumn = $_POST['oldColumn'];
if (strpos($oldColumn, '%20')) {
    $oldColumn = str_replace("%20", " ", $oldColumn);
}
$oldType = $_POST['oldType'];
$newColumn = $_POST['newColumn'];
$newType = $_POST['newType'];
//$source = $_POST['source'];

if($newType == "Letters & Numbers" || $newType == "varchar"){
    $newType = "varchar";
}
else{
    $newType = "tinyint";
}

$currentColumns = array();

$sql = "SHOW COLUMNS FROM inventory"; //checks if new column name already exists
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($currentColumns, $row['Field']);
}

if(in_array($newColumn, $currentColumns) && $newColumn !== $oldColumn){
    header("Location: ../editInventoryColumn.php?error=exists");
    exit();
}
if($newColumn == ""){
    header("Location: ../editInventoryColumn.php?error=empty");
    exit();
}

//if($oldType != $newType && $source == "editPage") {
//    header("Location: ../editInventoryColumnConfirm.php?oldColumn=$oldColumn&oldType=$oldType&newColumn=$newColumn&newType=$newType");
//    exit();
//}
//elseif($oldType != $newType && $source == "confirmPage"){
//    $sql = "UPDATE inventory SET `".$oldColumn. "` = NULL;";
//    $result = mysqli_query($conn, $sql);
//}

elseif($oldType != $newType){
    $sql = "UPDATE inventory SET `".$oldColumn. "` = NULL;";
    $result = mysqli_query($conn, $sql);
}

if($newType == "varchar"){
    $newType = "varchar(100)";
}

$sql = "ALTER TABLE `inventory` CHANGE `".$oldColumn."` `".$newColumn."` ".$newType.";";
$result = mysqli_query($conn, $sql);
header("Location: ../editInventoryColumn.php?success");
exit();
?>