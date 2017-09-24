<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];

if(isset($_SESSION['id'])) {
    if($_SESSION['id'] == $id){
        header("Location: ../usersTable.php?error=self");
        exit();
    }
    else{
        $sql = "DELETE FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        header("Location: ../usersTable.php");
    }
}
else{
    header("Location:../login.php");
}
?>