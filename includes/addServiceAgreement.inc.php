<?php
session_start();

include '../dbh.php';

$name = $_POST['name'];
$cost = $_POST['cost'];
$duration = $_POST['duration'];
$date = $_POST['date'];

$image = addslashes(file_get_contents($_FILES['form']['tmp_name']));
$image_size = getimagesize($_FILES['form']['tmp_name']); //will return false if the file isn't an image

if($image_size == FALSE){
    header("Location: ../serviceAgreements.php?error=nonImage");
    exit();
}

$sql = "INSERT INTO serviceAgreements (Name, `Annual Cost`, Duration, `Expiration Date`, Approval) 
    VALUES ('$name', '$cost', '$duration', '$date', '$image');";

$result = mysqli_query($conn, $sql);

header("Location: ../serviceAgreements.php");

?>