<style>
    .center{
        text-align: center;
    }
</style>
<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Broad Inventory Reports</Title></head><body><div class=\"parent\"><button class='help' style='height:27px;' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div><div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    echo "<div class=\"container\"><form class=\"well form-horizontal\" id=\"contact_form\" method='POST'>
        <h2 align=\"center\"> Which dates would you like to report?</h2><br>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Start Date:</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
        <input type='date' class=\"form-control\" name='startDate'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">End Date:</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
        <input type='date' class=\"form-control\" name='endDate'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button name=\"submit\" type=\"submit\" class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
        data-submit=\"...Sending\">Submit</button></div></div></form>
        
        <form style='text-align:center;' action='checkoutsReportExcel.php' method = 'post'>
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <input name=\"export\" type=\"submit\" class=\"btn btn-warning\" value='Export Check-out History (Excel)'>
        </div></div></form><br><br>";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $sql = "SELECT `Activity Type`, `Serial Number`, Item, inventoryReports.Subtype, subtypes.Type, Quantity, Timestamp, `Update Person` FROM inventoryReports JOIN subtypes ON subtypes.Subtype = inventoryReports.Subtype WHERE Timestamp BETWEEN '".$startDate." 00:00:00' AND '".$endDate." 23:59:59';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0) {
            $start = date_create($startDate); //converts string to date
            $end = date_create($endDate);
            echo "<br><h2 class='center'><b>&nbsp&nbspActivities for (".date_format($start, 'm/d/Y')." - ".date_format($end, 'm/d/Y').")</b></h2>

            <br><form style='text-align:center;' action='multiDayInventoryReportsExcel.php' method = 'post'>
                <input type='hidden' name='startDate' value = '$startDate'>
                <input type='hidden' name='endDate' value = '$endDate'>
                <input name=\"export\" type=\"submit\" class=\"btn btn-warning\" value='Export to Excel'></form>
            
            <br><table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
            <thead><tr><th>Activity Type</th>
            <th>Serial Number</th>
            <th>Item</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Quantity Changed</th>
            <th>Timestamp</th>
            <th>Update Person</th></thead><tbody>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td> " . $row['Activity Type'] . "</td>
                <td> " . $row['Serial Number'] . "</td>
                <td> " . $row['Item'] . "</td>
                <td> " . $row['Type'] . "</td>
                <td> " . $row['Subtype'] . "</td>
                <td> " . $row['Quantity'] . "</td>";
                $date = date_create($row['Timestamp']);
                echo "<td>".date_format($date, 'm-d-Y H:i:s')."</td>
                <td> " . $row['Update Person'] . "</td>";
            }
            echo "</tbody></table>";
        }
        else{
            echo "<br><h2 class='center'><b>There are no activities for the dates you selected.";
        }
    }
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>