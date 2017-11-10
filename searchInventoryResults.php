<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Inventory Results</Title></head><body><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $columnNames = array();
    $receivedValues = array();
    error_reporting(E_ALL ^ E_NOTICE);

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
            $sql .= "`" . $columnNames[$count] . "`" . " LIKE '%" . $receivedValues[$count]. "%' AND ";
            error_reporting(E_ERROR | E_PARSE);
        }
    }

    $sql = chop($sql," AND ");

    if($_POST['Type'] !== ""){
        $sql .= " AND Subtype IN (SELECT Subtype FROM subtypes WHERE type LIKE '%". $_POST['Type']."%')";
    }

    $sql .= ";";

    if($sql == "SELECT * FROM inventory WHERE;"){ // for if no fields are filled in
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchInventoryForm.php'>
                   <input type='submit' value='Search Inventory'/>
              </form>";
        exit();
    }

    if(strpos($sql, "WHERE AND") !== false){ //for if only type is searched on
        $subtypes = array();
        $typeSql = "SELECT Subtype FROM subtypes WHERE type = '". $_POST['Type']."';";
        $typeResult = mysqli_query($conn, $typeSql);
        while($typeRow = mysqli_fetch_array($typeResult)){
            array_push($subtypes, $typeRow['Subtype']);
        }
        $sql = "SELECT * FROM inventory WHERE Subtype IN (";
        for($count = 0; $count < count($subtypes); $count++){
            if($count !== (count($subtypes)-1)){
                $sql .= "'". $subtypes[$count]. "', ";
            }
            else{
                $sql .= "'". $subtypes[$count]. "'";
            }
        }
        $sql .= ");";
    }

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $outerCount++;
            echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
            <thead>";
            for($count = 0; $count< 2; $count++){
                echo "<th>$columnNames[$count]</th>";
            }
            echo "<th>Type</th>";
            for($count = 2; $count< count($columnNames); $count++){
                echo "<th>$columnNames[$count]</th>";
            }
            echo "<th>Edit</th>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo"<th>Delete</th>";
            }
            echo "</thead><tbody><tr>";
        }
        for($count = 0; $count< count($columnNames); $count++){
            if($count == 1){
                echo '<td> '.$row[$columnNames[$count]].'</td>';
                $innerSQL = "SELECT Type FROM subtypes WHERE Subtype = '".$row[$columnNames[$count + 1]]."';";
                $innerResult = mysqli_query($conn, $innerSQL);
                $innerRow = mysqli_fetch_array($innerResult);
                echo '<td>'. $innerRow['Type'].'</td>';
            }
            else{
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
                elseif($rowType['DATA_TYPE'] == "date"){
                    $date = date_create($row[$columnNames[$count]]);
                    echo '<td>'.date_format($date, "m/d/Y").'</td>';
                }
                else{
                    echo '<td> '.$row[$columnNames[$count]].'</td>';
                }
            }
        }
        echo "<td> <a href='editInventory.php?edit=".$row["Serial Number"]."'>Edit<br></td>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo "<td> <a href='deleteInventory.php?serialNumber=".$row["Serial Number"]."&item=$row[Item]'>Delete<br></td>";
               }
            echo "</tr>";
    }
    echo "</tbody></table>";

    if($outerCount == 0) {
        echo "&nbsp<br> No Items Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>