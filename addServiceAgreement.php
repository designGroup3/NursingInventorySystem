<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=wrongType') !== false){
        echo "<br>&nbsp&nbspApproval forms must a .pdf, .doc, or .docx file.<br>";
    }

    echo "<head><Title>Add Service Agreement</Title></head>";

    echo "<br><form action='includes/addServiceAgreement.inc.php' method='POST' enctype='multipart/form-data'>
        &nbsp&nbsp<label>Name<br></label>&nbsp&nbsp<input type='text' name='name'><br><br>
        &nbsp&nbsp<label>Annual Cost<br></label>&nbsp&nbsp$<input type='number' step='0.01' name='cost'><br><br>
        &nbsp&nbsp<label>Duration<br></label>&nbsp&nbsp<input type='text' name='duration'><br><br>
        &nbsp&nbsp<label>Expiration Date<br></label>&nbsp&nbsp<input type='date' name='date'><br><br>
        &nbsp&nbsp<label>Approval Form<br></label>&nbsp&nbsp<input type='file' name='file'><br><br><br>
        &nbsp&nbsp<button type='submit'>Add Service Agreement</button></form>";
}
else{
    header("Location: ./login.php");
}
?>