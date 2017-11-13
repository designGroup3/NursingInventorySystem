<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $number = $_GET['edit'];
    echo "<head><Title>Edit Client</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $sql="SELECT * FROM clients WHERE number = $number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<form action ='includes/editClient.inc.php' method ='POST'><br>
            <input type='hidden' name='number' value = $number>
            &nbsp&nbsp<label>Last Name:</label> <br>&nbsp&nbsp<input type='text' name='last' value='".$row['Last']."'><br><br>
            &nbsp&nbsp<label>First Name:</label> <br>&nbsp&nbsp<input type='text' name='first' value='".$row['First']."'><br><br>
            &nbsp&nbsp<label>Ext:</label> <br>&nbsp&nbsp<input type='number' min='0' name='ext' value='".$row['Ext']."'><br><br>
            &nbsp&nbsp<label>Email:</label> <br>&nbsp&nbsp<input type='email' name='email' value='".$row['Email']."'><br><br>
            &nbsp&nbsp<label>Office:</label> <br>&nbsp&nbsp<input type='text' name='office' value='".$row['Office']."'><br><br>
            &nbsp&nbsp<button type='submit'>Submit</button>";
}
else{
    header("Location: ./login.php");
}
?>