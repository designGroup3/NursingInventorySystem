<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];

$sql = "DELETE FROM users WHERE id = '$id'";

$result = mysqli_query($conn, $sql);

header("Location: ../usersTable.php");
?>