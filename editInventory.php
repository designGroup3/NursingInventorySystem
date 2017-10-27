<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $serialNumber = $_GET['edit'];
    $columnNames = array();
    echo "<head><Title>Edit Inventory</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspAn item with that serial number already exists.<br>";
    }

    $sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
    $result = mysqli_query($conn, $sql);
    $innerCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($innerCount < 2) {
            $innerCount++;
            array_push($columnNames, $row['Field']);
        }
    }
    $sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
    $result = mysqli_query($conn, $sql);
    $innerCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        $innerCount++;
        if ($innerCount > 2) {
            array_push($columnNames, $row['Field']);
        }
    }

    echo "<form action ='includes/editInventory.inc.php' method ='POST'><br>
            <input type='hidden' name='serialNumber' value = $serialNumber>";

    $sql="SELECT * FROM inventory WHERE `Serial Number` = '".$serialNumber."';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    for($count = 0; $count < (count($columnNames)); $count++){
        if($columnNames[$count] != "Last Processing Date" && $columnNames[$count] != "Last Processing Person"){ //Last processing date & person should not be editable
            $isSelect = false;
            $columnName = $columnNames[$count];
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if($rowType['DATA_TYPE'] == "tinyint" || $count == 2){
                $isSelect = true;
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
            } elseif ($rowType['DATA_TYPE'] == "int") {
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='number' name=";
            }
            else {
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
            }
            if (strpos($columnName, ' ')) { //changes column name for includes file
                $columnName = str_replace(" ", "", $columnName);
            }
            if($isSelect){
                $inputs .= $columnName . ">";
                if($count == 2){
                    $sqlSubtype = "SELECT Subtype FROM inventory WHERE `Serial Number` = '". $serialNumber."';";
                    $resultSubtype = mysqli_query($conn, $sqlSubtype);
                    $subRow = mysqli_fetch_array($resultSubtype);
                    $Subtype = $subRow['Subtype'];

                    $sql3 = "SELECT Subtype FROM subtypes";
                    $result3 = mysqli_query($conn, $sql3);
                    while($SubtypeRow = mysqli_fetch_array($result3)){
                        if($Subtype === $SubtypeRow['Subtype']){
                            $inputs .= "<option selected=\"selected\" value= '". $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
                        }
                        else{
                            $inputs .= "<option value= '". $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
                        }
                    }
                    $inputs .= "</select><br><br>";
                }
                else{
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
            }
            else{
                $inputs .= $columnName . " value=\"" . $row[$columnNames[$count]] . "\"><br><br>";
            }
            echo $inputs;
        }
    }
    echo '<input type="hidden" name="originalSerialNumber" value = \''.$row['Serial Number']. '\'>
          &nbsp&nbsp<button type=\'submit\'>Submit</button></form>';
    $retrievedData = $row[$columnNames[2]];

    echo '<br><br><img src=QRCode.php?text='.$retrievedData.' width="135" height="125" title="QR Code" alt="QR Code">';
}
else{
    header("Location: ./login.php");
}
?>