<style>
    td, th {
        text-align: left;
        padding: 8px;
    }
</style>

<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {

$columnNames = array();
$receivedValues = array();

$sql="SHOW COLUMNS FROM inventory";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($columnNames, $row['Field']);
    if(strpos($row['Field'],' ')){
        $columnName = str_replace(" ","", $row['Field']);
        array_push($receivedValues, $_POST[$columnName]);
    }
    else{
        array_push($receivedValues, $_POST[$row['Field']]);
    }
}

$tableHeadNeeded = true;
$outerCount = 0;
$sql = "SELECT * FROM inventory WHERE ";
$andNeeded = false;

for($count = 0; $count< count($columnNames); $count++){
    if($receivedValues[$count] !== ""){
        $sql .= "`" . $columnNames[$count] . "`" . " = '" . $receivedValues[$count]. "' AND ";
        error_reporting(E_ERROR | E_PARSE);
    }
}

$sql = chop($sql," AND ") .";";

    if($sql == "SELECT * FROM inventory WHERE;"){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchInventoryForm.php'>
                   <input type='submit' value='Search Inventory'/>
              </form>";
        exit();
    }

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $outerCount++;
            echo "<table>";
            for($count = 0; $count< count($columnNames); $count++){
                echo "<th>$columnNames[$count]</th>";
            }
        }
        echo "<tr>";
        for($count = 0; $count< count($columnNames); $count++){
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if($rowType['DATA_TYPE'] == "tinyint"){
                if($row[$columnNames[$count]] == 0){
                    echo '<td>No</td>';
                }
                else{
                    echo '<td>Yes</td>';
                }
            }
            else{
                echo '<td> '.$row[$columnNames[$count]].'</td>';
            }
        }
        echo "<td> <a href='editInventory.php?edit=$row[inv_id]'>Edit<br></td>
                <td> <a href='includes/deleteInventory.inc.php?delete=$row[inv_id]'>Delete<br></td>
            </tr><br>";
    }

    if($outerCount == 0) {
        echo "&nbsp<br> No Items Found That Match All of Those Criteria.<br>";
    }

}
else{
    echo "<br> Please log in to manipulate the database";
}
?>