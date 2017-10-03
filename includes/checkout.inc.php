<?php
session_start();

include '../dbh.php';

$type = $_POST['type'];
$subType = $_POST['subtype'];
$item = $_POST['item'];
$numBorrowed = $_POST['stock'];
$person = $_POST['person'];
$reason = $_POST['reason'];
$notes = $_POST['notes'];
$date = $_POST['date'];

if(isset($_SESSION['id'])) {
    //get update person
    $id = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id = ". $id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $uid = $row['uid'];

    //check if borrowed amount exceeds stock
    $sql = "SELECT `Number in Stock`, `Minimum Stock` FROM inventory WHERE Item = '".$item."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $stock = $row['Number in Stock'];
    $minimum = $row['Minimum Stock'];
    $remaining = $stock - $numBorrowed;

    if($numBorrowed > $stock){
        header("Location: ../checkout.php?type=".$type."&subtype=".$subType."&item=".$item."&error=over");
        exit();
    }
    if($numBorrowed == 0){
        header("Location: ../checkout.php?type=".$type."&subtype=".$subType."&item=".$item."&error=zero");
        exit();
    }
    if($remaining < $minimum){
        header("Location: ../checkout.php?type=".$type."&subtype=".$subType."&item=".$item."&error=breakMin");
        exit();
    }

    //finds serial number
    $sql = "SELECT `Serial Number` FROM inventory WHERE Item = '".$item."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $serialNumber = $row['Serial Number'];

    $sql = "INSERT INTO checkouts(`Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`,
    `Due Date`, `Checkout Date`, `Update Person`) VALUES('".$item."','".$subType."','".$numBorrowed."','".$serialNumber."','".
    $person."','".$reason."','".$notes."','".$date."','".date('Y/m/d')."','".$uid."');";

    $result = mysqli_query($conn, $sql);

    $sql = "UPDATE inventory SET `Number in Stock` = ".$remaining.", `Last Processing Date` = '".date('Y/m/d')."', `Last Processing Person` = '".$uid."' WHERE `Item` = '".$item."';";
    $result = mysqli_query($conn, $sql);

    header("Location: ../checkout.php?success");
    exit();
}
?>