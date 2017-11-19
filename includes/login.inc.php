<?php
session_start();
include '../dbh.php';

$uid = mysqli_real_escape_string($conn, $_POST['uid']);
$uid = str_replace("\\","\\\\","$uid");
$uid = str_replace("'","\'","$uid");
$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

$sql = "SELECT * FROM users WHERE Uid = '$uid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['Pwd'];
$hash = password_verify($pwd, $hash_pwd);

if($hash == 0){
    header("Location: ../login.php?error=input");
    exit();

} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE Uid= ? AND Pwd = ?");
    $stmt->bind_param("ss", $username, $password);

    $username = $uid;
    $password = $hash_pwd;
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    $_SESSION['id'] = $row['Id'];

    header("Location: ../index.php");
}
?>