<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head>
              <Title>Search Inventory Results</Title>
          </head>
          <body>
              <div class=\"parent\">
                  <button class='help' onclick=\"window.location.href='./UserManual.pdf#page=50'\">
                      <i class='fa fa-question'></i>
                  </button>
              </div><br>
              <h2 style='text-align: center'>Inventory</h2>
              <div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT `Account Type` FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['Account Type'];

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

    for($count = 1; $count< count($columnNames); $count++){
        if($receivedValues[$count] !== ""){
            $receivedValues[$count] = str_replace("\\","\\\\\\\\","$receivedValues[$count]");
            $receivedValues[$count] = str_replace("%5C","\\\\\\\\","$receivedValues[$count]");
            $receivedValues[$count] = str_replace("'","\'","$receivedValues[$count]");
            $receivedValues[$count] = str_replace("%27","\'","$receivedValues[$count]");
            $sql .= "`" . $columnNames[$count] . "`" . " LIKE '%" . $receivedValues[$count]. "%' AND ";
            error_reporting(E_ERROR | E_PARSE);
        }
    }

    $sql = chop($sql," AND ");

    if($_POST['Type'] !== ""){
        $type = str_replace("%5C","\\\\\\\\","$_POST[Type]");
        $type = str_replace("%27","\'","$_POST[Type]");
        $sql .= " AND Subtype IN (SELECT Subtype FROM subtypes WHERE type LIKE '%". $type."%')";
    }

    $sql .= ";";

    if($sql == "SELECT * FROM inventory WHERE;"){ // for if no fields are filled in
        echo "<h3 style='text-align: center'>Please fill out at least 1 search field.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='searchInventoryForm.php';\" class='btn btn-warning' value='Back'>
              </div>";
        exit();
    }

    if(strpos($sql, "WHERE AND") !== false){ //for if only type is searched on
        $subtypes = array();
        $type = str_replace("%5C","\\\\\\\\","$_POST[Type]");
        $type = str_replace("%27","\'","$_POST[Type]");
        $typeSql = "SELECT Subtype FROM subtypes WHERE type = '". $type."';";
        $typeResult = mysqli_query($conn, $typeSql);
        while($typeRow = mysqli_fetch_array($typeResult)){
            array_push($subtypes, $typeRow['Subtype']);
        }
        for($count = 0; $count < count($subtypes); $count++){
            $subtypes[$count] = str_replace("\\","\\\\\\\\","$subtypes[$count]");
            $subtypes[$count] = str_replace("'","\'","$subtypes[$count]");
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
            echo "<th>Item</th>
                  <th>Type</th>
                  <th>Subtype</th>
                  <th>Serial Number</th>";
            for($count = 4; $count< count($columnNames); $count++){
                echo "<th>$columnNames[$count]</th>";
            }
            echo "<th>Print QR Code</th>
                  <th>Edit</th>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo"<th>Delete</th>";
            }
            echo "</thead>
                  <tbody>
                      <tr>";
        }

        echo '<td>'.$row['Item'].'</td>';
              $subtype = $row['Subtype'];
              $subtype = str_replace("\\","\\\\\\\\","$subtype");
              $subtype = str_replace("'","\'","$subtype");
              $innerSQL = "SELECT Type FROM subtypes WHERE Subtype = '".$subtype."';";
              $innerResult = mysqli_query($conn, $innerSQL);
              $innerRow = mysqli_fetch_array($innerResult);
              echo '<td>'. $innerRow['Type'].'</td>
                    <td>'.$row['Subtype'].'</td>
                    <td>'.$row['Serial Number'].'</td>';

        for($count = 4; $count< count($columnNames); $count++){
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if($rowType['DATA_TYPE'] == "tinyint"){
                if($row[$columnNames[$count]] == 0 && $row[$columnNames[$count]] !== NULL){
                    echo '<td>No</td>';
                } elseif ($row[$columnNames[$count]] !== null) {
                    echo '<td>Yes</td>';
                } else {
                    echo '<td></td>';
                }
            }
            elseif($rowType['DATA_TYPE'] == "date"){
                $date = date_create($row[$columnNames[$count]]);
                echo '<td>'.date_format($date, "m/d/Y").'</td>';
            }
            else{
                echo '<td>'.$row[$columnNames[$count]].'</td>';
            }
        }
        echo "<td>
                  <a href='QRPrintPage.php?id=".$row["Inv Id"]."'>Print QR Code
              </td>
              <td>
                  <a href='editInventory.php?edit=".$row["Inv Id"]."'>Edit
              </td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td>
                      <a href='deleteInventory.php?delete=".$row["Inv Id"]."'>Delete
                  </td>
              </tr>";
        }
        else{
            echo "</tr>";
        }
    }
    echo "</tbody>
      </table>";

    if($outerCount == 0) {
        echo "<h3 style='text-align: center'>No Items Found That Match All of Those Criteria.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='searchInventoryForm.php';\" class='btn btn-warning' value='Back'>
              </div>";
    }
}
else{
    header("Location: ./login.php");
}
include 'tableFooter.php';
?>