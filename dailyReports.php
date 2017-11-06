<style>
    .center{
        text-align: center;
    }
</style>

<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Daily Reports</Title></head>";

    echo "<form class='center' method='POST'>
        <br>&nbsp&nbspReport Date: <input type= 'date' name='date'>
        <br><br>&nbsp&nbsp<button type='submit'>Submit</button></form>";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $date = $_POST['date'];
        $dateTitle = date_create($date);

        $sql = "SELECT `Activity Type`, Item, reports.Subtype, subtypes.Type, Quantity, Timestamp, `Update Person` FROM reports JOIN subtypes ON subtypes.Subtype = reports.Subtype WHERE Timestamp BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0) {
            echo "<br><h2 class='center'><b>&nbsp&nbspActivities for ".date_format($dateTitle, 'm/d/Y')."</b></h2>

            <br><form class='center' action='dailyReportsExcel.php' method = 'post'>
                <input type='hidden' name='date' value = " .$date.">
                <input type='submit' name ='export' value='Export to Excel'/>
                </form>

            <br><table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
            <thead><tr><th>Activity Type</th>
            <th>Item</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Quantity Changed</th>
            <th>Timestamp</th>
            <th>Update Person</th></tr></thead><tbody>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td> " . $row['Activity Type'] . "</td>
                <td> " . $row['Item'] . "</td>
                <td> " . $row['Type'] . "</td>
                <td> " . $row['Subtype'] . "</td>
                <td> " . $row['Quantity'] . "</td>
                <td> " . $row['Timestamp'] . "</td>
                <td> " . $row['Update Person'] . "</td>";
            }
            echo "</tbody></table>";
        }
        else{
            echo "<br><p>&nbsp&nbspThere are no activities at the date you selected.</p>";
        }
    }
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>