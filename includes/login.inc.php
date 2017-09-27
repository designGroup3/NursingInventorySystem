<?php
session_start();
include '../dbh.php';

$uid = mysqli_real_escape_string($conn, $_POST['uid']);
$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

$sql = "SELECT * FROM users WHERE uid = '$uid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['pwd'];
$hash = password_verify($pwd, $hash_pwd);

if($hash == 0){
    header("Location: ../login.php?error=input");
    exit();

} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE uid= ? AND pwd = ?");
    $stmt->bind_param("ss", $username, $password);

    $username = $uid;
    $password = $hash_pwd;
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    $_SESSION['id'] = $row['id'];
    header("Location: ../index.php");
}
?>