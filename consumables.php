<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head>
              <Title>Consumables</Title>
          </head>
          <body>
              <div class=\"parent\">
                  <button class=\"help\" onclick=\"window.location.href='./UserManual.pdf#page=14'\">
                      <i class='fa fa-question'></i>
                  </button>
              </div>
              <div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'deleteSuccess') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Column deleted successfully.</div><br><br><br><br>";
    }

    $columnNames= array();
    $Minimums = array();

    $minimumSQL = "SELECT `Minimum Stock` FROM consumables"; //Gets each item's Minimum Stock separately since that isn't its own row.
    $minimumResult = mysqli_query($conn, $minimumSQL);
    while ($minimumRow = mysqli_fetch_array($minimumResult)) {
        array_push($Minimums, $minimumRow['Minimum Stock']);
    }

    $currentID = $_SESSION['id'];
    $sql = "SELECT `Account Type` FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['Account Type'];

    if ($acctType == "Super Admin") {
        echo "<h2 style='text-align: center'>Consumables</h2><br>
              <table style=\"margin-left:auto; margin-right:auto;\">
                  <td>
                      <form action='addConsumableColumn.php'>
                          <input class=\"btn btn-warning\" type='submit' value='Add Column'/>
                      </form>
                  </td>";

        $columnSql = "SHOW COLUMNS FROM consumables;";
        $columnResult = mysqli_query($conn, $columnSql);

        if(mysqli_num_rows($columnResult) > 7) {
            echo "<td>
                      <form action='editConsumableColumn.php'>
                          <input class=\"btn btn-warning\" type='submit' value='Edit Column'/>
                      </form>
                  </td>
                  <td>
                      <form action='deleteConsumableColumn.php'>
                          <input class=\"btn btn-warning\" type='submit' value='Delete Column'/>
                      </form>
                  </td>";
        }
        echo "</table>";
    }

    echo "<br><table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
                  <thead>";

        $sql = "SHOW COLUMNS FROM consumables"; //gets first headers for page
        $result = mysqli_query($conn, $sql);
        $innerCount = 0;
        while ($row = mysqli_fetch_array($result)) {
            if ($innerCount < 2) {
                $innerCount++;
                array_push($columnNames, $row['Field']);
            }
        }
        array_push($columnNames,"Type"); //from Subtype table
        $sql = "SHOW COLUMNS FROM consumables"; //gets second headers for page
        $result = mysqli_query($conn, $sql);
        $innerCount = 0;
        while ($row = mysqli_fetch_array($result)) {
            $innerCount++;
            if ($innerCount > 2 && $innerCount < 6 || $innerCount > 7) {
                array_push($columnNames, $row['Field']);
            }
        }

    for ($count = 0; $count < count($columnNames); $count++) {
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
    echo "</thead>";

        $sql = "SELECT Item, consumables.Subtype, subtypes.Type FROM consumables JOIN subtypes ON consumables.Subtype = subtypes.Subtype ORDER BY Item;";//display first three columns
        $result = mysqli_query($conn, $sql);

        $IDs = array();
        $sqlColumns = "SELECT Item FROM consumables;"; //needed to show later columns
        $columnResult = mysqli_query($conn, $sqlColumns);
        while($columnRow = mysqli_fetch_array($columnResult)){
            array_push($IDs, $columnRow['Item']);
        }
        $columnNumber = 0;

        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            for ($innerCount = 0; $innerCount < 3; $innerCount++) {
                echo '<td> ' . $row[$columnNames[$innerCount]] . '</td>';
            }

            $IDs[$columnNumber] = str_replace("\\","\\\\","$IDs[$columnNumber]");
            $IDs[$columnNumber] = str_replace("'","\'","$IDs[$columnNumber]");
            $sql2 = "SELECT * FROM consumables WHERE Item = '".$IDs[$columnNumber]."';"; //display later columns
            $result2 = mysqli_query($conn, $sql2);

            while ($row2 = mysqli_fetch_array($result2)) {
                for($whileCount = 3; $whileCount < count($columnNames); $whileCount++){
                    $sql3 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$whileCount]';";
                    $result3 = mysqli_query($conn, $sql3);
                    $rowType = mysqli_fetch_array($result3);
                    if($columnNames[$whileCount] === "Number in Stock"){
                        echo '<td style="text-align:center"> '.$row2[$columnNames[$whileCount]].' ('.$row2['Minimum Stock'].')</td>';
                    }
                    elseif($columnNames[$whileCount] === "Minimum Stock"){
                        //Show nothing since the previous column already shows it.
                    }
                    elseif($rowType['DATA_TYPE'] == "tinyint"){
                        if($row2[$columnNames[$whileCount]] == 0 && $row2[$columnNames[$whileCount]] !== null){
                            echo '<td>No</td>';
                        }
                        elseif($row2[$columnNames[$whileCount]] !== null){
                            echo '<td>Yes</td>';
                        }
                        else{
                            echo '<td></td>';
                        }
                    }
                    else{
                        echo '<td>'.$row2[$columnNames[$whileCount]].'</td>';
                    }
                }
            }

        $item = str_replace("\\","%5C","$row[Item]");
        $item = str_replace("'","%27","$item");
        echo "<td>
                  <a href='editConsumable.php?edit=$item'>Edit<br>
              </td>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo "<td>
                          <a href='deleteConsumable.php?item=$item'>Delete<br>
                      </td>
                  </tr>";
            }
            else{
                echo "</tr>";
            }
            $columnNumber++;
        }

    echo "</tbody>
      </table>";

} else {
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>