<?php
include 'header.php';
include 'dbh.php';

$columnNames = array();

if(isset($_SESSION['id'])) {
    $sql="SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<br>&nbsp&nbspEnter what criteria you would like to see any matching items for.
        <form action ='searchInventoryResults.php' method ='POST'><br>";
            for($count = 0; $count< count($columnNames); $count++){
                $isSelect = false;
                $columnName = $columnNames[$count];
                $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
                $result2 = mysqli_query($conn, $sql2);
                $rowType = mysqli_fetch_array($result2);
                if($rowType['DATA_TYPE'] == "tinyint"){
                    $isSelect = true;
                    $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
                }
                else {
                    $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
                }
                if (strpos($columnName, ' ')) {
                    $columnName = str_replace(" ", "", $columnName);
                }
                if($isSelect){
                    $inputs .= $columnName . "><option value=''></option>
                    <option value=1>Yes</option><option value=0>No</option></select><br><br>";
                }
                else{
                    $inputs .= $columnName . " value=" . $row[$columnNames[$count]] . "><br><br>";
                }
                echo $inputs;
            }
            echo "&nbsp&nbsp<button type='submit'>Submit</button></form>";
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>