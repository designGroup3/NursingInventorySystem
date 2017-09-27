<style>
    td, th {
        text-align: left;
        padding: 8px;
    }

</style>

<?php

include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    $inv_id = $_GET['show'];
    $columnNames = array();

    echo "<table class ='inventory'>";
    array_push($columnNames, "Item", "Type", "Subtype", "Checkoutable", "Number in Stock", "Minimum Stock");

    for ($count = 0; $count < count($columnNames); $count++) {
        echo "<th>$columnNames[$count]</th>";
    }

    $sql = "SELECT inv_id, Item, inventory.Subtype, subtypes.Type, Checkoutable, `Number in Stock`, `Minimum Stock` FROM inventory JOIN subtypes ON inventory.Subtype = subtypes.Subtype WHERE inv_id = ".$inv_id;
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
}

else{
    header("Location: ./login.php");
}

?>