<?php
	include 'header.php';
	include './dbh.php';
    echo "<head><Title>Signup</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=empty') !== false){
        echo "<br>&nbsp&nbspPlease fill out all fields.<br>";
    }
    elseif(strpos($url, 'error=username') !== false){
        echo "<br>&nbsp&nbspUsername already in use.<br>";
    }
    elseif(strpos($url, 'error=email') !== false){
        echo "<br>&nbsp&nbspEmail Address already in use.<br>";
    }

    if(isset($_SESSION['id'])){
        echo "<br><form class='signupform' action='includes/signup.inc.php' method='POST'>
        &nbsp&nbsp<label>First Name<br></label>&nbsp&nbsp<input type='text' name='first'><br><br>
        &nbsp&nbsp<label>Last Name<br></label>&nbsp&nbsp<input type='text' name='last'><br><br>
        &nbsp&nbsp<label>Email<br></label>&nbsp&nbsp<input type='email' name='email'><br><br>
        &nbsp&nbsp<label>Account Type<br></label>&nbsp&nbsp<select name='acctType'>
        <option value='Standard User'>Standard User</option>";
        $currentID = $_SESSION['id'];
        $sql = "SELECT acctType FROM users WHERE id='$currentID'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
        $acctType = $row['acctType'];
        if($acctType == "Admin" || $acctType == "Super Admin"){
            echo "<option value='Admin'>Admin</option>";
        }
        if($acctType == "Super Admin"){
            echo "<option value='Super Admin'>Super Admin</option>";
        }
        echo "</select><br><br>&nbsp&nbsp<label>Username<br></label>&nbsp&nbsp<input type='text' name='uid'><br><br>
        &nbsp&nbsp<label>Password<br></label>&nbsp&nbsp<input type='password' name='pwd'><br><br><br>
        &nbsp&nbsp<button type='submit'>Sign Up</button>
    </form>";
    }else {
        header("Location: ./login.php");
    }
?>