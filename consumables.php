<style>
    td, th {
        text-align: left;
        padding: 8px;
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
    echo "<br>";
    echo "<table class ='inventory'>";

//        $sql = "SHOW COLUMNS FROM consumables"; //gets first headers for page
//        $result = mysqli_query($conn, $sql);
//        $innerCount = 0;
//        while ($row = mysqli_fetch_array($result)) {
//            if ($innerCount < 2) {
//                $innerCount++;
//                array_push($columnNames, $row['Field']);
//            }
//        }
//        array_push($columnNames,"Type"); //from Subtype table
//        $sql = "SHOW COLUMNS FROM consumables"; //gets second headers for page
//        $result = mysqli_query($conn, $sql);
//        $innerCount = 0;
//        while ($row = mysqli_fetch_array($result)) {
//            $innerCount++;
//            if ($innerCount > 2) {
//                array_push($columnNames, $row['Field']);
//            }
//        }

    array_push($columnNames, "Item", "Type", "Subtype", "Number in Stock");

    for ($count = 0; $count < count($columnNames); $count++) {
        if($columnNames[$count] === "Number in Stock"){
            echo "<th>$columnNames[$count] "."(Minimum)"."</th>";
        }
        else{
            echo "<th>$columnNames[$count]</th>";
        }
    }

//        $sql = "SELECT id, Item, consumables.Subtype, subtypes.Type FROM consumables JOIN subtypes ON consumables.Subtype = subtypes.Subtype ORDER BY id"; //display first four columns
//        $result = mysqli_query($conn, $sql);
//
//        $IDs = array();
//        $sqlColumns = "SELECT id FROM consumables"; //needed to show later columns if id skips
//        $columnResult = mysqli_query($conn, $sqlColumns);
//        while($columnRow = mysqli_fetch_array($columnResult)){
//            array_push($IDs, $columnRow['id']);
//        }
//        $columnNumber = 0;
//
//        while ($row = mysqli_fetch_array($result)) {
//            echo "<tr>";
//            for($innerCount = 0; $innerCount <4; $innerCount++){
//                echo '<td> ' . $row[$columnNames[$innerCount]] . '</td>';
//            }
//
//            $sql2 = "SELECT * FROM consumables WHERE id = " . $IDs[$columnNumber]; //display later columns
//            $result2 = mysqli_query($conn, $sql2);
//
//            while ($row2 = mysqli_fetch_array($result2)) {
//                for($whileCount = 4; $whileCount < count($columnNames); $whileCount++){
//                    $sql3 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
//                    WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$whileCount]';";
//                    $result3 = mysqli_query($conn, $sql3);
//                    $rowType = mysqli_fetch_array($result3);
//                    if($rowType['DATA_TYPE'] == "tinyint"){
//                        if($row2[$columnNames[$whileCount]] == 0 && $row2[$columnNames[$whileCount]] !== null){
//                            echo '<td>No</td>';
//                        }
//                        elseif($row2[$columnNames[$whileCount]] !== null){
//                            echo '<td>Yes</td>';
//                        }
//                        else{
//                            echo '<td></td>';
//                        }
//                    }
//                    else{
//                        echo '<td> '.$row2[$columnNames[$whileCount]].'</td>';
//                    }
//                }
//            }
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

    $sql = "SELECT id, Item, consumables.Subtype, subtypes.Type, `Number in Stock` FROM consumables JOIN subtypes ON consumables.Subtype = subtypes.Subtype ORDER BY id LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //limit rows shown
    $result = mysqli_query($conn, $sql);
    $namesCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($whileCount = 0; $whileCount < count($columnNames); $whileCount++) {
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$whileCount]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if ($rowType['DATA_TYPE'] == "tinyint") {
                if ($row[$columnNames[$whileCount]] == 0 && $row[$columnNames[$whileCount]] !== null) {
                    echo '<td>No</td>';
                } elseif ($row[$columnNames[$whileCount]] !== null) {
                    echo '<td>Yes</td>';
                } else {
                    echo '<td></td>';
                }
            } else {
                if($columnNames[$whileCount] === "Number in Stock"){
                    echo '<td> ' . $row[$columnNames[$whileCount]] . ' (' . $Minimums[($namesCount + (($page-1)*$results_per_page))].')</td>';
                }
                else{
                    echo '<td> ' . $row[$columnNames[$whileCount]] . '</td>';
                }
            }
        }
        $namesCount++;
        echo "<td> <a href='editConsumable.php?edit=$row[id]'>Edit<br></td>
              <td> <a href='deleteConsumable.php?id=$row[id]&item=$row[Item]'>Delete<br></td></tr>";
    }
//            $columnNumber++;

    echo "&nbsp&nbsp<form action='addConsumable.php'>
               <input type='submit' value='Add Consumable'/>
              </form>";

    echo "&nbsp&nbsp<form action='searchConsumablesForm.php'>
               <input type='submit' value='Search Consumables'/>
              </form>";

    echo "&nbsp&nbsp<form action='addConsumableColumn.php'>
               <input type='submit' value='Add Column'/>
              </form>";

    echo "&nbsp&nbsp<form action='editConsumableColumn.php'>
               <input type='submit' value='Edit Column'/>
              </form>";

    echo "&nbsp&nbsp<form action='deleteConsumableColumn.php'>
               <input type='submit' value='Delete Column'/>
              </form>";

    echo "</table>";

    echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPage: ";
    for ($page=1; $page<=$number_of_pages; $page++) {
        echo '<a href="consumables.php?page=' . $page . '">' . $page . '&nbsp</a> ';
    }

} else {
    echo "Please login to manipluate the database";
}
?>