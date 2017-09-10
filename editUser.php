<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=username') !== false){
        echo "<br>&nbsp&nbspUsername already in use.<br>";
        exit();
    }

    $id = $_GET['edit'];

    $sql="SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<form action ='includes/editUser.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            &nbsp&nbsp<label>First Name:</label> <br>&nbsp&nbsp<input type='text' name='first' value=".$row['first']."><br><br>
            &nbsp&nbsp<label>Last Name:</label> <br>&nbsp&nbsp<input type='text' name='last' value=".$row['last']."><br><br>
            &nbsp&nbsp<label>User Name:</label> <br>&nbsp&nbsp<input type='text' name='uid' value=".$row['uid']."><br><br>
            &nbsp&nbsp<button type='submit'>Submit</button>";

}

else{
    echo "<br> Please log in to manipulate the database";
}
?>