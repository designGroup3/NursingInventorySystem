<?php
session_start();

include '../dbh.php';

$originalItem = $_POST['originalItem'];
$originalItem = str_replace("%5C","\\","$originalItem");
$originalItem = str_replace("%27","\'","$originalItem");
$originalItem = str_replace("%22","\"","$originalItem");
$originalSubtype = $_POST['originalSubtype'];
$originalSubtype = str_replace("%5C","\\","$originalSubtype");
$originalSubtype = str_replace("%27","\'","$originalSubtype");
$newSubtype = $_POST['Subtype'];
$newSubtype = str_replace("\\","\\\\","$newSubtype");
$newSubtype = str_replace("'","\'","$newSubtype");
$originalType = $_POST['originalType'];
$originalType = str_replace("\\","\\\\","$originalType");
$originalType = str_replace("'","\'","$originalType");
$type = $_POST['type'];
$type = str_replace("\\","\\\\","$type");
$type = str_replace("'","\'","$type");
$consumableColumns = array();
$consumableValues = array();

if(isset($_SESSION['id'])) {
    error_reporting(E_ALL ^ E_NOTICE);
    $currentID = $_SESSION['id'];
    $sql = "SELECT uid FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    $columnTypes = array();

    $sql2 = "SELECT CURRENT_TIMESTAMP;"; //gets current time
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $time = $row2['CURRENT_TIMESTAMP'];

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

    for ($count = 0; $count < count($consumableColumns); $count++) {
        $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_name = 'consumables' AND COLUMN_NAME = '$consumableColumns[$count]';";
        $result2 = mysqli_query($conn, $sql2);
        $rowType = mysqli_fetch_array($result2);
        array_push($columnTypes, $rowType['DATA_TYPE']);
    }

    $items = array();

    $sql = "SELECT `Item` FROM consumables";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($items, $row['Item']);
    }
    $consumableValues[0] = str_replace("\\","\\\\","$consumableValues[0]");
    $consumableValues[0] = str_replace("'","\'","$consumableValues[0]");
    if(in_array($consumableValues[0], $items) && $consumableValues[0] !== $originalItem){
        $originalItem = str_replace("\\\\","%5C","$originalItem");
        $originalItem = str_replace("\'","%27","$originalItem");
        header("Location: ../editConsumable.php?edit=$originalItem&error=exists");
        exit();
    }

    $sql = "UPDATE consumables SET ";
    for($count = 0; $count< count($consumableColumns); $count++){
        if($count == 0){
            $sql .= "`" . $consumableColumns[$count] . "` = '".$consumableValues[$count]."'";
        }
        elseif ($count < 5) {
            $consumableValues[$count] = str_replace("\\","\\\\","$consumableValues[$count]");
            $consumableValues[$count] = str_replace("'","\'","$consumableValues[$count]");
            $sql .= "`" . $consumableColumns[$count] . "` = '".$consumableValues[$count]."'";
        }
        elseif($count === 5){
            $sql .= "`Last Processing Date` = '" .$time."'";
        }
        elseif($count === 6){
            $sql .= "`Last Processing Person` = '" .$uid."'";
        }
        else {
            if($columnTypes[$count] !== "tinyint"){
                $consumableValues[$count] = str_replace("\\","\\\\","$consumableValues[$count]");
                $consumableValues[$count] = str_replace("'","\'","$consumableValues[$count]");
                $sql .= "`".$consumableColumns[$count]."` = '".$consumableValues[$count]."'";
            }
            else{
                if($consumableValues[$count] !== ""){
                    $sql .= "`".$consumableColumns[$count]."` = '".$consumableValues[$count]."'";
                }
                else{
                    $sql .= "`".$consumableColumns[$count]."` = NULL";
                }
            }
        }
        if($count != (count($consumableColumns)-1)){
            $sql .= ", ";
        }
    }

    $sql .= " WHERE `Item` = '$originalItem';";

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
                    $subSql = "SELECT Subtype FROM subtypes WHERE Subtype = '$newSubtype' AND `Table` = 'Consumables';";
                    $subResult2 = mysqli_query($conn, $subSql);
                    if(mysqli_num_rows($subResult2) > 0){
                        header("Location: ../editConsumable.php?edit=$originalItem&error=sameType&subtype=$newSubtype");
                        exit();
                    }
                    $createSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "', 'Consumables');";
                    $createResult = mysqli_query($conn, $createSql);
                }
                else {
                    $typeSQL = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
                    $typeResult = mysqli_query($conn, $typeSQL);
                    $row = mysqli_fetch_array($typeResult);
                    $existingType = $row['Type'];
                    header("Location: ../editConsumable.php?edit=$originalItem&error=typeMismatch&subtype=$newSubtype&type=$existingType");
                    exit();
                }
            }

            $subtypeSql = "SELECT Item FROM consumables WHERE Subtype = '$originalSubtype';";
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
                    $subtypeSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "','Consumables');";
                    //echo $subtypeSql;
                    $subtypeResult = mysqli_query($conn, $subtypeSql);
                }
            }
        }
        elseif($originalSubtype !== $_POST['Subtype'] && $originalType !== $type){
            $subtypeSql = "SELECT Item FROM consumables WHERE Subtype = '$originalSubtype' AND `Table` = 'Consumables';";
            $subtypeResult = mysqli_query($conn, $subtypeSql);
            if(mysqli_num_rows($subtypeResult) == 1){ //If the only item with that subtype has its subtype changed, change the subtype in the subtypes table.
//                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype';";
//                $subtypeResult = mysqli_query($conn, $subtypeSql);
                $subtypeSql = "UPDATE subtypes SET Subtype = '$newSubtype' WHERE Subtype = '$originalSubtype';";
                //echo $subtypeSql;
                $subtypeResult = mysqli_query($conn, $subtypeSql);
            }
            else{
                $subtypeSql = "SELECT * FROM subtypes WHERE Subtype = '$newSubtype' AND `TABLE` = 'Consumables';";
                $subtypeResult = mysqli_query($conn, $subtypeSql);
                if(mysqli_num_rows($subtypeResult) == 0){ //If no subtype exists for the subtype entered
                    $subSql = "SELECT Subtype FROM subtypes WHERE Subtype = '$newSubtype' AND `Table` = 'Inventory';";
                    $subResult2 = mysqli_query($conn, $subSql);
                    if(mysqli_num_rows($subResult2) > 0){
                        header("Location: ../editConsumable.php?edit=$originalItem&error=sameType&subtype=$newSubtype");
                        exit();
                    }
                    $subtypeSql = "INSERT INTO subtypes(`Subtype`, `Type`, `Table`) VALUES ('" . $newSubtype . "','" . $type . "','Consumables');";
                    //echo $subtypeSql;
                    $subtypeResult = mysqli_query($conn, $subtypeSql);
                }
            }
            $TypeSql = "UPDATE subtypes SET Type = '$type' WHERE Subtype = '$newSubtype';";
            $TypeResult = mysqli_query($conn, $TypeSql);
        }
    }

    //Reports
    $reportSql = "INSERT INTO consumableReports (`Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('Edit Consumable',";

    $item = $consumableValues[0];

    $subtype = $consumableValues[1];

    $reportSql .= "'" . $item . "'" . ", ";
    $reportSql .= "'" . $subtype . "'" . ", ";

    //Get old quantity
    $sql2 = "SELECT `Number in Stock` FROM consumables WHERE `Item` = '".$consumableValues[0]."';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $current_quantity = $row2['Number in Stock'];

    $quantity = $consumableValues[3] - $current_quantity;
    $reportSql .= $quantity .", ";

    $sql3 = "SELECT CURRENT_TIMESTAMP;";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = $result3->fetch_assoc();
    $time = $row3['CURRENT_TIMESTAMP'];

    $reportSql .= "'" . $time . "'" . ", ";
    $reportSql .= "'" . $uid . "'" . ");";

    $result = mysqli_query($conn, $sql);

    $subtypeSql = "SELECT * FROM consumables WHERE Subtype = '$originalSubtype';";
    $subtypeResult = mysqli_query($conn, $subtypeSql);
    $row = mysqli_fetch_array($subtypeResult);
    if(mysqli_num_rows($subtypeResult) == 0){
        $subtypeSql = "DELETE FROM subtypes WHERE Subtype = '$originalSubtype';";
        $subtypeResult = mysqli_query($conn, $subtypeSql);
    }

    $result = mysqli_query($conn, $reportSql);

    header("Location: ../consumables.php");
}
else{
    header("Location: ./login.php");
}
?>