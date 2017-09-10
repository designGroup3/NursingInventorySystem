<?php
session_start();

include '../dbh.php';

$first = $_POST['first'];
$last = $_POST['last'];
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];

if(empty($first)){
    header("Location: ../signup.php?error=empty");
    exit();
}
if(empty($last)){
    header("Location: ../signup.php?error=empty");
    exit();
}
if(empty($uid)){
    header("Location: ../signup.php?error=empty");
    exit();
}
if(empty($pwd)){
    header("Location: ../signup.php?error=empty");
    exit();
}
else{
    $sql="SELECT uid FROM users WHERE uid='$uid'";
    $result = mysqli_query($conn, $sql);
    $uidcheck = mysqli_num_rows($result);
    if($uidcheck > 0){
        header("Location: ../signup.php?error=username");
        exit();
    }
    $encrypted_password = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first, last, uid, pwd) 
    VALUES ('$first', '$last', '$uid', '$encrypted_password')";

    $result = mysqli_query($conn, $sql);

    header("Location: ../index.php");
}
?>