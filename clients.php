<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head>
              <Title>Clients</Title>
          </head>
          <body>
              <div class=\"parent\">
                  <button class=\"help\" onclick=\"window.location.href='./UserManual.pdf#page=16'\">
                      <i class='fa fa-question'></i>
                  </button>
              </div>
              <div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $columnNames= array();

    $currentID = $_SESSION['id'];
    $sql = "SELECT `Account Type` FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['Account Type'];

    echo "<h2 style='text-align: center'>Clients</h2><br>
              <table style=\"margin-left:auto; margin-right:auto;\">
                  <td>
                      <form action='addClient.php'>
                          <input class=\"btn btn-warning\" type='submit' value='Add Client'/>
                      </form>
                  </td>";

    echo "<td>
              <form action='searchClientsForm.php'>
                  <input class=\"btn btn-warning\" type='submit' value='Search Clients'/>
              </form>
          </td>
      </table>";

    echo "<br><table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
              <thead>
                  <th>First</th>
                  <th>Last</th>
                  <th>Ext</th>
                  <th>Email</th>
                  <th>Office</th>
                  <th>Edit</th>";

    if ($acctType == "Admin" || $acctType == "Super Admin") {
        echo "<th>Delete</th>";
    }
    echo "</thead>";

    $sql = "SELECT * FROM clients;";
    $result = mysqli_query($conn, $sql);
    echo "<tbody>";
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>
                  <td>'.$row['First'].'</td>'.'
                  <td>'.$row['Last'].'</td>'.'
                  <td>'.$row['Ext'].'
                  <td>'.$row['Email'].'</td>'.'
                  <td>'.$row['Office'].'</td>';
        echo "<td>
                  <a href='editClient.php?edit=$row[Number]'>Edit
              </td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td>
                      <a href='deleteClient.php?number=$row[Number]'>Delete
                  </td>
              </tr>";
        }
    }

    echo "</tbody>
      </table>";

} else {
    header("Location: ./login.php");
}
include 'tableFooter.php';
?>