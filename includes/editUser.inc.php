<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
$first = $_POST['first'];
$last = $_POST['last'];
$uid = $_POST['uid'];
$email = $_POST['email'];
$originalEmail = $_POST['originalEmail'];
$originalType = $_POST['originalType'];
$type = $_POST['type'];

if($type == "Standard User"){
    $sql = "SELECT acctType FROM users WHERE acctType = 'Super Admin'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);

    if($row == 1 && $originalType == "Super Admin"){
        header("Location: ../editUser.php?edit=".$id."&error=noAdmin");
        exit();
    }
}

$sql = "SELECT uid FROM users WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$uidcheck = mysqli_num_rows($result);
if($uidcheck > 0) {
    $sql = "SELECT uid FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();

    if($uid != $row['uid']) {
        header("Location: ../editUser.php?edit=".$id."&error=username");
        exit();
    }
}

$sql = "SELECT email FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$emailCheck = mysqli_num_rows($result);
if($emailCheck > 0 && $email !== $originalEmail) {
    header("Location: ../editUser.php?edit=".$id."&error=email");
    exit();
}

$sql = "UPDATE users SET first = '$first', last = '$last', uid = '$uid', acctType = '$type', email = '$email' WHERE id ='$id';";

$result = mysqli_query($conn, $sql);

header("Location: ../usersTable.php");

?>