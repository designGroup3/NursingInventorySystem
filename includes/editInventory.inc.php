<?php
session_start();

include '../dbh.php';

$id = $_POST['id'];
$originalSubtype = $_POST['originalSubtype'];
$originalSubtype = str_replace("%5C","\\","$originalSubtype");
$originalSubtype = str_replace("%27","\'","$originalSubtype");
$originalType = $_POST['originalType'];
$type = $_POST['type'];
$type = str_replace("\\","\\\\","$type");
$type = str_replace("'","\'","$type");
$inventoryColumns = array();
$inventoryValues = array();
$subtype;

if(isset($_SESSION['id'])) {
    error_reporting(E_ALL ^ E_NOTICE);
    $currentID = $_SESSION['id'];
    $sql = "SELECT Uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['Uid'];

    $sql = "SELECT * FROM inventory WHERE `Inv Id` = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $originalSerialNumber = $row['Serial Number'];
    $originalSerialNumber = str_replace("\\","\\\\","$originalSerialNumber");
    $originalSerialNumber = str_replace("'","\'","$originalSerialNumber");

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

    $checkoutSql = "SELECT * FROM Checkouts WHERE `Serial Number` = '$originalSerialNumber' AND `Return Date` IS NULL;";
    $checkoutResult = mysqli_query($conn, $checkoutSql);
    $checkoutRow = mysqli_fetch_array($checkoutResult);
    $checkoutSerial = $checkoutRow['Serial Number'];

    if($inventoryValues[1] !== $originalSerialNumber && $originalSerialNumber == $checkoutSerial){
        header("Location: ../editInventory.php?edit=$id&error=checkoutSerial");
        exit();
    }

    if(in_array($inventoryValues[1], $serialNumbers) && $inventoryValues[1] !== $originalSerialNumber && $inventoryValues[1] !== ""){
        header("Location: ../editInventory.php?edit=$id&error=exists");
        exit();
    }

    if($inventoryValues[1] !== "" && $inventoryValues[7] > 1){
        header("Location: ../editInventory.php?edit=$id&error=manySerial");
        exit();
    }

    if($inventoryValues[1] == "" && $inventoryValues[6] == 1){
        header("Location: ../editInventory.php?edit=$id&error=noSerial");
        exit();
    }

    $sql = "UPDATE inventory SET ";
    for($count = 1; $count< count($inventoryColumns); $count++){
        if ($count < 10) {
            $inventoryValues[$count] = str_replace("\\","\\\\","$inventoryValues[$count]");
            $inventoryValues[$count] = str_replace("'","\'","$inventoryValues[$count]");
            $sql .= "`" . $inventoryColumns[$count] . "` = '".$inventoryValues[$count]."'";
        }
        elseif($count === 10){
            $sql .= "`Last Processing Date` = '" .$time."'";
        }
        elseif($count === 11){
            $sql .= "`Last Processing Person` = '" .$uid."'";
        }
        else {
            if($columnTypes[$count] !== "tinyint"){
                $inventoryValues[$count] = str_replace("\\","\\\\","$inventoryValues[$count]");
                $inventoryValues[$count] = str_replace("'","\'","$inventoryValues[$count]");
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
    $subtype = $inventoryValues[3];

    $sql .= " WHERE `Inv Id` = '$id';";

    //Check Subtypes table
    if($originalSubtype !== $subtype || $originalType !== $type){
        if($originalType !== $type && $originalSubtype == $subtype){ //type is changed
            $TypeSql = "UPDATE subtypes SET Type = '$type' WHERE Subtype = '$originalSubtype';";
            $TypeResult = mysqli_query($conn, $TypeSql);
        }
        elseif($originalSubtype !== $subtype && $originalType == $type){ //subtype is changed
            $newSubtype = $subtype;
            $typeSQL = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
            $typeResult = mysqli_query($conn, $typeSQL);
            $row = mysqli_fetch_array($typeResult);
            if($row['Type'] !== $type){
                if(mysqli_num_rows($typeResult) == 0){
                    $subSql = "SELECT Subtype FROM subtypes WHERE Subtype = '$newSubtype' AND `Table` = 'Consumables';";
                    $subResult2 = mysqli_query($conn, $subSql);
                    if(mysqli_num_rows($subResult2) > 0){
                        header("Location: ../editInventory.php?edit=$id&error=sameType&subtype=$newSubtype");
                        exit();
                    }
                    $createSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "', 'Inventory');";
                    $createResult = mysqli_query($conn, $createSql);
                }
                else{
                    $typeSQL = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
                    $typeResult = mysqli_query($conn, $typeSQL);
                    $row = mysqli_fetch_array($typeResult);
                    $existingType = $row['Type'];
                    header("Location: ../editInventory.php?edit=$id&error=typeMismatch&subtype=$newSubtype&type=$existingType");
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
        elseif($originalSubtype !== $subtype && $originalType !== $type){
            $newSubtype = $subtype;

            $subtypeSql = "SELECT Item FROM inventory WHERE Subtype = '$originalSubtype' AND `Table` = 'Inventory';";
            $subtypeResult = mysqli_query($conn, $subtypeSql);
            if(mysqli_num_rows($subtypeResult) == 1){ //If the only item with that subtype has its subtype changed, change the subtype in the subtypes table.
                $subtypeSql = "UPDATE subtypes SET Subtype = '$newSubtype' WHERE Subtype = '$originalSubtype';";
                $subtypeResult = mysqli_query($conn, $subtypeSql);
            }
            else{
                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype' AND `TABLE` = 'Inventory';";
                $subtypeResult = mysqli_query($conn, $subtypeSql);
                if(mysqli_num_rows($subtypeResult) == 0){ //If no subtype exists for the subtype entered
                    $subSql = "SELECT Subtype FROM subtypes WHERE Subtype = '$newSubtype' AND `Table` = 'Consumables';";
                    $subResult2 = mysqli_query($conn, $subSql);
                    if(mysqli_num_rows($subResult2) > 0){
                        header("Location: ../editInventory.php?edit=$id&error=sameType&subtype=$newSubtype");
                        exit();
                    }
                    $subtypeSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "', 'Inventory');";
                    $subtypeResult = mysqli_query($conn, $subtypeSql);
                }
            }
            $TypeSql = "UPDATE subtypes SET Type = '$type' WHERE Subtype = '$newSubtype';";
            $TypeResult = mysqli_query($conn, $TypeSql);
        }
    }

    //Reports
    $reportSql = "INSERT INTO inventoryReports (`Activity Type`, `Serial Number`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Edit Inventory',";

    $reportSql .= "'" . $inventoryValues[1] . "'" . ", ";
    $reportSql .= "'" . $inventoryValues[2] . "'" . ", ";
    $reportSql .= "'" . $inventoryValues[3] . "'" . ", ";

    //Get old quantity
    $sql2 = "SELECT `Number in Stock` FROM inventory WHERE `Inv Id` = '".$id."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $current_quantity = $row2['Number in Stock'];

    $quantity = $inventoryValues[7] - $current_quantity;
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

    //Update Repairs/Updates/Upgrades
    if($inventoryValues[1] !== $originalSerialNumber){
        $sql = "UPDATE `repairs/updates/upgrades` SET `Serial Number` = '$inventoryValues[1]' WHERE `Serial Number` = '$originalSerialNumber';";
        $result = mysqli_query($conn, $sql);
    }

    header("Location: ../inventory.php");
}
else{
    header("Location: ./login.php");
}
?>