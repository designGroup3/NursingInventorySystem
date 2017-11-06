<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $id = $_GET['edit'];
    echo "<head><Title>Edit Service Agreement</Title></head>";

    $sql="SELECT * FROM serviceAgreements WHERE Id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<form action ='includes/editServiceAgreement.inc.php' method ='POST' enctype='multipart/form-data'><br>
            <input type='hidden' name='id' value = $id>
            &nbsp&nbsp<label>Name:</label> <br>&nbsp&nbsp<input type='text' name='name' value='".$row['Name']."'><br><br>
            &nbsp&nbsp<label>Annual Cost:</label> <br>&nbsp&nbsp$<input type='number' name='cost' min='0' step='0.01' value='".$row['Annual Cost']."'><br><br>
            &nbsp&nbsp<label>Duration:</label> <br>&nbsp&nbsp<input type='text' name='duration' value='".$row['Duration']."'><br><br>
            &nbsp&nbsp<label>Expiration Date:</label> <br>&nbsp&nbsp<input type='date' name='date' value='".$row['Expiration Date']."'><br><br>
            &nbsp&nbsp<label>Approval Form:</label> <br>&nbsp&nbsp<input type='file' name='approval'><br><br>
            &nbsp&nbsp<button type='submit'>Submit</button>";
}
else{
    header("Location: ./login.php");
}
?>