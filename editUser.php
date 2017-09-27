<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=username') !== false){
        echo "<br>&nbsp&nbspUsername already in use.<br>";
        exit();
    }
    elseif(strpos($url, 'error=noAdmin') !== false){
        echo "<br>&nbsp&nbspThere must be at least 1 admin in the system.<br>";
    }

    $id = $_GET['edit'];

    $sql="SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<form action ='includes/editUser.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            &nbsp&nbsp<label>First Name:</label> <br>&nbsp&nbsp<input type='text' name='first' value='".$row['first']."'><br><br>
            &nbsp&nbsp<label>Last Name:</label> <br>&nbsp&nbsp<input type='text' name='last' value='".$row['last']."'><br><br>
            &nbsp&nbsp<label>User Name:</label> <br>&nbsp&nbsp<input type='text' name='uid' value='".$row['uid']."'><br><br>
            &nbsp&nbsp<label>Account Type:</label> <br>&nbsp&nbsp<select name='type'>";
    if($row['acctType'] == "Standard User"){
        echo "<option selected value='Standard User'>Standard User</option><option value='Admin'>Admin</option>";
    }
    elseif($row['acctType'] == "Admin"){
        echo "<option value='Standard User'>Standard User</option><option selected value='Admin'>Admin</option>";
    }
    echo "</select><br><br>&nbsp&nbsp<button type='submit'>Submit</button>";
}

else{
    echo "<br> Please log in to manipulate the database";
}
?>