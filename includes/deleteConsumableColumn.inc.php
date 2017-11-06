<?php
session_start();

include '../dbh.php';

$column = $_POST['column'];

$sql = "ALTER TABLE consumables DROP COLUMN `".$column."`;";
$result = mysqli_query($conn, $sql);

$columnSql = "SHOW COLUMNS FROM consumables;";
$columnResult = mysqli_query($conn, $columnSql);

if(mysqli_num_rows($columnResult) == 7){
    header("Location: ../consumables.php");
}
else{
    header("Location: ../deleteConsumableColumn.php?success");
}
exit();
?>