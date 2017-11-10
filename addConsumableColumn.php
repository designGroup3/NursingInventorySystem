<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Add Consumable Column</Title></head><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

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

    echo "<form action ='includes/addConsumableColumn.inc.php' method = 'POST'><br>
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