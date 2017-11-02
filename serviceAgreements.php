<style>
    table.center {
        margin-left:auto;
        margin-right:auto;
    }

    body {
        text-align:center;
    }

    th{
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Service Agreements</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=nonImage') !== false){
        echo "<br>&nbsp&nbspApproval forms must be an image file.<br>";
    }

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $sql = "SELECT * FROM serviceAgreements;";
    $result = mysqli_query($conn, $sql);
    echo "<table class='table' cellspacing='10'><tr><th>Name</th>
    <th>Annual Cost</th>
    <th>Duration</th>
    <th>Expiration Date</th>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td> " . $row['Name'] . "</td>
            <td> $" . $row['Annual Cost'] . "</td>
            <td> " . $row['Duration'] . "</td>";
            $date = date_create($row['Expiration Date']);
            echo "<td> " . date_format($date, 'm/d/Y') . "</td>";
            if($row['Approval'] !== NULL){
            echo "<td> <a href='approvalForm.php?id=$row[Id]'>Show Approval Form</a><br></td>";
            }
            if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td> <a href='editServiceAgreement.php?edit=$row[Id]'>Edit</a><br></td>
            <td> <a href='deleteServiceAgreement.php?id=$row[Id]&name=$row[Name]'>Delete<br></td>";
            }
        echo "</tr>";
    }
    echo "&nbsp&nbsp<br><br><form action='addServiceAgreement.php'>
           &nbsp&nbsp<input type='submit' value='Add Service Agreement'/>
          </form>";

    echo "&nbsp&nbsp<form action='searchServiceAgreementsForm.php'>
               &nbsp&nbsp<input type='submit' value='Search Service Agreements'/>
              </form>";

    echo "</table>";
}
else {
    header("Location: ./login.php");
}
?>