<style>
    td, th {
        text-align: left;
        padding: 8px;
    }

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
include 'dbh.php';
if(isset($_SESSION['id'])) {
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
    if($type == "" && $serialNumber == "" && $part == "" && $cost == "" && $date == "" && $supplier == "" && $reason == ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchClientsForm.php'> 
                   <input type='submit' value='Search Clients'/>
              </form>";
        exit();
    }
    if($type !== "")
    {
        $sql .= "Type = '".$type."'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($serialNumber !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Serial Number` = '".$serialNumber."'";
        $andNeeded = true;
    }
    if($part !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Part = '".$part."'";
        $andNeeded = true;
    }
    if($cost !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Cost = '".$cost."'";
        $andNeeded = true;
    }
    if($date !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Date = '".$date."'";
        $andNeeded = true;
    }
    if($supplier !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Supplier = '".$supplier."'";
        $andNeeded = true;
    }
    if($reason !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Reason = '".$reason."'";
        $andNeeded = true;
    }
    if($item !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Serial Number` IN (SELECT `Serial Number` FROM inventory WHERE Item = '".$item."')";
    }
    $sql .=";";

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table class='center'><tr><th>Type</th>
            <th>Serial Number</th>
            <th>Item</th>
            <th>Part</th>
            <th>Cost</th>
            <th>Date Performed</th>
            <th>Supplier</th>
            <th>Reason</th></tr>";
        }

        $sql2 = "SELECT Item FROM inventory WHERE `Serial Number` = '".$row['Serial Number']."';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);

        $date = date_create($row['Date']);
        '<td>'.date_format($date, "m/d/Y").'</td>';

        echo "<tr>
              <td> ".$row['Type']."</td>
              <td> ".$row['Serial Number']."</td>
              <td> ".$row2['Item']."</td>
              <td> ".$row['Part']."</td>
              <td> ".$row['Cost']."</td>
              <td> ".date_format($date, 'm/d/Y')."</td>
              <td> ".$row['Supplier']."</td>
              <td> ".$row['Reason']."</td>
              <td> <a href='editRepairUpdateUpgrade.php?edit=$row[Id]'>Edit<br></td>
              <td> <a href='deleteRepairUpdateUpgrade.php?id=$row[Id]&type=$row[Type]&item=$row[Item]'>Delete<br></td>
              </tr><br>";
    }
    if($count == 0) {
        echo "<br> No Items Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}
?>