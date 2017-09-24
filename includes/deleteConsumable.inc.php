<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];

$sql = "DELETE FROM consumables WHERE id = '$id'";

$result = mysqli_query($conn, $sql);

header("Location: ../consumables.php");

?>