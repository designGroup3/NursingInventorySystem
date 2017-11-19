<?php
include 'table.php';
if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Inventory</Title></head><body><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'deleteSuccess') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Column deleted successfully.</div><br><br><br><br>";
        //echo "<br>&nbsp&nbspColumn deleted successfully.<br>";
    }
    elseif(strpos($url, 'editCheckout') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              You cannot edit an item that is currently checked-out.</div><br><br><br><br>";
        //echo "<br>&nbsp&nbspColumn deleted successfully.<br>";
    }
    elseif(strpos($url, 'deleteCheckout') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              You cannot delete an item that is currently checked-out.</div><br><br><br><br>";
        //echo "<br>&nbsp&nbspColumn deleted successfully.<br>";
    }

    $columnNames= array();

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    if ($acctType == "Super Admin") {
        echo "<h2 style='text-align: center'>Inventory</h2><br><table style=\"margin-left:auto; margin-right:auto;\">
        <td><form action='addInventoryColumn.php'>
                   <input class=\"btn btn-warning\" type='submit' value='Add Column'/>
                  </form></td>";

        $columnSql = "SHOW COLUMNS FROM inventory;";
        $columnResult = mysqli_query($conn, $columnSql);

        if(mysqli_num_rows($columnResult) > 12){
            echo "<td><form action='editInventoryColumn.php'>
               <input class=\"btn btn-warning\" type='submit' value='Edit Column'/>
              </form></td>";

            echo "<td><form action='deleteInventoryColumn.php'>
               <input class=\"btn btn-warning\" type='submit' value='Delete Column'/>
              </form></td>";
        }
        echo "</table>";
    }

    echo "<br>";
    echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\"><thead>";

        $sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
        $result = mysqli_query($conn, $sql);
        $innerCount = 0;
        while ($row = mysqli_fetch_array($result)) {
            if ($innerCount < 3) {
                $innerCount++;
                array_push($columnNames, $row['Field']);
            }
        }
        array_push($columnNames,"Type"); //from Subtype table
        $sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
        $result = mysqli_query($conn, $sql);
        $innerCount = 0;
        while ($row = mysqli_fetch_array($result)) {
            $innerCount++;
            if ($innerCount > 3 && $innerCount < 11 || $innerCount > 12) {
                array_push($columnNames, $row['Field']);
            }
        }

//    $results_per_page = 5; //for pagination
//
//    $sql='SELECT * FROM inventory'; //for pagination
//    $result = mysqli_query($conn, $sql); //for pagination
//    $number_of_results = mysqli_num_rows($result); //for pagination
//
//    $number_of_pages = ceil($number_of_results/$results_per_page); //for pagination
//
//    if (!isset($_GET['page'])) { //for pagination
//        $page = 1;
//    } else {
//        $page = $_GET['page'];
//    }
//
//    $this_page_first_result = ($page-1)*$results_per_page; //for pagination

    //array_push($columnNames, "Item", "Type", "Subtype", "Checkoutable", "Number in Stock");

    for ($count = 1; $count < count($columnNames); $count++) {
        echo "<th>$columnNames[$count]</th>";
    }
    echo "<th>Print QR Code</th><th>Edit</th>";
    if ($acctType == "Admin" || $acctType == "Super Admin") {
        echo "<th>Delete</th>";
    }
    echo "</thead><tbody>";

        $sql = "SELECT `Inv Id`, `Serial Number`, Item, inventory.Subtype, subtypes.Type FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype ORDER BY `Inv Id`;"; //display first four columns
        $result = mysqli_query($conn, $sql);

        $IDs = array();
        $sqlColumns = "SELECT `Inv Id` FROM inventory;";
        $columnResult = mysqli_query($conn, $sqlColumns);
        while($columnRow = mysqli_fetch_array($columnResult)){
            array_push($IDs, $columnRow['Inv Id']);
        }

        $columnNumber = 0;

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            for ($innerCount = 1; $innerCount < 5; $innerCount++) {
                echo '<td> ' . $row[$columnNames[$innerCount]] . '</td>';
            }

            $sql2 = "SELECT * FROM inventory WHERE `Inv Id` = '" . $IDs[$columnNumber]."';"; //display later columns
            $result2 = mysqli_query($conn, $sql2);

            while ($row2 = mysqli_fetch_array($result2)) {
                for ($whileCount = 5; $whileCount < count($columnNames); $whileCount++) {
                    $sql3 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$whileCount]';";
                    $result3 = mysqli_query($conn, $sql3);
                    $rowType = mysqli_fetch_array($result3);
                    if ($rowType['DATA_TYPE'] == "tinyint") {
                        if ($row2[$columnNames[$whileCount]] == 0 && $row2[$columnNames[$whileCount]] !== null) {
                            echo '<td>No</td>';
                        } elseif ($row2[$columnNames[$whileCount]] !== null) {
                            echo '<td>Yes</td>';
                        } else {
                            echo '<td></td>';
                        }
                    } else {
                        echo '<td> ' . $row2[$columnNames[$whileCount]] . '</td>';
                    }
                }
