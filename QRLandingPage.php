<style>
    td, th {
        text-align: left;
        padding: 8px;
    }

    th{
        font-family: Arial, Helvetica, sans-serif;
    }

    table.center {
        margin-left:auto;
        margin-right:auto;
    }

    body {
        text-align:center;
    }
</style>

<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>QR Page</Title></head>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $serialNumber = $_GET['show'];
    $name;
    $columnNames = array();

    echo "<br><table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\"><thead>";
//    array_push($columnNames, "Item", "Type", "Subtype", "Checkoutable", "Number in Stock");
//
//    for ($count = 0; $count < count($columnNames); $count++) {
//        echo "<th>$columnNames[$count]</th>";
//    }

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
        if ($innerCount > 3 && $innerCount < 8 || $innerCount > 9) {
            array_push($columnNames, $row['Field']);
        }
    }

    for ($count = 0; $count < count($columnNames); $count++) {
        echo "<th>$columnNames[$count]</th>";
    }
    echo "<th>Show QR Code</th><th>Edit</th><th>Delete</th>";
    echo "</thead><tbody>";

    $sql = "SELECT ";
    for($count = 0; $count < count($columnNames); $count++){
        if($columnNames[$count] == "Type"){
            $sql .= "subtypes.Type, ";
        }
        elseif($count != count($columnNames)-1){
            $sql .= "inventory.`".$columnNames[$count] ."`, ";
        }
        else{
            $sql .= "inventory.`".$columnNames[$count] ."`";
        }
    }
    $sql .= " FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype WHERE `Serial Number` = '".$serialNumber."';";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['Item'];
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

        $sql2 = "SELECT `Number in Stock`, Checkoutable FROM inventory WHERE `Serial Number` = '".$serialNumber."';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        if($row2['Number in Stock'] > 0 && $row2['Checkoutable'] == 1){
            echo "<td><a href='includes/QRcheckout.inc.php?serialNumber=".$row['Serial Number']."'>Check-out<br></td>";
        }

        $sql3 = "SELECT `Serial Number` FROM checkouts WHERE `Serial Number` = '".$serialNumber."' AND `Return Date` IS NULL;";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_num_rows($result3);
        if($row3 > 0 && $row2['Checkoutable'] == 1){
            echo "<td><a href='includes/checkin.inc.php?serialNumber=".$row['Serial Number']."'>Check-in<br></td>";
        }

        echo "<td><a href='QRCode.php?text=".$row['Serial Number']."'>Show QR Code<br></td>
         <td><a href='editInventory.php?edit=".$row['Serial Number']."'>Edit<br></td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td><a href='deleteInventory.php?serialNumber=".$row['Serial Number']."&item=$row[Item]'>Delete<br></td></tr>";
        }
        else{
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
}
else{
    header("Location: ./login.php");
}
include 'tableFooter.php'
?>