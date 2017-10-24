<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];

if(isset($_SESSION['id'])) {
    $sql = "DELETE FROM serviceAgreements WHERE Id = '$id'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../serviceAgreements.php");
}
else{
    header("Location:../login.php");
}
?>