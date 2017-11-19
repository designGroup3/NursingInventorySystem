<?php
session_start();

include '../dbh.php';

$first = $_POST['first'];
$first = str_replace("\\","\\\\","$first");
$first = str_replace("'","\'","$first");
$last = $_POST['last'];
$last = str_replace("\\","\\\\","$last");
$last = str_replace("'","\'","$last");
$email = $_POST['email'];
$email = str_replace("\\","\\\\","$email");
$email = str_replace("'","\'","$email");
$acctType = $_POST['acctType'];
$uid = $_POST['uid'];
$uid = str_replace("\\","\\\\","$uid");
$uid = str_replace("'","\'","$uid");
$pwd = $_POST['pwd'];

$sql = "SELECT CURDATE();";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$date = $row['CURDATE()'];

if(empty($first)){
    header("Location: ../signup.php?error=empty");
    exit();
}
if(empty($last)){
    header("Location: ../signup.php?error=empty");
    exit();
}
if(empty($email)){
    header("Location: ../signup.php?error=empty");
    exit();
}
if(empty($acctType)){
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
    $sql="SELECT Uid FROM users WHERE Uid='$uid'";
    $result = mysqli_query($conn, $sql);
    $uidcheck = mysqli_num_rows($result);
    if($uidcheck > 0){
        header("Location: ../signup.php?error=username");
        exit();
    }

    $sql="SELECT Email FROM users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);
    $emailcheck = mysqli_num_rows($result);
    if($emailcheck > 0){
        header("Location: ../signup.php?error=email");
        exit();
    }

    $pwdRecoverKey = rand();
    $pwdRecoverKey *= 1000000;
    $pwdRecoverKey = floor($pwdRecoverKey);

    $encrypted_password = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (First, Last, Uid, Pwd, Email, `Account Type`, `Date Added`, `Pwd Recovery Key`) 
    VALUES ('$first', '$last', '$uid', '$encrypted_password', '$email', '$acctType', '".$date."', $pwdRecoverKey);";

    $result = mysqli_query($conn, $sql);

    header("Location: ../usersTable.php?success");
}
?>