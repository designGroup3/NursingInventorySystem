<style>
    td, th {
        text-align: left;
        padding: 8px;
    }

    table.center {
        margin-left:auto;
        margin-right:auto;
    }

    body {
        text-align:center;
    }

    th{
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<?php
//include 'includes/bootstrap.inc.php';
include 'header.php';
include 'dbh.php';

$columnNames= array();
$Minimums = array();

$minimumSQL = "SELECT `Minimum Stock` FROM consumables"; //Gets each item's Minimum Stock separately since that isn't its own row.
$minimumResult = mysqli_query($conn, $minimumSQL);
while ($minimumRow = mysqli_fetch_array($minimumResult)) {
    array_push($Minimums, $minimumRow['Minimum Stock']);
}

if(isset($_SESSION['id'])) {
    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    echo "<br>";
    echo "<table class ='center'>";

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

    $results_per_page = 5; //for pagination

    $sql='SELECT * FROM consumables'; //for pagination
    $result = mysqli_query($conn, $sql); //for pagination
    $number_of_results = mysqli_num_rows($result); //for pagination

    $number_of_pages = ceil($number_of_results/$results_per_page); //for pagination

    if (!isset($_GET['page'])) { //for pagination
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page-1)*$results_per_page; //for pagination

    //array_push($columnNames, "Item", "Type", "Subtype", "Number in Stock");

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

        $sql = "SELECT Item, consumables.Subtype, subtypes.Type FROM consumables JOIN subtypes ON consumables.Subtype = subtypes.Subtype ORDER BY Item LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //limit rows shown //display first three columns
        $result = mysqli_query($conn, $sql);

        $IDs = array();
        $sqlColumns = "SELECT Item FROM consumables LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //limit rows shown"; //needed to show later columns
        $columnResult = mysqli_query($conn, $sqlColumns);
        while($columnRow = mysqli_fetch_array($columnResult)){
            array_push($IDs, $columnRow['Item']);
        }
        $columnNumber = 0;

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            for ($innerCount = 0; $innerCount < 3; $innerCount++) {
                echo '<td> ' . $row[$columnNames[$innerCount]] . '</td>';
            }

            $sql2 = "SELECT * FROM consumables WHERE Item = '".$IDs[$columnNumber]."';"; //display later columns
            $result2 = mysqli_query($conn, $sql2);

            while ($row2 = mysqli_fetch_array($result2)) {
                for($whileCount = 3; $whileCount < count($columnNames); $whileCount++){
                    $sql3 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$whileCount]';";
                    $result3 = mysqli_query($conn, $sql3);
                    $rowType = mysqli_fetch_array($result3);
                    if($rowType['DATA_TYPE'] == "tinyint"){
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
                    if($columnNames[$whileCount] === "Number in Stock"){
                        echo '<td style="text-align:center"> '.$row2[$columnNames[$whileCount]].' ('.$row2['Minimum Stock'].')</td>';
                    }
                    elseif($columnNames[$whileCount] === "Minimum Stock"){
                        //Show nothing since the previous column already shows it.
                    }
                    else{
                        echo '<td> '.$row2[$columnNames[$whileCount]].'</td>';
                    }
                }
            }

//    $sql = "SELECT Item, consumables.Subtype, subtypes.Type, `Number in Stock` FROM consumables JOIN subtypes ON consumables.Subtype = subtypes.Subtype ORDER BY Item LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //limit rows shown
//    $result = mysqli_query($conn, $sql);
//    $namesCount = 0;
//    while ($row = mysqli_fetch_array($result)) {
//        echo "<tr>";
//        for ($whileCount = 0; $whileCount < count($columnNames); $whileCount++) {
//            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
//                    WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$whileCount]';";
//            $result2 = mysqli_query($conn, $sql2);
//            $rowType = mysqli_fetch_array($result2);
//            if ($rowType['DATA_TYPE'] == "tinyint") {
//                if ($row[$columnNames[$whileCount]] == 0 && $row[$columnNames[$whileCount]] !== null) {
//                    echo '<td>No</td>';
//                } elseif ($row[$columnNames[$whileCount]] !== null) {
//                    echo '<td>Yes</td>';
//                } else {
//                    echo '<td></td>';
//                }
//            } else {
//                if($columnNames[$whileCount] === "Number in Stock"){
//                    echo '<td> ' . $row[$columnNames[$whileCount]] . ' (' . $Minimums[($namesCount + (($page-1)*$results_per_page))].')</td>';
//                }
//                else{
//                    echo '<td> ' . $row[$columnNames[$whileCount]] . '</td>';
//                }
//            }
//        }
//        $namesCount++;
        echo "<td> <a href='editConsumable.php?edit=$row[Item]'>Edit<br></td>";
            if ($acctType == "Admin") {
                echo "<td> <a href='deleteConsumable.php?item=$row[Item]'>Delete<br></td></tr>";
            }
            else{
                echo "</tr>";
            }

            $columnNumber++;
        }

    echo "&nbsp&nbsp<form action='addConsumable.php'>
               <input type='submit' value='Add Consumable'/>
              </form>";

    echo "&nbsp&nbsp<form action='searchConsumablesForm.php'>
               <input type='submit' value='Search Consumables'/>
              </form>";

    echo "&nbsp&nbsp<form action='consume.php'>
                   <input type='submit' value='Consume'/>
                  </form>";

    if ($acctType == "Admin") {
        echo "&nbsp&nbsp<form action='addConsumableColumn.php'>
               <input type='submit' value='Add Column'/>
              </form>";

        echo "&nbsp&nbsp<form action='editConsumableColumn.php'>
               <input type='submit' value='Edit Column'/>
              </form>";

        echo "&nbsp&nbsp<form action='deleteConsumableColumn.php'>
               <input type='submit' value='Delete Column'/>
              </form>";
    }

    echo "</table>";

    echo "<br>Page: ";
    for ($page=1; $page<=$number_of_pages; $page++) {
        echo '<a href="consumables.php?page=' . $page . '">' . $page . '&nbsp</a> ';
    }

} else {
    header("Location: ./login.php");
}
?>