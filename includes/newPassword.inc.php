<?php
session_start();
include '../dbh.php';
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$confirmNewPassword = $_POST['confirmNewPassword'];
$currentID = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id = '$currentID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['pwd'];
$hash = password_verify($oldPassword, $hash_pwd);

if($hash == 0) {
    header("Location: ../newPassword.php?error=wrongPassword");
    exit();
}
if(empty($newPassword)){
    header("Location: ../newPassword.php?error=noPassword");
    exit();
}
if($newPassword !== $confirmNewPassword){
    header("Location: ../newPassword.php?error=noMatch");
    exit();
}
else{
    $encrypted_password = password_hash($newPassword, PASSWORD_DEFAULT);
    echo "UPDATE users SET pwd = '$newPassword' WHERE id = '$currentID'";
    $sql = "UPDATE users SET pwd = '$encrypted_password' WHERE id = '$currentID'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../newPassword.php?success");
}
?>