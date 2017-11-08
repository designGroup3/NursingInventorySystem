<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
$name = $_POST['name'];
$cost = $_POST['cost'];
$duration = $_POST['duration'];
$date = $_POST['date'];

//$image = addslashes(file_get_contents($_FILES['approval']['tmp_name']));
//$image_size = getimagesize($_FILES['approval']['tmp_name']); //will return false if the file isn't an image
//
//if($image_size == FALSE && $image !== "") {
//    header("Location: ../serviceAgreements.php?error=nonImage");
//    exit();
//}

$extension = end(explode(".", $_FILES["file"]["name"]));

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed with error " . $_FILES['file']['error']);
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file']['tmp_name']);

if($mime == 'application/pdf') {
    $sql = "UPDATE serviceAgreements SET Name = '$name', `Annual Cost` = '$cost', Duration = '$duration', `Expiration Date` = '$date', Approval = '$id' WHERE Id = '$id'";
    $result = mysqli_query($conn, $sql);

    move_uploaded_file($_FILES["file"]["tmp_name"], "../serviceAgreements/".$id .".pdf");

    header("Location: ../serviceAgreements.php");
}
else{
    header("Location: ../editServiceAgreement.php?edit=12&error=wrongType");
    exit();
}

//if($image == ""){
//    $sql = "UPDATE serviceAgreements SET Name = '$name', `Annual Cost` = '$cost', Duration = '$duration', `Expiration Date` = '$date' WHERE Id = '$id'";
//}
//else{
//    $sql = "UPDATE serviceAgreements SET Name = '$name', `Annual Cost` = '$cost', Duration = '$duration', `Expiration Date` = '$date', Approval = '$image' WHERE Id = '$id'";
//}
//
//$result = mysqli_query($conn, $sql);
?>