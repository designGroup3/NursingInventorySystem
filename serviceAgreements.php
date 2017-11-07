<?php
    include 'table.php';
?>

<table style="margin-left:auto; margin-right:auto;">
    <td><form style='text-align: center;' action='addServiceAgreement.php'>
        <input type='submit' value='Add Service Agreement'/>
        </form></td>

    <td><form style='text-align: center;' action='searchServiceAgreementsForm.php'>
        <input type='submit' value='Search Service Agreements'/>
        </form></td>
    </table>
<?php
if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Service Agreements</Title></head>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $sql = "SELECT * FROM serviceAgreements WHERE Approval IS NOT NULL;";
    $result = mysqli_query($conn, $sql);
    $numServiceAgreements = mysqli_num_rows($result);
    echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
    <thead><tr><th>Name</th>
    <th>Annual Cost</th>
    <th>Duration</th>
    <th>Expiration Date</th>";
    if($numServiceAgreements > 0){
        echo "<th>Approval Form</th>";
    }
    if ($acctType == "Admin" || $acctType == "Super Admin") {
        echo "<th>Edit</th><th>Delete</th>";
    }
    echo "</tr></thead><tbody>";

    $sql = "SELECT * FROM serviceAgreements;";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td> " . $row['Name'] . "</td>
            <td> $" . $row['Annual Cost'] . "</td>
            <td> " . $row['Duration'] . "</td>";
            $date = date_create($row['Expiration Date']);
            echo "<td> " . date_format($date, 'm/d/Y') . "</td>";
            if($row['Approval'] !== NULL){
                echo "<td><a href='serviceAgreements/$row[Id].pdf'>Approval Form</a></td>";
            }
            else{
                echo "<td></td>";
            }
            if ($acctType == "Admin" || $acctType == "Super Admin") {
                echo "<td> <a href='editServiceAgreement.php?edit=$row[Id]'>Edit</a><br></td>
                <td> <a href='deleteServiceAgreement.php?id=$row[Id]&name=$row[Name]'>Delete<br></td>";
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