<?php
session_start();

include '../dbh.php';

$column = $_POST['column'];

$sql = "ALTER TABLE inventory DROP COLUMN `".$column."`;";
$result = mysqli_query($conn, $sql);

$columnSql = "SHOW COLUMNS FROM inventory;";
$columnResult = mysqli_query($conn, $columnSql);

if(mysqli_num_rows($columnResult) == 11){
    header("Location: ../inventory.php?deleteSuccess");
}
else{
    header("Location: ../deleteInventoryColumn.php?success");
}
exit();
?>