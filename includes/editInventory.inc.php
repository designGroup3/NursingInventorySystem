<?php
session_start();

include '../dbh.php';

$inv_id = $_POST['inv_id'];
$inventoryColumns = array();
$inventoryValues = array();

$sql="SHOW COLUMNS FROM inventory";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($inventoryColumns, $row['Field']);
        if(strpos($row['Field'],' ')){
            $columnName = str_replace(" ","", $row['Field']);
            array_push($inventoryValues, $_POST[$columnName]);
        }
        else{
            array_push($inventoryValues, $_POST[$row['Field']]);
        }
}

$sql = "UPDATE inventory SET ";
for($count = 0; $count< count($inventoryColumns); $count++){
    $sql .= "`" . $inventoryColumns[$count] . "`" . " = '" . $inventoryValues[$count]. "' ";
    if($count !== count($inventoryColumns) -1){
        $sql .= ", ";
    }
}

$sql .= "WHERE inv_id = '$inv_id';";

$result = mysqli_query($conn, $sql);

//$sql = "UPDATE subtypes SET type = ". $_POST['Type']; //type can be read from subtype
//
//$result = mysqli_query($conn, $sql);

header("Location: ../index.php");

?>