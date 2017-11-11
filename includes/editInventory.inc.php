<?php
session_start();

include '../dbh.php';

$originalSerialNumber = $_POST['originalSerialNumber'];
$originalSubtype = $_POST['originalSubtype'];
$originalType = $_POST['originalType'];
$type = $_POST['type'];
$inventoryColumns = array();
$inventoryValues = array();

if(isset($_SESSION['id'])) {
    error_reporting(E_ALL ^ E_NOTICE);
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    $columnTypes = array();

    $sqlTime = "SELECT CURRENT_TIMESTAMP;"; //get current time
    $resultTime = mysqli_query($conn, $sqlTime);
    $rowTime = $resultTime->fetch_assoc();
    $time = $rowTime['CURRENT_TIMESTAMP'];

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

    for ($count = 0; $count < count($inventoryColumns); $count++) {
        $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_name = 'inventory' AND COLUMN_NAME = '$inventoryColumns[$count]';";
        $result2 = mysqli_query($conn, $sql2);
        $rowType = mysqli_fetch_array($result2);
        array_push($columnTypes, $rowType['DATA_TYPE']);
    }

    $serialNumbers = array();

    $sql = "SELECT `Serial Number` FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($serialNumbers, $row['Serial Number']);
    }

    if(in_array($inventoryValues[0], $serialNumbers) && $inventoryValues[0] !== $originalSerialNumber){
        header("Location: ../editInventory.php?edit=$originalSerialNumber&error=exists");
        exit();
    }

    $sql = "UPDATE inventory SET ";
    for($count = 0; $count< count($inventoryColumns); $count++){
        if ($count < 9) {
            $sql .= "`" . $inventoryColumns[$count] . "` = '".$inventoryValues[$count]."'";
        }
        elseif($count === 9){
            $sql .= "`Last Processing Date` = '" .$time."'";
        }
        elseif($count === 10){
            $sql .= "`Last Processing Person` = '" .$uid."'";
        }
        else {
            if($columnTypes[$count] !== "tinyint"){
                $sql .= "`".$inventoryColumns[$count]."` = '".$inventoryValues[$count]."'";
            }
            else{
                if($inventoryValues[$count] !== ""){
                    $sql .= "`".$inventoryColumns[$count]."` = '".$inventoryValues[$count]."'";
                }
                else{
                    $sql .= "`".$inventoryColumns[$count]."` = NULL";
                }
            }
        }
        if($count != (count($inventoryColumns)-1)){
            $sql .= ", ";
        }
    }

    $sql .= " WHERE `Serial Number` = '$originalSerialNumber';";

    //Check Subtypes table
    if($originalSubtype !== $_POST['Subtype'] || $originalType !== $type){
        if($originalType !== $type && $originalSubtype == $_POST['Subtype']){ //type is changed
            $TypeSql = "UPDATE subtypes SET Type = '$type' WHERE Subtype = '$originalSubtype';";
            $TypeResult = mysqli_query($conn, $TypeSql);
        }
        elseif($originalSubtype !== $_POST['Subtype'] && $originalType == $type){ //subtype is changed
            $newSubtype = $_POST['Subtype'];
            $typeSQL = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
            $typeResult = mysqli_query($conn, $typeSQL);
            $row = mysqli_fetch_array($typeResult);
            if($row['Type'] !== $type){
                if(mysqli_num_rows($typeResult) == 0){
                    $createSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "', 'Inventory');";
                    $createResult = mysqli_query($conn, $createSql);
                }
                else{
                    $typeSQL = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
                    $typeResult = mysqli_query($conn, $typeSQL);
                    $row = mysqli_fetch_array($typeResult);
                    $existingType = $row['Type'];
                    header("Location: ../editInventory.php?edit=$originalSerialNumber&error=typeMismatch&subtype=$newSubtype&type=$existingType");
                    exit();
                }
            }

            $subtypeSql = "SELECT Item FROM inventory WHERE Subtype = '$originalSubtype';";
            $subtypeResult = mysqli_query($conn, $subtypeSql);
            if(mysqli_num_rows($subtypeResult) == 1){ //If the only item with that subtype has its subtype changed, change the subtype in the subtypes table.
//                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
//                $subtypeResult = mysqli_query($conn, $subtypeSql);
                $subtypeSql = "UPDATE subtypes SET Subtype = '$newSubtype' WHERE Subtype = '$originalSubtype';";
                //echo $subtypeSql;
                $subtypeResult = mysqli_query($conn, $subtypeSql);
            }
            else{
                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
                $subtypeResult = mysqli_query($conn, $subtypeSql);
                if(mysqli_num_rows($subtypeResult) == 0){ //If no subtype exists for the subtype entered
                    $subtypeSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "', 'Inventory');";
                    //echo $subtypeSql;
                    $subtypeResult = mysqli_query($conn, $subtypeSql);
                }
            }
        }
        elseif($originalSubtype !== $_POST['Subtype'] && $originalType !== $type){
            $newSubtype = $_POST['Subtype'];

            $subtypeSql = "SELECT Item FROM inventory WHERE Subtype = '$originalSubtype';";
            $subtypeResult = mysqli_query($conn, $subtypeSql);
            if(mysqli_num_rows($subtypeResult) == 1){ //If the only item with that subtype has its subtype changed, change the subtype in the subtypes table.
//                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
//                $subtypeResult = mysqli_query($conn, $subtypeSql);
                $subtypeSql = "UPDATE subtypes SET Subtype = '$newSubtype' WHERE Subtype = '$originalSubtype';";
                //echo $subtypeSql;
                $subtypeResult = mysqli_query($conn, $subtypeSql);
            }
            else{
                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
                $subtypeResult = mysqli_query($conn, $subtypeSql);
                if(mysqli_num_rows($subtypeResult) == 0){ //If no subtype exists for the subtype entered
                    $subtypeSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "', 'Inventory');";
                    //echo $subtypeSql;
                    $subtypeResult = mysqli_query($conn, $subtypeSql);
                }
            }
            $TypeSql = "UPDATE subtypes SET Type = '$type' WHERE Subtype = '$newSubtype';";
            $TypeResult = mysqli_query($conn, $TypeSql);
        }
    }

    //Reports
    $reportSql = "INSERT INTO reports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Edit Inventory',";

    $reportSql .= "'" . $inventoryValues[1] . "'" . ", ";
    $reportSql .= "'" . $inventoryValues[2] . "'" . ", ";

    //Get old quantity
    $sql2 = "SELECT `Number in Stock` FROM inventory WHERE `Item` = '".$inventoryValues[1]."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $current_quantity = $row2['Number in Stock'];

    $quantity = $inventoryValues[6] - $current_quantity;
    $reportSql .= $quantity .", ";

    $reportSql .= "'" . $time . "'" . ", ";
    $reportSql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql); // Can't be executed until prior quantity is gotten

    $subtypeSql = "SELECT * FROM inventory WHERE Subtype = '$originalSubtype';";
    $subtypeResult = mysqli_query($conn, $subtypeSql);
    $row = mysqli_fetch_array($subtypeResult);
    if(mysqli_num_rows($subtypeResult) == 0){
        $subtypeSql = "DELETE FROM subtypes WHERE Subtype = '$originalSubtype';";
        $subtypeResult = mysqli_query($conn, $subtypeSql);
    }

    $result = mysqli_query($conn, $reportSql);

    header("Location: ../inventory.php");
}
else{
    header("Location: ./login.php");
}
?>