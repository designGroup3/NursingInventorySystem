<?php
session_start();

include '../dbh.php';

$name = $_POST['name'];
$cost = $_POST['cost'];
$duration = $_POST['duration'];
$date = $_POST['date'];

//$image = addslashes(file_get_contents($_FILES['form']['tmp_name']));
//$image_size = getimagesize($_FILES['form']['tmp_name']); //will return false if the file isn't an image
//
//if($image_size == FALSE){
//    header("Location: ../serviceAgreements.php?error=nonImage");
//    exit();
//}

//$sql = "INSERT INTO serviceAgreements (Name, `Annual Cost`, Duration, `Expiration Date`, Approval)
//    VALUES ('$name', '$cost', '$duration', '$date', '$image');";



$extension = end(explode(".", $_FILES["file"]["name"]));

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed with error " . $_FILES['file']['error']);
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file']['tmp_name']);

//switch ($mime) {
//    case 'application/pdf':
//    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': //docx
//    case 'application/msword':

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
    //default:
        header("Location: ../addServiceAgreement.php?error=wrongType");
        exit();
}
?>