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

	if(isset($_SESSION['id'])) {
        echo "<br>";
        echo "<table class ='inventory'>";

//        $sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
//        $result = mysqli_query($conn, $sql);
//        $innerCount = 0;
//        while ($row = mysqli_fetch_array($result)) {
//            if ($innerCount < 2) {
//                $innerCount++;
//                array_push($columnNames, $row['Field']);
//            }
//        }
//        array_push($columnNames,"Type"); //from Subtype table
//        $sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
//        $result = mysqli_query($conn, $sql);
//        $innerCount = 0;
//        while ($row = mysqli_fetch_array($result)) {
//            $innerCount++;
//            if ($innerCount > 2) {
//                array_push($columnNames, $row['Field']);
//            }
//        }

        array_push($columnNames, "Item", "Type", "Subtype", "Checkoutable", "Number in Stock (Minimum)");

        for ($count = 0; $count < count($columnNames); $count++) {
            echo "<th>$columnNames[$count]</th>";
        }

//        $sql = "SELECT inv_id, Item, inventory.Subtype, subtypes.Type FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype ORDER BY inv_id"; //display first four columns
//        $result = mysqli_query($conn, $sql);
//
//        $IDs = array();
//        $sqlColumns = "SELECT inv_id FROM inventory"; //needed to show later columns if inv_id skips
//        $columnResult = mysqli_query($conn, $sqlColumns);
//        while($columnRow = mysqli_fetch_array($columnResult)){
//            array_push($IDs, $columnRow['inv_id']);
//        }
//        $columnNumber = 0;
//
//        while ($row = mysqli_fetch_array($result)) {
//            echo "<tr>";
//            for($innerCount = 0; $innerCount <4; $innerCount++){
//                echo '<td> ' . $row[$columnNames[$innerCount]] . '</td>';
//            }
//
//            $sql2 = "SELECT * FROM inventory WHERE inv_id = " . $IDs[$columnNumber]; //display later columns
//            $result2 = mysqli_query($conn, $sql2);
//
//            while ($row2 = mysqli_fetch_array($result2)) {
//                for($whileCount = 4; $whileCount < count($columnNames); $whileCount++){
//                    $sql3 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
//                    WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$whileCount]';";
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
        $results_per_page = 5;

        $sql='SELECT * FROM inventory';
        $result = mysqli_query($conn, $sql);
        $number_of_results = mysqli_num_rows($result); //gets row count, like COUNT(*) in SQL.

        $number_of_pages = ceil($number_of_results/$results_per_page);

        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $this_page_first_result = ($page-1)*$results_per_page;



        $sql = "SELECT inv_id, Item, inventory.Subtype, subtypes.Type, Checkoutable, `Number in Stock (Minimum)` FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype ORDER BY inv_id LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //display first four columns
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            for ($whileCount = 0; $whileCount < count($columnNames); $whileCount++) {
                $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$whileCount]';";
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
                    echo '<td> ' . $row[$columnNames[$whileCount]] . '</td>';
                }

            }

            echo "<td> <a href='QRCode.php?text=$row[inv_id]'>Show QR Code<br></td>
                    <td> <a href='editInventory.php?edit=$row[inv_id]'>Edit<br></td>
                   <td> <a href='deleteInventory.php?id=$row[inv_id]&item=$row[Item]'>Delete<br></td></tr>";
        }
//            $columnNumber++;

        echo "&nbsp&nbsp<form action='usersTable.php'>
               <input type='submit' value='See Users'/>
              </form>";

        echo "&nbsp&nbsp<form action='newPassword.php'>
                   <input type='submit' value='Change My Password'/>
                  </form>";

        echo "&nbsp&nbsp<form action='addColumn.php'>
               <input type='submit' value='Add Column'/>
              </form>";

        echo "&nbsp&nbsp<form action='addSubtype.php'>
               <input type='submit' value='Add Subtype'/>
              </form>";

        echo "&nbsp&nbsp<form action='editSubtype.php'>
               <input type='submit' value='Edit Subtype'/>
              </form>";

        echo "&nbsp&nbsp<form action='deleteSubtype.php'>
               <input type='submit' value='Delete Subtype'/>
              </form>";

        echo "&nbsp&nbsp<form action='editType.php'>
               <input type='submit' value='Edit Type'/>
              </form>";

        echo "</table>";

        echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPage: ";
        for ($page=1; $page<=$number_of_pages; $page++) {
            echo '<a href="index.php?page=' . $page . '">' . $page . '&nbsp</a> ';
        }

    } else {
        $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($url, 'error=input') !== false){
            echo "<br> &nbsp Your username or password is incorrect!";
        } else {
            echo "<br> &nbsp Welcome to the PHP System! Please log in or create an account.";
            echo '<br><br>&nbsp<img src="http://www.pngall.com/wp-content/uploads/2016/07/Success-Free-Download-PNG.png"
            width="280" height="125" title="Logo of a company" alt="Logo of a company"/>';
        }
    }
?>