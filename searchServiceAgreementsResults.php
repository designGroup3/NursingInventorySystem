<style>
    td, th {
        text-align: left;
        padding: 8px;
    }
</style>

<?php
include 'header.php';
include 'dbh.php';
if(isset($_SESSION['id'])) {
    error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $duration = $_POST['duration'];
    $date = $_POST['date'];

    $image = addslashes(file_get_contents($_FILES['form']['tmp_name']));

    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM serviceAgreements WHERE ";
    $andNeeded = false;
    if($name == "" && $cost == "" && $duration == "" && $date == "" && $image== ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchServiceAgreementsForm.php'> 
                   <input type='submit' value='Search Service Agreements'/>
              </form>";
        exit();
    }
    if($name !== "")
    {
        $sql .= "Name = '".$name."'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($cost !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Annual Cost` = '".$cost."'";
        $andNeeded = true;
    }
    if($duration !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Duration = '".$duration."'";
        $andNeeded = true;
    }
    if($date !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Expiration Date` = '".$date."'";
        $andNeeded = true;
    }
    if($image !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Approval = '".$image."'";
    }
    $sql .=";";

    $result = mysqli_query($conn, $sql);
    echo "<br>";
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table><tr><th>Name</th>
            <th>Annual Cost</th>
            <th>Duration</th>
            <th>Expiration Date</th></tr>";
        }
        echo "<tr><td> " . $row['Name'] . "</td>
            <td> " . $row['Annual Cost'] . "</td>
            <td> " . $row['Duration'] . "</td>";
        $date = date_create($row['Expiration Date']);
        echo "<td> " . date_format($date, 'm/d/Y') . "</td>
            <td> <a href='approvalForm.php?id=$row[Id]'>Show Approval Form</a><br></td>";
        if ($acctType == "Admin") {
            echo "<td> <a href='editServiceAgreement.php?edit=$row[Id]'>Edit</a><br></td>
            <td> <a href='deleteServiceAgreement.php?id=$row[Id]&name=$row[Name]'>Delete<br></td>";
        }
        echo "</tr>";
    }
    if($count == 0) {
        echo "<br> No Service Agreements Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}
?>