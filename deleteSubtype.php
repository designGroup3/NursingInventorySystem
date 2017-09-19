<?php

include 'header.php';
include 'dbh.php';

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'error=exists') !== false){
    echo "<br>&nbsp&nbspYou cannot delete a subtype while an item is assigned to that subtype.<br>";
}
elseif(strpos($url, 'error=empty') !== false){
    echo "<br>&nbsp&nbspYou must choose a subtype.<br>";
}
elseif(strpos($url, 'success') !== false){
    echo "<br>&nbsp&nbspSubtype deleted successfully.<br>";
}

$sql = "SELECT Subtype FROM subtypes";
$result = mysqli_query($conn, $sql);

echo '<br>&nbsp&nbspWhich subtype to you want to delete?

<form action ="includes/deleteSubtype.inc.php" method = "POST">
    <label>
        <br>&nbsp&nbsp<select name="subtype">
            <option selected value=""></option>';
while($row = mysqli_fetch_array($result)) {
    echo '<option value = "'.$row['Subtype'].'">'.$row['Subtype'].'</option>';
}
echo "</select></label><br><br>&nbsp&nbsp<button type='submit'>Delete Subtype</button></form>";

?>