<style>
    table.center {
        margin-left:auto;
        margin-right:auto;
    }

    th{
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        text-align:center;
    }
</style>

<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Repairs/Updates/Upgrades</Title></head>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $sql = "SELECT * FROM `repairs/updates/upgrades` JOIN inventory ON inventory.`Serial Number` = `repairs/updates/upgrades`. `Serial Number`;";
    $result = mysqli_query($conn, $sql);
    echo "<table class='center' cellspacing='10'><tr><th>Type</th>
    <th>Serial Number</th>
    <th>Item</th>
    <th>Part</th>
    <th>Cost</th>
    <th>Date Performed</th>
    <th>Supplier</th>
    <th>Reason</th>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
            <td> " . $row['Type'] . "</td>
            <td> " . $row['Serial Number'] . "</td>
            <td> " . $row['Item'] . "</td>
            <td> " . $row['Part'] . "</td>
            <td> $" . $row['Cost'] . "</td>";
            $date = date_create($row['Date']);
            echo "<td> " . date_format($date, 'm/d/Y') . "</td>
            <td> " . $row['Supplier'] . "</td>
            <td> " . $row['Reason'] . "</td>";
            if ($acctType == "Admin") {
            echo "<td> <a href='editRepairUpdateUpgrade.php?edit=$row[Id]'>Edit</a><br></td>
            <td> <a href='deleteRepairUpdateUpgrade.php?id=$row[Id]&type=$row[Type]&item=$row[Item]'>Delete<br></td>";
            }
        echo "</tr>";
    }
    echo "&nbsp&nbsp<br><br><form action='addRepairUpdateUpgrade.php'>
           &nbsp&nbsp<input type='submit' value='Add Repair/Update/Upgrade'/>
          </form>";

    echo "&nbsp&nbsp<form action='searchRepairsUpdatesUpgradesForm.php'>
               &nbsp&nbsp<input type='submit' value='Search Repairs/Updates/Upgrades'/>
              </form>";

    echo "</table>";
}
?>