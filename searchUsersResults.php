<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head>
              <Title>Search Users Results</Title>
          </head>
          <body>
              <div class=\"parent\">
                  <button class='help' onclick=\"window.location.href='./UserManual.pdf#page=10'\">
                      <i class='fa fa-question'></i>
                  </button>
              </div><br>
              <h2 style='text-align: center'>Users</h2>
              <div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $currentID = $_SESSION['id'];
    $sql = "SELECT `Account Type` FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['Account Type'];

    $first = $_POST['first'];
    $first = str_replace("\\","\\\\\\\\","$first");
    $first = str_replace("'","\'","$first");
    $last = $_POST['last'];
    $last = str_replace("\\","\\\\\\\\","$last");
    $last = str_replace("'","\'","$last");
    $accountName = $_POST['accountName'];
    $accountName = str_replace("\\","\\\\\\\\","$accountName");
    $accountName = str_replace("'","\'","$accountName");
    $email = $_POST['email'];
    $email = str_replace("\\","\\\\\\\\","$email");
    $email = str_replace("'","\'","$email");
    $accountType = $_POST['accountType'];
    $dateAdded = $_POST['dateAdded'];
    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM `users` WHERE ";
    $andNeeded = false;
    if($last == "" && $first == "" && $accountName == "" && $accountType == "" && $dateAdded == ""){
        echo "<h3 style='text-align: center'>Please fill out at least 1 search field.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='searchUsersForm.php';\" class='btn btn-warning' value='Back'>
              </div>";
        exit();
    }
    if($first !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "First LIKE '%".$first."%'";
        $andNeeded = true;
    }
    if($last !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Last LIKE '%".$last."%'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }

    if($accountName !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Uid LIKE '%".$accountName."%'";
        $andNeeded = true;
    }
    if($email !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Email LIKE '%".$email."%'";
        $andNeeded = true;
    }
    if($accountType !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Account Type` LIKE '%".$accountType."%'";
        $andNeeded = true;
    }
    if($dateAdded !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "`Date Added` LIKE '%".$dateAdded."%'";
        $andNeeded = true;
    }
    $sql .=";";
    $result = mysqli_query($conn, $sql);
    echo "<br>";

    while($row = mysqli_fetch_array($result)){
        if($tableHeadNeeded) {
            $tableHeadNeeded = false;
            $count++;
            echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
                      <thead>
                          <tr>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Account Name</th>
                              <th>Email</th>
                              <th>Account Type</th>
                              <th>Date Added</th>";
            if ($acctType == "Super Admin") {
                echo "<th>Edit</th>
                      <th>Delete</th>";
            }
            echo "</tr>
              </thead>
              <tbody>";
        }
        echo "<tr>
                  <td>".$row['First']."</td>
                  <td>".$row['Last']."</td>
                  <td>".$row['Uid']."</td>
                  <td>".$row['Email']."</td>
                  <td>".$row['Account Type']."</td>";
                  $date = date_create($row['Date Added']);
        echo '<td>'.date_format($date, "m/d/Y").'</td>';
        if ($acctType == "Super Admin") {
            echo "<td>
                      <a href='editUser.php?edit=$row[Id]'>Edit</a>
                  </td>
                  <td>
                      <a href='deleteUser.php?id=$row[Id]&uid=$row[Uid]'>Delete</a>
                  </td>";
        }
        echo "</tr>";
    }
    echo "</tbody>
      </table>";

    if($count == 0) {
        echo "<h3 style='text-align: center'>No Users Found That Match All of Those Criteria.</h3><br>
              <div style='text-align: center'>
                  <input onclick=\"window.location.href='searchUsersForm.php';\" class='btn btn-warning' value='Back'>
              </div>";
    }
}
else{
    header("Location: ./login.php");
}
include 'tableFooter.php';
?>