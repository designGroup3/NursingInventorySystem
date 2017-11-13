<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Users Results</Title></head><body><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    $first = $_POST['first'];
    $last = $_POST['last'];
    $accountName = $_POST['accountName'];
    $email = $_POST['email'];
    $accountType = $_POST['accountType'];
    $dateAdded = $_POST['dateAdded'];
    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM `users` WHERE ";
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
        $sql .= "first LIKE '%".$first."%'";
        $andNeeded = true;
    }
    if($last !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "last LIKE '%".$last."%'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }

    if($accountName !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "uid LIKE '%".$accountName."%'";
        $andNeeded = true;
    }
    if($email !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "email LIKE '%".$email."%'";
        $andNeeded = true;
    }
    if($accountType !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "acctType LIKE '%".$accountType."%'";
        $andNeeded = true;
    }
    if($dateAdded !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "dateAdded LIKE '%".$dateAdded."%'";
        $andNeeded = true;
    }
    $sql .=";";
    $result = mysqli_query($conn, $sql);
    echo "<br>";

//    echo $sql;
//    echo "Number: " . mysqli_num_rows($result);

    while($row = mysqli_fetch_array($result)){
        if($tableHeadNeeded) {
            $tableHeadNeeded = false;
            $count++;
            echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
            <thead><tr><th>First Name</th>
            <th>Last Name</th>
            <th>Account Name</th>
            <th>Email</th>
            <th>Account Type</th>
            <th>Date Added</th>";
            if ($acctType == "Super Admin") {
                echo "<th>Edit</th>
                <th>Delete</th>";
            }
            echo "</tr></thead><tbody>";
        }
        echo "<tr><td> ".$row['first']."</td>
              <td> ".$row['last']."</td>
              <td> ".$row['uid']."</td>
              <td> ".$row['email']."</td>
              <td> ".$row['acctType']."</td>";
              $date = date_create($row['dateAdded']);
              echo '<td>'.date_format($date, "m/d/Y").'</td>';
        if ($acctType == "Super Admin") {
            echo "<td> <a href='editUser.php?edit=$row[id]'>Edit</a><br></td>
            <td> <a href='deleteUser.php?id=$row[id]&uid=$row[uid]'>Delete</a><br></td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";

    if($count == 0) {
        echo "&nbsp&nbsp No Users Found That Match All of Those Criteria.<br>";
    }
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>