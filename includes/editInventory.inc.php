<?php
session_start();

include '../dbh.php';

$inv_id = $_POST['inv_id'];
$inventoryColumns = array();
$inventoryValues = array();

if(isset($_SESSION['id'])) {
    error_reporting(E_ALL ^ E_NOTICE);
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

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
        if($inventoryColumns[$count] != "Last Processing Date" && $inventoryColumns[$count] != "Last Processing Person") {
            $sql .= "`" . $inventoryColumns[$count] . "`" . " = '" . $inventoryValues[$count] . "' ";
            if ($count !== count($inventoryColumns) - 1) {
                $sql .= ", ";
            }
        }
    }

    $sql .= "WHERE inv_id = '$inv_id';";

    //Reports
    $reportSql = "INSERT INTO reports (`Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Edit Inventory','0',";

    $reportSql .= "'" . $inventoryValues[1] . "'" . ", ";
    $reportSql .= "'" . $inventoryValues[2] . "'" . ", ";

    //Get old quantity
    $sql2 = "SELECT `Number in Stock` FROM inventory WHERE `Item` = '".$inventoryValues[1]."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $current_quantity = $row2['Number in Stock'];

    $quantity = $inventoryValues[7] - $current_quantity;
    $reportSql .= $quantity .", ";

    $sql3 = "SELECT CURRENT_TIMESTAMP;";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = $result3->fetch_assoc();
    $time = $row3['CURRENT_TIMESTAMP'];

    $reportSql .= "'" . $time . "'" . ", ";
    $reportSql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql); // Can't be executed until prior quantity is gotten

    $result = mysqli_query($conn, $reportSql);

    header("Location: ../index.php");
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>