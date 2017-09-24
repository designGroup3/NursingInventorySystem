<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    $number = $_GET['edit'];

    $sql="SELECT * FROM clients WHERE number = $number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<form action ='includes/editClient.inc.php' method ='POST'><br>
            <input type='hidden' name='number' value = $number>
            &nbsp&nbsp<label>Last Name:</label> <br>&nbsp&nbsp<input type='text' name='last' value=".$row['Last']."><br><br>
            &nbsp&nbsp<label>First Name:</label> <br>&nbsp&nbsp<input type='text' name='first' value=".$row['First']."><br><br>
            &nbsp&nbsp<label>Ext:</label> <br>&nbsp&nbsp<input type='number' name='ext' value=".$row['Ext']."><br><br>
            &nbsp&nbsp<label>Email:</label> <br>&nbsp&nbsp<input type='email' name='email' value=".$row['Email']."><br><br>
            &nbsp&nbsp<label>Office:</label> <br>&nbsp&nbsp<input type='text' name='office' value=".$row['Office']."><br><br>
            &nbsp&nbsp<button type='submit'>Submit</button>";
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>