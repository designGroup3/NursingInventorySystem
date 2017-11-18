<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Repairs/Updates/Upgrades</Title></head><body><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    echo "<h2 style='text-align: center'>Repairs/Updates/Upgrades</h2><br><table style=\"margin-left:auto; margin-right:auto;\">
        <td><form action='addRepairUpdateUpgrade.php'>
           &nbsp&nbsp<input class=\"btn btn-warning\" type='submit' value='Add Repair/Update/Upgrade'/>
          </form></td>";

    echo "<td><form action='searchRepairsUpdatesUpgradesForm.php'>
               &nbsp&nbsp<input class=\"btn btn-warning\" type='submit' value='Search Repairs/Updates/Upgrades'/>
              </form></td></table>";


    $sql = "SELECT * FROM `repairs/updates/upgrades` JOIN inventory ON inventory.`Serial Number` = `repairs/updates/upgrades`.`Serial Number`;";
    $result = mysqli_query($conn, $sql);
    echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\"><thead>
    <tr><th>Type</th>
    <th>Serial Number</th>
    <th>Item</th>
    <th>Part</th>
    <th>Cost</th>
    <th>Date Performed</th>
    <th>Supplier</th>
    <th>Reason</th>
    <th>Edit</th>";
    if ($acctType == "Admin" || $acctType == "Super Admin") {
        echo "<th>Delete</th>";
    }
    echo "</tr></thead><tbody>";
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
            <td> " . $row['Reason'] . "</td>
            <td><a href='editRepairUpdateUpgrade.php?edit=$row[Id]'>Edit</a></td>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td><a href='deleteRepairUpdateUpgrade.php?id=$row[Id]&type=$row[Type]&item=$row[Item]'>Delete</td>";
            }
        echo "</tr>";
    }
    echo "</tbody></table>";
}
else {
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>