<?php
//unused

include 'header.php';
include 'dbh.php';

$oldColumn = $_GET['oldColumn'];
if (strpos($oldColumn, '%20')) {
    $oldColumn = str_replace("%20", " ", $oldColumn);
}
$oldType = $_GET['oldType'];
$newColumn = $_GET['newColumn'];
$newType = $_GET['newType'];

echo "<br>&nbsp&nbspAre you sure you want to change $oldColumn's type? This will delete all data in the column.
        <form action ='includes/editInventoryColumn.inc.php' method ='POST'><br>
            <input type='hidden' name='oldColumn' value = '$oldColumn'>
            <input type='hidden' name='newColumn' value = '$newColumn'>
            <input type='hidden' name='oldType' value = '$oldType'>
            <input type='hidden' name='newType' value = '$newType'>
            <input type='hidden' name='source' value = 'confirmPage'>
            &nbsp&nbsp<button type='submit'>Change data type</button>
        </form><br>
        <form action='editInventoryColumn.php'>
            &nbsp&nbsp<input type='submit' value='Cancel' />
         </form>";