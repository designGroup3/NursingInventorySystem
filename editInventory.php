<?php
include 'header.php';
include 'dbh.php';

$inv_id = $_GET['edit'];
$columnNames = array();

if(isset($_SESSION['id'])) {
    $sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
    $result = mysqli_query($conn, $sql);
    $innerCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($innerCount < 2) {
            $innerCount++;
            array_push($columnNames, $row['Field']);
        }
    }
    array_push($columnNames,"Type"); //from Subtype table
    $sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
    $result = mysqli_query($conn, $sql);
    $innerCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        $innerCount++;
        if ($innerCount > 2) {
            array_push($columnNames, $row['Field']);
        }
    }

    $sql="SELECT Item, inventory.Subtype, subtypes.Type FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype WHERE inv_id = ".$inv_id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo "<form action ='includes/editInventory.inc.php' method ='POST'><br>
            <input type='hidden' name='inv_id' value = $inv_id>";
            for($count = 1; $count < 4; $count++){
                echo "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=".$columnNames[$count]." value=".$row[$columnNames[$count]]."><br><br>";
            }

    $sql="SELECT * FROM inventory WHERE inv_id = ".$inv_id.";";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    for($count = 4; $count < (count($columnNames)); $count++){ //inv_id is not editable
        $columnName = $columnNames[$count];
        $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
        if(strpos($columnName,' ')){
            $columnName = str_replace(" ","", $columnName);
        }
        $inputs .= $columnName." value=".$row[$columnNames[$count]]."><br><br>";
        echo $inputs;
    }
            echo "&nbsp&nbsp<button type='submit'>Submit</button></form>";
//            for($count = 0; $count< count($columnNames); $count++){
//                $isSelect = false;
//                $columnName = $columnNames[$count];
//                $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
//                WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
//                $result2 = mysqli_query($conn, $sql2);
//                $rowType = mysqli_fetch_array($result2);
//                if($rowType['DATA_TYPE'] == "tinyint"){
//                    $isSelect = true;
//                    $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
//                }
//                else {
//                    $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
//                }
//                if (strpos($columnName, ' ')) { //changes column name for includes file
//                    $columnName = str_replace(" ", "", $columnName);
//                }
//                if($isSelect){
//                    $inputs .= $columnName . ">";
//                    if($row[$columnNames[$count]] == 0 && $row[$columnNames[$count]] !== null){
//                        $inputs .= "<option value=0>No</option><option value=1>Yes</option></select><br><br>";
//                    }
//                    elseif($row[$columnNames[$count]] !== null){
//                        $inputs .= "<option value=1>Yes</option><option value=0>No</option></select><br><br>";
//                    }
//                    else{
//                        $inputs .= "<option value=''></option><option value=1>Yes</option><option value=0>No</option></select><br><br>";
//                    }
//                }
//                else{
//                    $inputs .= $columnName . " value=" . $row[$columnNames[$count]] . "><br><br>";
//                }
                //echo $inputs;
            //}
           // echo "&nbsp&nbsp<button type='submit'>Submit</button></form>";

    //$retrievedData = $row[$columnNames[1]];

    //echo '<br><img src=QRCode.php?text='.$retrievedData.' width="135" height="125" title="QR Code" alt="QR Code">';

}
else{
    echo "<br> Please log in to manipulate the database";
}
?>