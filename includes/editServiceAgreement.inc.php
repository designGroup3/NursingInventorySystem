<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
$name = $_POST['name'];
$name = str_replace("\\","\\\\","$name");
$name = str_replace("'","\'","$name");
$cost = $_POST['cost'];
$cost = str_replace("\\","\\\\","$cost");
$cost = str_replace("'","\'","$cost");
$duration = $_POST['duration'];
$duration = str_replace("\\","\\\\","$duration");
$duration = str_replace("'","\'","$duration");
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

if($startDate > $endDate){
    header("Location: ../editServiceAgreement.php?edit=$id&error=reverseDates");
    exit();
}

if($_FILES["file"]["name"] == "") { // no file uploaded
    $sql = "UPDATE serviceAgreements SET Name = '$name', `Annual Cost` = '$cost', Duration = '$duration', `Start Date` = '$startDate', `End Date` = '$endDate' WHERE Id = '$id'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../serviceAgreements.php");
}
else{ //file uploaded
    $extension = end(explode(".", $_FILES["file"]["name"]));

    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error " . $_FILES['file']['error']);
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);

    if ($mime == 'application/pdf') {
        $sql = "UPDATE serviceAgreements SET Name = '$name', `Annual Cost` = '$cost', Duration = '$duration', `Start Date` = '$startDate', `End Date` = '$endDate' WHERE Id = '$id'";
        $result = mysqli_query($conn, $sql);

        move_uploaded_file($_FILES["file"]["tmp_name"], "../serviceAgreements/" . $id . ".pdf");

        header("Location: ../serviceAgreements.php");
    } else {
        header("Location: ../editServiceAgreement.php?edit=12&error=wrongType");
        exit();
    }
}
?>