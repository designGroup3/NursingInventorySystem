<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head>
              <Title>Search Consumables Results</Title>
          </head>
          <body>
              <div class=\"parent\">
                  <button class='help' onclick=\"window.location.href='./UserManual.pdf#page=66'\">
                      <i class='fa fa-question'></i>
                  </button>
              </div><br>
              <h2 style='text-align: center'>Consumables</h2>
              <div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT `Account Type` FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['Account Type'];

    $columnNames = array();
    $receivedValues = array();
    error_reporting(E_ALL ^ E_NOTICE);

    $sql="SHOW COLUMNS FROM consumables";
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
    $sql = "SELECT * FROM consumables WHERE ";
    $andNeeded = false;

    for($count = 0; $count< count($columnNames); $count++){
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

    if($sql == "SELECT * FROM consumables WHERE;"){ // for if no fields are filled in
        echo "<h3 style='text-align: center'>Please fill out at least 1 search field.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='searchConsumablesForm.php';\" class='btn btn-warning' value='Back'>
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
        $sql = "SELECT * FROM consumables WHERE Subtype IN (";
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
            for($count = 0; $count< 1; $count++){
                echo "<th>$columnNames[$count]</th>";
            }
            echo "<th>Type</th>";
            for($count = 1; $count< count($columnNames); $count++){
                if($columnNames[$count] === "Number in Stock"){
                    echo "<th>$columnNames[$count] "."(Minimum)"."</th>";
                }
                elseif($columnNames[$count] === "Minimum Stock"){
                    //Show nothing since the previous column already shows it.
                }
                else{
                    echo "<th>$columnNames[$count]</th>";
                }
            }
            echo "<th>Edit</th>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo "<th>Delete</th>";
            }
            echo "</thead>
                  <tbody>
                      <tr>";
        }
        for($count = 0; $count< count($columnNames); $count++){
            if($count == 0){
                echo '<td>'.$row[$columnNames[$count]].'</td>';
                $subtype = $row[$columnNames[$count + 1]];
                $subtype = str_replace("\\","\\\\\\\\","$subtype");
                $subtype = str_replace("'","\'","$subtype");
                $innerSQL = "SELECT Type FROM subtypes WHERE Subtype = '".$subtype."';";
                $innerResult = mysqli_query($conn, $innerSQL);
                $innerRow = mysqli_fetch_array($innerResult);
                echo '<td>'.$innerRow['Type'].'</td>';
            }
            else{
                $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$count]';";
                $result2 = mysqli_query($conn, $sql2);
                while($rowType = mysqli_fetch_array($result2)){
                    if($columnNames[$count] === "Number in Stock"){
                        echo '<td style="text-align:center">'.$row['Number in Stock'].' ('.$row['Minimum Stock'].')</td>';
                    }
                    elseif($columnNames[$count] === "Minimum Stock"){
                        //Show nothing since the previous column already shows it.
                    }
                    elseif($rowType['DATA_TYPE'] == "date" && $row['Last Processing Date'] !== null){
                        $date = date_create($row[$columnNames[$count]]);
                        echo '<td>'.date_format($date, "m/d/Y").'</td>';
                    }
                    else{
                        echo '<td>'.$row[$columnNames[$count]].'</td>';
                    }
                }
            }
        }
        echo "<td>
                  <a href='editConsumable.php?edit=$row[Item]'>Edit
              </td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td>
                      <a href='deleteConsumable.php?item=$row[Item]'>Delete
                  </td>";
        }
        echo "</tr>";
    }
    echo "</tbody>
      </table>";

    if($outerCount == 0) {
        echo "<h3 style='text-align: center'>No Items Found That Match All of Those Criteria.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='searchConsumablesForm.php';\" class='btn btn-warning' value='Back'>
              </div>";
    }
}
else{
    header("Location: ./login.php");
}
include 'tableFooter.php';
?>