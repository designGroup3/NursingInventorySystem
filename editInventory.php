<?php
include 'header.php';
include 'dbh.php';

$inv_id = $_GET['edit'];
$columnNames = array();

if(isset($_SESSION['id'])) {
    $sql="SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    $sql="SELECT * FROM inventory WHERE inv_id = $inv_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo "<form action ='includes/editInventory.inc.php' method ='POST'><br>
            <input type='hidden' name='inv_id' value = $inv_id>";
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
                if (strpos($columnName, ' ')) { //changes column name for includes file
                    $columnName = str_replace(" ", "", $columnName);
                }
                if($isSelect){
                    $inputs .= $columnName . ">";
                    if($row[$columnNames[$count]] == 0 && $row[$columnNames[$count]] !== null){
                        $inputs .= "<option value=0>No</option><option value=1>Yes</option></select><br><br>";
                    }
                    elseif($row[$columnNames[$count]] !== null){
                        $inputs .= "<option value=1>Yes</option><option value=0>No</option></select><br><br>";
                    }
                    else{
                        $inputs .= "<option value=''></option><option value=1>Yes</option><option value=0>No</option></select><br><br>";
                    }
                }
                else{
                    $inputs .= $columnName . " value=" . $row[$columnNames[$count]] . "><br><br>";
                }
                echo $inputs;
            }
            echo "&nbsp&nbsp<button type='submit'>Submit</button></form>";

    $retrievedData = $row[$columnNames[1]];

    echo '<br><img src=QRCode.php?text='.$retrievedData.' width="135" height="125" title="QR Code" alt="QR Code">';

}
else{
    echo "<br> Please log in to manipulate the database";
}
?>