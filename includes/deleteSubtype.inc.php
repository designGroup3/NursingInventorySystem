<?php

session_start();
include '../dbh.php';

$subtype = $_POST['subtype'];

$usedSubtypes = array();

$sql = "SELECT Subtype FROM inventory;";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($usedSubtypes, $row['Subtype']);
}
if($subtype === ""){
    header("Location: ../deleteSubtype.php?error=empty");
    exit();
}

if(in_array($subtype, $usedSubtypes)){
    header("Location: ../deleteSubtype.php?error=exists");
    exit();
}

$sql = "DELETE FROM `subtypes` WHERE `Subtype` = '".$subtype."';";
echo $sql;
$result = mysqli_query($conn, $sql);
header("Location: ../deleteSubtype.php?success");
exit();
?>