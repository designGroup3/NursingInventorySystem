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

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Service Agreements Results</Title></head>";

    error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $duration = $_POST['duration'];
    $date = $_POST['date'];

    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM serviceAgreements WHERE ";
    $andNeeded = false;
    if($name == "" && $cost == "" && $duration == "" && $date == ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchServiceAgreementsForm.php'> 
                   <input type='submit' value='Search Service Agreements'/>
              </form>";
        exit();
    }
    if($name !== "")
    {
        $sql .= "Name LIKE '%".$name."%'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($cost !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Annual Cost` LIKE '%".$cost."%'";
        $andNeeded = true;
    }
    if($duration !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Duration LIKE '%".$duration."%'";
        $andNeeded = true;
    }
    if($date !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Expiration Date` LIKE '%".$date."%'";
        $andNeeded = true;
    }
    $sql .=";";

    $result = mysqli_query($conn, $sql);
    echo "<br>";
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table class = 'table'><tr><th>Name</th>
            <th>Annual Cost</th>
            <th>Duration</th>
            <th>Expiration Date</th></tr>";
        }
        echo "<tr><td> " . $row['Name'] . "</td>
            <td> " . $row['Annual Cost'] . "</td>
            <td> " . $row['Duration'] . "</td>";
        $date = date_create($row['Expiration Date']);
        echo "<td> " . date_format($date, 'm/d/Y') . "</td>
           <!--<td> <a href='approvalForm.php?id=$row[Id]'>Show Approval Form</a><br></td>-->";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td> <a href='editServiceAgreement.php?edit=$row[Id]'>Edit</a><br></td>
            <td> <a href='deleteServiceAgreement.php?id=$row[Id]&name=$row[Name]'>Delete<br></td>";
        }
        echo "</tr>";
    }
    if($count == 0) {
        echo "<br> No Service Agreements Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}
?>