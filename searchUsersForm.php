<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Users</Title></head>";

    echo "<br>&nbsp&nbspEnter what criteria you would like to see any matching users for.
        <form action ='searchUsersResults.php' method ='POST'><br>
        &nbsp&nbsp<label>First Name<br></label>&nbsp&nbsp<input type='text' name='first'><br><br>
        &nbsp&nbsp<label>Last Name<br></label>&nbsp&nbsp<input type='text' name='last'><br><br>
        &nbsp&nbsp<label>Account Name<br></label>&nbsp&nbsp<input type='text' name='accountName'><br><br>
        &nbsp&nbsp<label>Email<br></label>&nbsp&nbsp<input type='text' name='email'><br><br>
        &nbsp&nbsp<label>Account Type<br></label>&nbsp&nbsp<select name='accountType'>
        <option selected value=''></option><option value='Standard User'>Standard User</option><option value='Admin'>Admin</option><option value='Super Admin'>Super Admin</option></select><br><br>
        &nbsp&nbsp<label>Date Added<br></label>&nbsp&nbsp<input type='date' name='dateAdded'><br><br><br>
        &nbsp&nbsp<button type='submit'>Search Users</button></form>";
}
else{
    header("Location: ./login.php");
}
?>