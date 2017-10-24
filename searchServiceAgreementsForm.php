<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    echo "<br>&nbsp&nbspEnter what criteria you would like to see any matching clients for.
        <form action ='searchServiceAgreementsResults.php' method ='POST' enctype='multipart/form-data'><br>
        &nbsp&nbsp<label>Name<br></label>&nbsp&nbsp<input type='text' name='name'><br><br>
        &nbsp&nbsp<label>Annual Cost<br></label>&nbsp&nbsp$<input type='number' step='0.01' name='cost'><br><br>
        &nbsp&nbsp<label>Duration<br></label>&nbsp&nbsp<input type='text' name='duration'><br><br>
        &nbsp&nbsp<label>Expiration Date<br></label>&nbsp&nbsp<input type='date' name='date'><br><br>
        &nbsp&nbsp<label>Approval Form<br></label>&nbsp&nbsp<input type='file' name='form'><br><br><br>
        &nbsp&nbsp<button type='submit'>Search Service Agreements</button></form>";
}
else{
    header("Location: ./login.php");
}
?>