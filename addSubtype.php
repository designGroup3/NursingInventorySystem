<?php

include 'header.php';
include 'dbh.php';

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'error=exists') !== false){
    echo "<br>&nbsp&nbspThat subtype already exists.<br>";
}
elseif(strpos($url, 'success') !== false){
    echo "<br>&nbsp&nbspNew subtype added successfully.<br>";
}

echo "<br>&nbsp&nbspEnter the subtype and its associated type you want to add.

    <form action ='includes/addSubtype.inc.php' method = 'POST'><br>
        &nbsp&nbsp<label>Subtype: </label><br>&nbsp&nbsp<input type='text' name='subtype'><br><br>
        &nbsp&nbsp<label>Type: </label><br>&nbsp&nbsp<input type='text' name='type'><br><br>
        &nbsp&nbsp<button type='submit'>Add Subtype</button>
    </form>";

?>