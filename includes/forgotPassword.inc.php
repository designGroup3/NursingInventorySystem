<?php
session_start();
include '../dbh.php';
$email = mysqli_real_escape_string($conn, $_POST['email']);
$email = str_replace("\\","\\\\","$email");
$email = str_replace("'","\'","$email");
$sql = "SELECT Email FROM users WHERE Email='$email'";
$result = mysqli_query($conn, $sql);
$emailcheck = mysqli_num_rows($result);
if($emailcheck == 0){
    header("Location: ../forgotPassword.php?error=email");
    exit();
}
else{
    $sql = "SELECT `Pwd Recovery Key` FROM users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);
    if($row = $result->fetch_assoc()){
        $pwdRecoveryKey = $row['Pwd Recovery Key'];
        $URL = 'http://' . $_SERVER['HTTP_HOST'];
        $message = "Hello, a request has been made to reset your password for the nursing inventory system. To reset your password, please follow this link: 
        $URL/nursinginventorysystem/newPassword.php?email=$email&pwdRecoveryKey=$pwdRecoveryKey";
        mail($email, "Password Recovery for Nursing Inventory System", $message, "From: ". 'umslnursingit@gmail.com');
        header("Location: ../forgotPassword.php?sent");
    }
}
?>