<?php
session_start();

include '../dbh.php';

$inv_id = $_POST['inv_id'];
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

$sql = "UPDATE inventory SET ";
for($count = 0; $count< count($columnNames); $count++){
   $sql .= "`" . $columnNames[$count] . "`" . " = '" . $receivedValues[$count]. "' ";
   if($count !== count($columnNames) -1){
       $sql .= ", ";
   }
}
$sql .= "WHERE inv_id = '$inv_id';";

$result = mysqli_query($conn, $sql);

header("Location: ../index.php");

?>