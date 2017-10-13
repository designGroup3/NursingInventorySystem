<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    echo "<br>&nbsp&nbspEnter what criteria you would like to see any matching items for.
        <form action ='searchClientsResults.php' method ='POST'><br>
        &nbsp&nbsp<label>Last Name<br></label>&nbsp&nbsp<input type='text' name='last'><br><br>
        &nbsp&nbsp<label>First Name<br></label>&nbsp&nbsp<input type='text' name='first'><br><br>
        &nbsp&nbsp<label>Ext.<br></label>&nbsp&nbsp<input type='number' name='ext'><br><br>
        &nbsp&nbsp<label>Email<br></label>&nbsp&nbsp<input type='email' name='email'><br><br>
        &nbsp&nbsp<label>Office<br></label>&nbsp&nbsp<input type='text' name='office'><br><br><br>
        &nbsp&nbsp<button type='submit'>Search Clients</button></form>";
}
else{
    header("Location: ./login.php");
}
?>