<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Add Client</Title></head><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "<br><form action='includes/addClient.inc.php' method='POST'>
        &nbsp&nbsp<label>Last Name<br></label>&nbsp&nbsp<input type='text' name='last'><br><br>
        &nbsp&nbsp<label>First Name<br></label>&nbsp&nbsp<input type='text' name='first'><br><br>
        &nbsp&nbsp<label>Ext.<br></label>&nbsp&nbsp<input type='number' min='0' name='ext'><br><br>
        &nbsp&nbsp<label>Email<br></label>&nbsp&nbsp<input type='email' name='email'><br><br>
        &nbsp&nbsp<label>Office<br></label>&nbsp&nbsp<input type='text' name='office'><br><br><br>
        &nbsp&nbsp<button type='submit'>Add Client</button></form>";
}
else{
    header("Location: ./login.php");
}
?>