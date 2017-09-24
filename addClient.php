<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    echo "<br><form action='includes/addClient.inc.php' method='POST'>
        &nbsp&nbsp<label>Last Name<br></label>&nbsp&nbsp<input type='text' name='last'><br><br>
        &nbsp&nbsp<label>First Name<br></label>&nbsp&nbsp<input type='text' name='first'><br><br>
        &nbsp&nbsp<label>Ext.<br></label>&nbsp&nbsp<input type='number' name='ext'><br><br>
        &nbsp&nbsp<label>Email<br></label>&nbsp&nbsp<input type='email' name='email'><br><br>
        &nbsp&nbsp<label>Office<br></label>&nbsp&nbsp<input type='text' name='office'><br><br><br>
        &nbsp&nbsp<button type='submit'>Add Client</button></form>";
}

else{
    echo "<br> Please log in to manipulate the database";
}
?>