//              echo "<td><a href='QRCode.php?text=".$row["Serial Number"]."'>Show QR Code<br></td>
                echo "<td><a href='QRPrintPage.php?id=".$row["Inv Id"]."'>Print QR Code<br></td>
                <td> <a href='editInventory.php?edit=".$row["Inv Id"]."'>Edit<br></td>";
                if ($acctType == "Admin" || $acctType == "Super Admin") {
                    echo "<td><a href='deleteInventory.php?delete=".$row["Inv Id"]."'>Delete<br></td></tr>";
                }
                else{
                    echo "</tr>";
                }
            }
            $columnNumber++;
        }

//
//    $sql = "SELECT `Serial Number`, Item, inventory.Subtype, subtypes.Type, Checkoutable, `Number in Stock` FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype ORDER BY Item LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //limit rows shown
//    $result = mysqli_query($conn, $sql);
//    $namesCount = 0;
//    while ($row = mysqli_fetch_array($result)) {
//        echo "<tr>";
//        for ($whileCount = 0; $whileCount < count($columnNames); $whileCount++) {
//            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
//                    WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$whileCount]';";
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
//                echo '<td> ' . $row[$columnNames[$whileCount]] . '</td>';
//            }
//        }
//        $namesCount++;
//        echo "<td> <a href='QRCode.php?text=".$row["Serial Number"]."'>Show QR Code<br></td>
//                    <td> <a href='editInventory.php?edit=".$row["Serial Number"]."'>Edit<br></td>";
//        if ($acctType == "Admin") {
//            echo "<td> <a href='deleteInventory.php?serialNumber=".$row["Serial Number"]."&item=$row[Item]'>Delete<br></td></tr>";
//        }
//        else{
//            echo "</tr>";
//        }
//    }

//    echo "&nbsp&nbsp<form action='addSubtype.php'>
//               <input type='submit' value='Add Subtype'/>
//              </form>";
//
//    echo "&nbsp&nbsp<form action='editSubtype.php'>
//               <input type='submit' value='Edit Subtype'/>
//              </form>";
//
//    echo "&nbsp&nbsp<form action='deleteSubtype.php'>
//               <input type='submit' value='Delete Subtype'/>
//              </form>";
//
//    echo "&nbsp&nbsp<form action='editType.php'>
//               <input type='submit' value='Edit Type'/>
//              </form>";

    echo "</tbody></table>";

//    echo "<br>Page: ";
//
//    for ($page=1; $page<=$number_of_pages; $page++) {
//        echo '<a href="inventory.php?page=' . $page . '">' . $page . '&nbsp</a> ';
//    }

} else {
    header("Location: ./login.php");
}

include 'tableFooter.php'
?>