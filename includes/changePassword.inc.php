<?php
session_start();
include '../dbh.php';
$oldPassword = $_POST['oldPassword'];
$oldPassword = str_replace("\\","\\\\","$oldPassword");
$oldPassword = str_replace("'","\'","$oldPassword");
$newPassword = $_POST['newPassword'];
$newPassword = str_replace("\\","\\\\","$newPassword");
$newPassword = str_replace("'","\'","$newPassword");
$confirmNewPassword = $_POST['confirmNewPassword'];
$confirmNewPassword = str_replace("\\","\\\\","$confirmNewPassword");
$confirmNewPassword = str_replace("'","\'","$confirmNewPassword");
$currentID = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id = '$currentID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['pwd'];
$hash = password_verify($oldPassword, $hash_pwd);

if($hash == 0) {
    header("Location: ../changePassword.php?error=wrongPassword");
    exit();
}
if(empty($newPassword)){
    header("Location: ../changePassword.php?error=noPassword");
    exit();
}
if($newPassword !== $confirmNewPassword){
    header("Location: ../changePassword.php?error=noMatch");
    exit();
}
else{
    $encrypted_password = password_hash($newPassword, PASSWORD_DEFAULT);
    //echo "UPDATE users SET pwd = '$newPassword' WHERE id = '$currentID'";
    $sql = "UPDATE users SET pwd = '$encrypted_password' WHERE id = '$currentID'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../changePassword.php?success");
}
?>