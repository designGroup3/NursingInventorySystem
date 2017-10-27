<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    //include 'includes/bootstrap.inc.php';
    include 'dbh.php';

    echo "<head><Title>Add Inventory Column</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspA column already exists by that name.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the column.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspColumn added successfully.<br>";
    }

    echo "<form action ='includes/addInventoryColumn.inc.php' method = 'POST'><br>
                &nbsp&nbsp<label>Name: </label><br>&nbsp&nbsp<input type='text' name='name'><br><br>
                &nbsp&nbsp<label>Data Type: </label><br>&nbsp&nbsp<select name ='type'>
                <option value='varchar'>Letters & Numbers</option>
                <option value='tinyint'>Yes or No</option></select><br><br>
                &nbsp&nbsp<button type='submit'>Add Column</button>
             </form>";
}
else{
    header("Location: ./login.php");
}

?>