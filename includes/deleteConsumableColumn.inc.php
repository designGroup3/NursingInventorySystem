<?php
session_start();

include '../dbh.php';

$column = $_POST['column'];

$sql = "ALTER TABLE consumables DROP COLUMN `".$column."`;";
$result = mysqli_query($conn, $sql);

header("Location: ../deleteConsumableColumn.php?success");
exit();

?>