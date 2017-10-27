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
    echo "<head><Title>Search Users Results</Title></head>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $first = $_POST['first'];
    $last = $_POST['last'];
    $accountName = $_POST['accountName'];
    $accountType = $_POST['accountType'];
    $dateAdded = $_POST['dateAdded'];
    $tableHeadNeeded = false;
    $count = 0;
    $sql = "SELECT * FROM users WHERE ";
    $andNeeded = false;
    if($last == "" && $first == "" && $accountName == "" && $accountType == "" && $dateAdded == ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchUsersForm.php'> 
                   <input type='submit' value='Search Users'/>
              </form>";
        exit();
    }
    if($first !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "first = '".$first."'";
        $andNeeded = true;
    }
    if($last !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "last = '".$last."'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }

    if($accountName !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "uid = '".$accountName."'";
        $andNeeded = true;
    }
    if($accountType !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "acctType = '".$accountType."'";
        $andNeeded = true;
    }
    if($dateAdded !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "dateAdded = '".$dateAdded."'";
        $andNeeded = true;
    }
    $sql .=";";
    $result = mysqli_query($conn, $sql);
    echo "<br>";
    $row = mysqli_fetch_array($result);

    if(mysqli_num_rows($result) > 0){
        $count++;
        echo "<table class = 'center'><tr><th>First</th>
        <th>Last</th>
        <th>Account Name</th>
        <th>Account Type</th>
        <th>Date Added</th></tr>";

        echo "<tr><td> ".$row['first']."</td>
              <td> ".$row['last']."</td>
              <td> ".$row['uid']."</td>
              <td> ".$row['acctType']."</td>";
              $date = date_create($row['dateAdded']);
              echo '<td>'.date_format($date, "m/d/Y").'</td>';
        if ($acctType == "Admin") {
            echo "<td> <a href='editUser.php?edit=$row[id]'>Edit</a><br></td>
            <td> <a href='deleteUser.php?id=$row[id]&uid=$row[uid]'>Delete<br></td>";
        }
        echo "</tr></table>";
        }
    if($count == 0) {
        echo "&nbsp&nbsp No Items Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}
?>