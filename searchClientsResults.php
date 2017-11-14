<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Clients Results</Title></head><body><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div><br><h2 style='text-align: center'>Clients</h2>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $last = $_POST['last'];
    $last = str_replace("'","\'","$last");
    $first = $_POST['first'];
    $first = str_replace("'","\'","$first");
    $ext = $_POST['ext'];
    $email = $_POST['email'];
    $email = str_replace("'","\'","$email");
    $office = $_POST['office'];
    $office = str_replace("'","\'","$office");
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
        $sql .= "Last LIKE '%".$last."%'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($first !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "First LIKE '%".$first."%'";
        $andNeeded = true;
    }
    if($ext !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Ext LIKE '%".$ext."%'";
        $andNeeded = true;
    }
    if($email !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Email LIKE '%".$email."%'";
        $andNeeded = true;
    }
    if($office !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Office LIKE '%".$office."%'";
    }
    $sql .=";";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
            <thead><tr><th>First</th>
            <th>Last</th>
            <th>Ext</th>
            <th>Email</th>
            <th>Office</th>
            <th>Edit</th>";
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo "<th>Delete</th>";
            }
            echo "</tr></thead><tbody>";
        }
        echo "<tr><td> ".$row['First']."</td>
              <td> ".$row['Last']."</td>
              <td> ".$row['Ext']."</td>
              <td> ".$row['Email']."</td>
              <td> ".$row['Office']."</td>
              <td><a href='editClient.php?edit=$row[Number]'>Edit</td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td><a href='deleteClient.php?number=$row[Number]&last=$row[Last]&first=$row[First]'>Delete</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
    if($count == 0) {
        echo "<br> No Clients Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>