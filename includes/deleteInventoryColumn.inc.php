<?php
session_start();

include '../dbh.php';

$column = $_POST['column'];

$sql = "ALTER TABLE inventory DROP COLUMN `".$column."`;";
$result = mysqli_query($conn, $sql);

header("Location: ../deleteInventoryColumn.php?success");
exit();
?>