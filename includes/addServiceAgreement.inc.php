<?php
session_start();

include '../dbh.php';

$name = $_POST['name'];
$name = str_replace("'","\'","$name");
$cost = $_POST['cost'];
$duration = $_POST['duration'];
$duration = str_replace("'","\'","$duration");
$date = $_POST['date'];

if($_FILES["file"]["name"] == ""){ //no file uploaded
    $sql = "INSERT INTO serviceAgreements (Name, `Annual Cost`, Duration, `Expiration Date`)
    VALUES ('$name', '$cost', '$duration', '$date');";
    $result = mysqli_query($conn, $sql);

    header("Location: ../serviceAgreements.php");
}
else{ // file uploaded
    $extension = end(explode(".", $_FILES["file"]["name"]));

    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error " . $_FILES['file']['error']);
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);

    if($mime == 'application/pdf') {
        $sql = "INSERT INTO serviceAgreements (Name, `Annual Cost`, Duration, `Expiration Date`)
    VALUES ('$name', '$cost', '$duration', '$date');";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM serviceAgreements ORDER BY Id DESC LIMIT 1;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $docName = $row['Id'];

        $sql = "UPDATE serviceAgreements SET Approval = '$docName' WHERE Id = '$docName';";
        $result = mysqli_query($conn, $sql);

        move_uploaded_file($_FILES["file"]["tmp_name"], "../serviceAgreements/".$docName .".pdf");

        header("Location: ../serviceAgreements.php");
    }
    else{
        header("Location: ../addServiceAgreement.php?error=wrongType");
        exit();
    }
}
?>