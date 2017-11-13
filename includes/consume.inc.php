<?php
session_start();

include '../dbh.php';

$type = $_POST['type'];
$type = str_replace("'","\'","$type");
$subType = $_POST['subtype'];
$subType = str_replace("'","\'","$subType");
$item = $_POST['item'];
$item = str_replace("'","\'","$item");
$numBorrowed = $_POST['stock'];
$person = $_POST['person'];
$person = str_replace("'","\'","$person");
$reason = $_POST['reason'];
$reason = str_replace("'","\'","$reason");

if(isset($_SESSION['id'])) {
    //get update person
    $id = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id = ". $id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $uid = $row['uid'];

    $sql = "SELECT CURDATE();";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $date = $row['CURDATE()'];

    //check if borrowed amount exceeds stock
    $sql = "SELECT `Number in Stock`, `Minimum Stock` FROM consumables WHERE Item = '".$item."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $stock = $row['Number in Stock'];
    $minimum = $row['Minimum Stock'];
    $remaining = $stock - $numBorrowed;

    if($numBorrowed > $stock){
        header("Location: ../consume.php?type=".$type."&subtype=".$subType."&item=".$item."&error=over");
        exit();
    }
    if($numBorrowed == 0){
        header("Location: ../consume.php?type=".$type."&subtype=".$subType."&item=".$item."&error=zero");
        exit();
    }
    if($remaining < $minimum){
        header("Location: ../consume.php?type=".$type."&subtype=".$subType."&item=".$item."&error=breakMin");
        exit();
    }

    $sql = "INSERT INTO consumptions(`Item`, `Subtype`, `Quantity`, `Person`, `Reason`, `Consume Date`, `Update Person`) 
    VALUES('".$item."','".$subType."','".$numBorrowed."','". $person."','". $reason."','".$date."','".$uid."');";
    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE consumables SET `Number in Stock` = ".$remaining.", `Last Processing Date` = '".$date."', `Last Processing Person` = '".$uid."' WHERE `Item` = '".$item."';";
    $result = mysqli_query($conn, $sql);

    header("Location: ../consume.php?success");
    exit();
}
?>