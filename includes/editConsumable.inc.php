<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
$consumableColumns = array();
$consumableValues = array();

$sql="SHOW COLUMNS FROM consumables";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
    array_push($consumableColumns, $row['Field']);
    if(strpos($row['Field'],' ')){
        $columnName = str_replace(" ","", $row['Field']);
        array_push($consumableValues, $_POST[$columnName]);
    }
    else{
        array_push($consumableValues, $_POST[$row['Field']]);
    }
}

$sql = "UPDATE consumables SET ";
for($count = 0; $count< count($consumableColumns); $count++){
    $sql .= "`" . $consumableColumns[$count] . "`" . " = '" . $consumableValues[$count]. "' ";
    if($count !== count($consumableColumns) -1){
        $sql .= ", ";
    }
}

$sql .= "WHERE id = '$id';";

$result = mysqli_query($conn, $sql);

header("Location: ../consumables.php");

?>