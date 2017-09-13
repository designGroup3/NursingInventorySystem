<?php
session_start();

include '../dbh.php';

$inv_id = $_POST['inv_id'];
$columnNames = array();
$receivedValues = array();

//$sql="SHOW COLUMNS FROM inventory";
//$result = mysqli_query($conn, $sql);
//while($row = mysqli_fetch_array($result)) {
//    array_push($columnNames, $row['Field']);
//    if(strpos($row['Field'],' ')){
//        $columnName = str_replace(" ","", $row['Field']);
//        array_push($receivedValues, $_POST[$columnName]);
//    }
//    else{
//        array_push($receivedValues, $_POST[$row['Field']]);
//    }
//}

$sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
$result = mysqli_query($conn, $sql);
$innerCount = 0;
while ($row = mysqli_fetch_array($result)) {
    if ($innerCount < 3) {
        $innerCount++;
        array_push($columnNames, $row['Field']);
    }
}
array_push($columnNames,"Subtype"); //from Type table
$sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
$result = mysqli_query($conn, $sql);
$innerCount = 0;
$columnCount = 0;
while ($row = mysqli_fetch_array($result)) {
    $innerCount++;
    $columnCount++;
    if ($innerCount > 3) {
        array_push($columnNames, $row['Field']);
    }
    if($columnCount == 4){
        array_push($receivedValues, $_POST['Subtype']);
    }
    if(strpos($row['Field'],' ')) {
        $columnName = str_replace(" ", "", $row['Field']);
        array_push($receivedValues, $_POST[$columnName]);
    }
    else{
        array_push($receivedValues, $_POST[$row['Field']]);
    }
}

print_r($columnNames);
echo "<br>";
print_r($receivedValues);
echo "<br>";

$sql = "UPDATE inventory SET ";
for($count = 0; $count< 3; $count++){
   $sql .= "`" . $columnNames[$count] . "`" . " = '" . $receivedValues[$count]. "' ";
   if($count !== count($columnNames) -1){
       $sql .= ", ";
   }
}
$sql .= "WHERE inv_id = '$inv_id';";

echo "<br> SQL: ".$sql;

//$result = mysqli_query($conn, $sql);
//
//header("Location: ../index.php");

?>