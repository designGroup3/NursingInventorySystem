<?php

include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    echo "<form method='POST'>
        <br>&nbsp&nbspReport Date: <input type= 'date' name='date'>
        <br><br>&nbsp&nbsp<button type='submit'>Submit</button></form>";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $date = $_POST['date'];

        $sql = "SELECT `Activity Type`, Item, reports.Subtype, subtypes.Type, Quantity, Timestamp, `Update Person`, Borrower FROM reports JOIN subtypes ON subtypes.Subtype = reports.Subtype WHERE Timestamp BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0) {
            echo "<br><table cellspacing='15'><tr><th>Activity Type</th>
            <th>Item</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Quantity Changed</th>
            <th>Timestamp</th>
            <th>Update Person</th>
            <th>Borrower</th>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td> " . $row['Activity Type'] . "</td>
                <td> " . $row['Item'] . "</td>
                <td> " . $row['Type'] . "</td>
                <td> " . $row['Subtype'] . "</td>
                <td> " . $row['Quantity'] . "</td>
                <td> " . $row['Timestamp'] . "</td>
                <td> " . $row['Update Person'] . "</td>
                <td> " . $row['Borrower'] . "</td>";
            }
        }
        else{
            echo "<br><p>&nbsp&nbspThere are no activities at the date you selected.</p>";
        }
    }
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>