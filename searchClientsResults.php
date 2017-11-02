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
    echo "<head><Title>Search Clients Results</Title></head>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $last = $_POST['last'];
    $first = $_POST['first'];
    $ext = $_POST['ext'];
    $email = $_POST['email'];
    $office = $_POST['office'];
    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM clients WHERE ";
    $andNeeded = false;
    if($last == "" && $first == "" && $ext == "" && $email == "" && $office == ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchClientsForm.php'> 
                   <input type='submit' value='Search Clients'/>
              </form>";
        exit();
    }
    if($last !== "")
    {
        $sql .= "Last = '".$last."'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($first !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "First = '".$first."'";
        $andNeeded = true;
    }
    if($ext !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Ext = '".$ext."'";
        $andNeeded = true;
    }
    if($email !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Email = '".$email."'";
        $andNeeded = true;
    }
    if($office !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Office = '".$office."'";
    }
    $sql .=";";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table class='table'><tr><th>Last</th>
            <th>First</th>
            <th>Ext</th>
            <th>Email</th>
            <th>Office</th></tr>";
        }
        echo "<tr>
              <td> ".$row['Last']."</td>
              <td> ".$row['First']."</td>
              <td> ".$row['Ext']."</td>
              <td> ".$row['Email']."</td>
              <td> ".$row['Office']."</td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td> <a href='editClient.php?edit=$row[Number]'>Edit<br></td>
              <td> <a href='deleteClient.php?number=$row[Number]&last=$row[Last]&first=$row[First]'>Delete<br></td>";
        }
              echo "</tr><br>";
    }
    if($count == 0) {
        echo "<br> No Clients Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}
?>