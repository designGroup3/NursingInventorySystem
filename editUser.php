<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Edit User</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=username') !== false){
        echo "<br>&nbsp&nbspUsername already in use.<br>";
        exit();
    }
    elseif(strpos($url, 'error=noAdmin') !== false){
        echo "<br>&nbsp&nbspThere must be at least 1 Super Admin in the system.<br>";
    }
    elseif(strpos($url, 'error=email') !== false){
        echo "<br>&nbsp&nbspThat email address is already in use.<br>";
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
            <input type='hidden' name='originalType' value='".$row['acctType']."'>
            <input type='hidden' name='originalEmail' value='".$row['email']."'>
            &nbsp&nbsp<label>Email:</label> <br>&nbsp&nbsp<input type='email' name='email' value='".$row['email']."'><br><br>
            &nbsp&nbsp<label>Account Type:</label> <br>&nbsp&nbsp<select name='type'>";
    if($row['acctType'] == "Standard User"){
        echo "<option selected value='Standard User'>Standard User</option><option value='Admin'>Admin</option><option value='Super Admin'>Super Admin</option>";
    }
    elseif($row['acctType'] == "Admin"){
        echo "<option value='Standard User'>Standard User</option><option selected value='Admin'>Admin</option><option value='Super Admin'>Super Admin</option>";
    }
    elseif($row['acctType'] == "Super Admin"){
        echo "<option value='Standard User'>Standard User</option><option value='Admin'>Admin</option><option selected value='Super Admin'>Super Admin</option>";
    }
    echo "</select><br><br>&nbsp&nbsp<button type='submit'>Submit</button>";
}

else{
    header("Location: ./login.php");
}
?>