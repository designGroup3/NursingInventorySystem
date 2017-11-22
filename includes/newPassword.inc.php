<?php
session_start();
include '../dbh.php';
$email = $_POST['email'];
$email = str_replace("\\","\\\\","$email");
$email = str_replace("'","\'","$email");
$pwdRecoveryKey = $_POST['pwdRecoveryKey'];
$newPassword = $_POST['newPassword'];
$confirmNewPassword = $_POST['confirmNewPassword'];
if($newPassword !== $confirmNewPassword){
    header("Location: ../newPassword.php?email=".$email."&pwdRecoveryKey=".$pwdRecoveryKey."&error=noMatch");
    exit();
}
$encrypted_password = password_hash($newPassword, PASSWORD_DEFAULT);
$sql = "UPDATE users SET Pwd = '$encrypted_password' WHERE Email ='$email'";
$result = mysqli_query($conn, $sql);
header("Location: ../newPassword.php?success");
?>