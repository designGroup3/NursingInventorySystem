<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Repairs/Updates/Upgrades Results</Title></head><body><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $type = $_POST['type'];
    $serialNumber = $_POST['serialNumber'];
    $item = $_POST['item'];
    $part = $_POST['part'];
    $cost = $_POST['cost'];
    $date = $_POST['date'];
    $supplier = $_POST['supplier'];
    $reason = $_POST['reason'];
    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM `repairs/updates/upgrades` WHERE ";
    $andNeeded = false;
    if($type == "" && $serialNumber == "" && $item == "" && $part == "" && $cost == "" && $date == "" && $supplier == "" && $reason == ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchRepairsUpdatesUpgradesForm.php'> 
                   <input type='submit' value='Search Repairs/Updates/Upgrades'/>
              </form>";
        exit();
    }
    if($type !== "")
    {
        $sql .= "Type LIKE '%".$type."%'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($serialNumber !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Serial Number` LIKE '%".$serialNumber."%'";
        $andNeeded = true;
    }
    if($part !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Part LIKE '%".$part."%'";
        $andNeeded = true;
    }
    if($cost !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Cost LIKE '%".$cost."%'";
        $andNeeded = true;
    }
    if($date !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Date LIKE '%".$date."%'";
        $andNeeded = true;
    }
    if($supplier !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Supplier LIKE '%".$supplier."%'";
        $andNeeded = true;
    }
    if($reason !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Reason LIKE '%".$reason."%'";
        $andNeeded = true;
    }
    if($item !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Item LIKE '%".$item."%'";
    }
    $sql .=";";

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
            <thead><tr><th>Type</th>
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
        }

//        $sql2 = "SELECT Item FROM inventory WHERE `Serial Number` = '".$row['Serial Number']."';";
//        $result2 = mysqli_query($conn, $sql2);
//        $row2 = mysqli_fetch_array($result2);
//
        $date = date_create($row['Date']);
//        '<td>'.date_format($date, "m/d/Y").'</td>';

        echo "<tr><td> ".$row['Type']."</td>
              <td> ".$row['Serial Number']."</td>
              <td> ".$row['Item']."</td>
              <td> ".$row['Part']."</td>
              <td> ".$row['Cost']."</td>
              <td> ".date_format($date, 'm/d/Y')."</td>
              <td> ".$row['Supplier']."</td>
              <td> ".$row['Reason']."</td>
              <td> <a href='editRepairUpdateUpgrade.php?edit=$row[Id]'>Edit<br></td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td> <a href='deleteRepairUpdateUpgrade.php?id=$row[Id]&type=$row[Type]&item=$row[Item]'>Delete<br></td>";
        }
              echo "</tr><br>";
    }
    echo "</tbody></table>";

    if($count == 0) {
        echo "<br> No Items Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>