<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Clients</Title></head><body><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>
<div class=\"container\" style=\"margin: 25px auto;\"><br/>";

    $columnNames= array();

    $currentID = $_SESSION['id'];
    $sql = "SELECT acctType FROM users WHERE id='$currentID'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $acctType = $row['acctType'];

    echo "<table style=\"margin-left:auto; margin-right:auto;\">
            <td><form action='addClient.php'>
               <input class=\"btn btn-warning\" type='submit' value='Add Client'/>
              </form></td>";

    echo "<td><form action='searchClientsForm.php'>
               <input class=\"btn btn-warning\" type='submit' value='Search Clients'/>
              </form></td></table>";

    echo "<br>
    <table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\"><thead>";
    echo "<th>First</th><th>Last</th><th>Ext</th><th>Email</th><th>Office</th><th>Edit</th>";

    if ($acctType == "Admin" || $acctType == "Super Admin") {
        echo "<th>Delete</th>";
    }
    echo "</thead>";

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
    echo "<tbody>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo '<td> ' . $row['First'] . '</td>'.'<td> ' . $row['Last'] . '</td>'.
        '<td> ' . $row['Ext'] . '<td> ' . $row['Email'] . '</td>' .'<td> ' . $row['Office'] . '</td>';
        echo "<td><a href='editClient.php?edit=$row[Number]'>Edit<br></td>";
        if ($acctType == "Admin" || $acctType == "Super Admin") {
            echo "<td><a href='deleteClient.php?number=$row[Number]&last=$row[Last]&first=$row[First]'>Delete<br></td></tr>";
        }
    }

    echo "</tbody></table>";

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

include 'tableFooter.php';
?>