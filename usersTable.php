<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Users</Title></head>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=self') !== false){
        echo "<br>&nbsp&nbspYou cannot delete yourself.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspNew user added successfully.<br>";
    }

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
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
    <td> " . $row['first'] . "</td>
    <td> " . $row['last'] . "</td>
    <td> " . $row['uid'] . "</td>
    <td> " . $row['email'] . "</td>
    <td> " . $row['acctType'] . "</td>";
        $date = date_create($row['dateAdded']);
        echo "<td> " . date_format($date, 'm/d/Y') . "</td>";
        if ($acctType == "Super Admin") {
            echo "<td> <a href='editUser.php?edit=$row[id]'>Edit</a><br></td>
            <td> <a href='deleteUser.php?id=$row[id]&uid=$row[uid]'>Delete<br></td>";
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