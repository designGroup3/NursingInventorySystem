<?php
session_start();

include '../dbh.php';

$column = $_POST['column'];

$sql = "ALTER TABLE inventory DROP COLUMN `".$column."`;";
$result = mysqli_query($conn, $sql);

$columnSql = "SHOW COLUMNS FROM inventory;";
$columnResult = mysqli_query($conn, $columnSql);

if(mysqli_num_rows($columnResult) == 9){
    header("Location: ../inventory.php");
}
else{
    header("Location: ../deleteInventoryColumn.php?success");
}
exit();
?>