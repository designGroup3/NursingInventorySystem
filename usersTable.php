<?php

include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=self') !== false){
        echo "<br>&nbsp&nbspYou cannot delete yourself.<br>";
    }

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    echo "<table cellspacing='10'><tr><th>First Name</th>
    <th>Last Name</th>
    <th>Account Name</th>
    <th>Date Added</th>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
            <td> " . $row['first'] . "</td>
            <td> " . $row['last'] . "</td>
            <td> " . $row['uid'] . "</td>";
            $date = date_create($row['dateAdded']);
            echo "<td> " . date_format($date, 'm/d/Y') . "</td>
            <td> <a href='editUser.php?edit=$row[id]'>Edit</a><br></td>
            <td> <a href='deleteUser.php?id=$row[id]&uid=$row[uid]'>Delete<br></td>
        </tr>";
    }
}
?>