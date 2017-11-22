<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Users</Title></head><body><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT `Account Type` FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['Account Type'];

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=self') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        You cannot delete yourself.</div><br><br><br>";
        //echo "<br>&nbsp&nbspYou cannot delete yourself.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        New user added successfully.</div><br><br><br>";
        //echo "<br>&nbsp&nbspNew user added successfully.<br>";
    }

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    echo "<h2 style='text-align: center'>Users</h2><br><table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
    <thead><tr><th>First Name</th>
    <th>Last Name</th>
    <th>Account Name</th>
    <th>Email</th>
    <th>Account Type</th>
    <th>Date Added</th>";
    if ($acctType == "Super Admin") {
        echo "<th>Edit</th><th>Delete</th>";
    }
    echo "</tr></thead><tbody>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
    <td> " . $row['First'] . "</td>
    <td> " . $row['Last'] . "</td>
    <td> " . $row['Uid'] . "</td>
    <td> " . $row['Email'] . "</td>
    <td> " . $row['Account Type'] . "</td>";
        $date = date_create($row['Date Added']);
        echo "<td> " . date_format($date, 'm/d/Y') . "</td>";
        if ($acctType == "Super Admin") {
            echo "<td> <a href='editUser.php?edit=$row[Id]'>Edit</a><br></td>
            <td> <a href='deleteUser.php?id=$row[Id]&uid=$row[Uid]'>Delete<br></td>";
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