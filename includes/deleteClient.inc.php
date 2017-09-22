<?php
session_start();

include '../dbh.php';

$number = $_POST['number'];

if(isset($_SESSION['id'])) {
    $sql = "DELETE FROM clients WHERE number = '$number'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../clients.php");
}
else{
    header("Location:../login.php");
}
?>