<style>
    td, th {
        text-align: left;
        padding: 8px;
    }

    table.center {
        margin-left:auto;
        margin-right:auto;
    }

    body {
        text-align:center;
    }

    th{
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    //include 'includes/bootstrap.inc.php';
    include 'dbh.php';

    echo "<head><Title>Clients</Title></head>";

    $columnNames= array();

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    echo "<br>";
    echo "<table class ='table'>";
    echo "<th>Last</th><th>First</th><th>Ext</th><th>Email</th><th>Office</th>";

//    $results_per_page = 5; //for pagination
//
//    $sql='SELECT * FROM clients'; //for pagination
//    $result = mysqli_query($conn, $sql); //for pagination
//    $number_of_results = mysqli_num_rows($result); //for pagination
//
//    $number_of_pages = ceil($number_of_results/$results_per_page); //for pagination
//
//    if (!isset($_GET['page'])) { //for pagination
//        $page = 1;
//    } else {
//        $page = $_GET['page'];
//    }
//
//    $this_page_first_result = ($page-1)*$results_per_page; //for pagination

    $sql = "SELECT * FROM clients;";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo '<td> ' . $row['Last'] . '</td>'.'<td> ' . $row['First'] . '</td>'.
        '<td> ' . $row['Ext'] . '<td> ' . $row['Email'] . '</td>' .'<td> ' . $row['Office'] . '</td>';
        if ($acctType == "Admin") {
            echo "<td> <a href='editClient.php?edit=$row[Number]'>Edit<br></td>
              <td> <a href='deleteClient.php?number=$row[Number]&last=$row[Last]&first=$row[First]'>Delete<br></td></tr>";
        }
    }

    echo "&nbsp&nbsp<form action='addClient.php'>
               <input type='submit' value='Add Client'/>
              </form>";

    echo "&nbsp&nbsp<form action='searchClientsForm.php'>
               <input type='submit' value='Search Clients'/>
              </form>";

    echo "</table>";

//    echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPage: ";
//    for ($page=1; $page<=$number_of_pages; $page++) {
//        echo '<a href="clients.php?page=' . $page . '">' . $page . '&nbsp</a> ';
//    }

} else {
    header("Location: ./login.php");
}
?>