<?php

session_start();
include '../dbh.php';

$subtype = $_POST['subtype'];
$type = $_POST['type'];

$currentTypes = array();

$sql = "SELECT Subtype FROM subtypes WHERE Subtype = '".$subtype."'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($currentTypes, $row['Subtype']);
}

if(in_array($subtype, $currentTypes)){
    header("Location: ../addSubtype.php?error=exists");
    exit();
}
else{
    $sql = "INSERT INTO `subtypes` (`Subtype`, `Type`) VALUES ('".$subtype."', '".$type."');";
    $result = mysqli_query($conn, $sql);
    header("Location: ../addSubtype.php?success");
    exit();
}

?>