<?php

include 'header.php';
include 'dbh.php';

$url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($url, 'success') !== false){
    echo "<br>&nbsp&nbspSubtype changed successfully.<br>";
}

$sql = "SELECT Subtype FROM subtypes";
$result = mysqli_query($conn, $sql);

echo '<br>&nbsp&nbspWhich subtype to you want to edit?

<form method="post">
    <label>
        <br>&nbsp&nbsp<select name="subtype" onchange="this.form.submit()">
            <option selected value=""></option>';
            while($row = mysqli_fetch_array($result)) {
                echo '<option value = "'.$row['Subtype'].'">'.$row['Subtype'].'</option>';
            }
        echo '</select></label></form>';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldSubtype = $_POST['subtype'];
    $type = "";

    $sql = "SELECT Type FROM subtypes WHERE Subtype = '". $oldSubtype. "';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $type = $row['Type'];

    if (strpos($oldSubtype, ' ')) {
        $oldSubtype = str_replace(" ", "%20", $oldSubtype);
    }

    echo "<br><form action ='includes/editSubtype.inc.php' method = 'POST'><br>";
        if (strpos($oldSubtype, ' ')) {
        $oldSubtype = str_replace("", "%20", $oldSubtype);
        }
        echo "<input type='hidden' name='oldSubtype' value = $oldSubtype>";
    if (strpos($oldSubtype, '%20')) {
        $oldSubtype = str_replace("%20", " ", $oldSubtype);
    }
        echo "&nbsp&nbsp<label>Subtype Name: </label><br>&nbsp&nbsp<input type='text' name='newSubtype' value='". $oldSubtype. "'><br><br>
        &nbsp&nbsp<label>Type: </label><br>&nbsp&nbsp<input type='text' name='type' value='".$type."'><br><br>
        &nbsp&nbsp<button type='submit'>Edit Subtype</button>
    </form>";
}
?>