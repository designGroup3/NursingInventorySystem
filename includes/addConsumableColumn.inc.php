<?php
session_start();

include '../dbh.php';

$name = $_POST['name'];
$type = $_POST['type'];

$currentColumns = array();

$sql = "SHOW COLUMNS FROM consumables"; //checks if new column name already exists
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($currentColumns, $row['Field']);
}

if(in_array($name, $currentColumns)){
    header("Location: ../addConsumableColumn.php?error=exists");
    exit();
}
if($name == ""){
    header("Location: ../addConsumableColumn.php?error=empty");
    exit();
}

if($type == "varchar"){
    $sql = "ALTER TABLE consumables ADD `$name` VARCHAR(100);";
}
elseif($type = "tinyint"){
    $sql = "ALTER TABLE consumables ADD `$name` TINYINT(1);";
}

$result = mysqli_query($conn, $sql);

header("Location: ../addConsumableColumn.php?success");

?>