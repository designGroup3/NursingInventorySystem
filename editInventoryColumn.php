<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Edit Inventory Column</Title><script src=\"./js/jquery.min.js\"></script></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspA column already exists by that name.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the column.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspColumn changed successfully.<br>";
    }

    $columnNames = array();

    $sql = "SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo '<br>&nbsp&nbspWhich column do you want to edit?
    
    <form method="post">
        <label>
            <br>&nbsp&nbsp<select name="column" onchange="this.form.submit()">
                <option selected value=""></option>';

    for($columnsCount = 0; $columnsCount < count($columnNames); $columnsCount++) {
        if($columnsCount > 8){
            echo '<option value = "'.$columnNames[$columnsCount].'">'.$columnNames[$columnsCount].'</option>';
        }
    }
    echo '</select></label></form>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $oldColumn = $_POST['column'];
        $type = "";

        $sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'inventory' AND 
        COLUMN_NAME = '". $oldColumn. "';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $type = $row['DATA_TYPE'];

        if (strpos($oldColumn, ' ')) {
            $oldColumn = str_replace(" ", "%20", $oldColumn);
        }
        echo "<br><form action ='includes/editInventoryColumn.inc.php' method = 'POST'><br>
        <input type='hidden' name='oldColumn' value = $oldColumn>
        <input type='hidden' name='oldType' value = $type>
        <input type='hidden' name='source' value = 'editPage'>";
        if (strpos($oldColumn, '%20')) {
            $oldColumn = str_replace("%20", " ", $oldColumn);
        }

        echo "&nbsp&nbsp<label>Column Name: </label><br>&nbsp&nbsp<input type='text' name='newColumn' value='". $oldColumn. "'><br><br>
            &nbsp&nbsp<label>Type: (Warning, changing type will delete all column data.)</label><br>&nbsp&nbsp<select name='newType' id='newType'>";
        if (strpos($oldColumn, '%20')) {
            $oldColumn = str_replace("%20", " ", $oldColumn);
        }
        if($type == "varchar") {
            echo '<option selected value="Letters & Numbers">Letters & Numbers</option><option value="Yes or No">Yes or No</option>';
        }
        else{
            echo '<option value="Letters & Numbers">Letters & Numbers</option><option selected value="Yes or No">Yes or No</option>';
        }
        echo "</select><br><br>&nbsp&nbsp<button type='submit'>Edit Column</button>
        </form>";

        echo "<script>$('document').ready(function() {
   
    $('#newType').on('change',function(){
        alert(\"Warning: Changing type will delete all column data.\");
    });
    
});</script>";
    }
}
else{
    header("Location: ./login.php");
}
?>