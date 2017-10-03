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
    error_reporting(E_ALL ^ E_NOTICE);
    $statedTypes = array();
    $getType = $_GET['type'];
    $getSubtype = $_GET['subtype'];
    $getItem = $_GET['item'];

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=over') !== false){
        echo "<br>&nbsp&nbspThere are not that many of the item in inventory.<br>";
    }
    elseif(strpos($url, 'error=zero') !== false){
        echo "<br>&nbsp&nbspYou must checkout at least one unit.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspItem checked-out.<br>";
    }

    $sql = "SELECT Type FROM subtypes;";
    $result = mysqli_query($conn, $sql);

    echo '<br><p>&nbsp&nbspWhich item would you like to checkout?</p>
    <form method="POST">
    <label>
        <br>&nbsp&nbspType: <select name="type" onchange="this.form.submit()">';
        if($getType == NULL){
            echo '<option selected value=""></option>';
        }
        else{
            echo '<option value=""></option>';
        }
    while ($row = mysqli_fetch_array($result)) {
        if (!in_array($row['Type'], $statedTypes)) {
            if($row['Type'] == $getType){
                echo '<option selected value = "' . $row['Type'] . '">' . $row['Type'] . '</option>';
            }
            else{
                echo '<option value = "' . $row['Type'] . '">' . $row['Type'] . '</option>';
            }
            array_push($statedTypes, $row['Type']);
        }
    }
    echo '</select></label></form>';

    //start subtype
    if($getType !== NULL && $getType !== ""){
        $sql = "SELECT Subtype FROM subtypes WHERE Type = '".$getType."';";
        $result = mysqli_query($conn, $sql);
        echo '<form method="POST">
        <label>
        <input type="hidden" name="type" value = \''.$getType. '\'>';
        echo'<br>&nbsp&nbspSubtype: <select name="subtype" onchange="this.form.submit()">';
        if($getSubtype == NULL){
            echo '<option selected value=""></option>';
        }
        else{
            echo '<option value=""></option>';
        }
        while ($row = mysqli_fetch_array($result)) {
            if($row['Subtype'] == $getSubtype){
                echo '<option selected value = "' . $row['Subtype'] . '">' . $row['Subtype'] . '</option>';
            }
            else{
                echo '<option value = "' . $row['Subtype'] . '">' . $row['Subtype'] . '</option>';
            }
        }
        echo '</select></label></form>';
    }
    else{
        echo '<br>&nbsp&nbspSubtype: <select disabled><option value="">Select a type first</option></select><br>';
    }

    //start item
    if($getSubtype !== NULL && $getSubtype !== ""){
        $sql = "SELECT Item FROM inventory WHERE Subtype = '".$getSubtype."';";
        $result = mysqli_query($conn, $sql);
        echo '<form method="POST">
        <label>
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>';
        echo'<br>&nbsp&nbspItem: <select name="item" onchange="this.form.submit()">';
        if($getItem == NULL){
            echo '<option selected value=""></option>';
        }
        else{
            echo '<option value=""></option>';
        }
        while ($row = mysqli_fetch_array($result)) {
            if($row['Item'] == $getItem){
                echo '<option selected value = "' . $row['Item'] . '">' . $row['Item'] . '</option>';
            }
            else{
                echo '<option value = "' . $row['Item'] . '">' . $row['Item'] . '</option>';
            }
        }
        echo '</select></label></form>';
    }
    else{
        echo '<br>&nbsp&nbspItem: <select disabled><option value="">Select a subtype first</option></select><br>';
    }

    //Number in Stock
    if($getItem !== NULL && $getItem !== ""){
        $sql = "SELECT `Number in Stock` FROM inventory WHERE Item = '".$getItem."';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo '<form action ="includes/checkout.inc.php" method="POST">
        <label>
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        <input type="hidden" name="item" value = \''.$getItem. '\'>';
        echo'<br>&nbsp&nbspNumber in Stock: <input type="number" name= "stock" value='.$row['Number in Stock'].'>';
    }
    else{
        echo'<br>&nbsp&nbspNumber in Stock: <input type="number" name= "stock" value="0">';
    }

    //Person
    $sql = "SELECT First, Last FROM clients;";
    $result = mysqli_query($conn, $sql);
    echo'<br><br>&nbsp&nbspPerson: <select name="person"><option selected value=""></option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['First']." ".$row['Last'].'">'.$row['First']." ".$row['Last'].'</option>';
    }
    echo '</select>';

    //Reason, Notes, Due Date, Checkout Date
    echo "<br><br>&nbsp&nbspReason: <input type= 'text' name='reason'>
    <br><br>&nbsp&nbspNotes: <input type= 'text' name='notes'>
    <br><br>&nbsp&nbspDue Date: <input type= 'date' name='date'>
    <br><br>&nbsp&nbspCheckout Date: <span>".date('m/d/Y')."</span>
    <br><br>&nbsp&nbsp<button type='submit'>Checkout</button></form>";

    //posts
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSubtype == NULL && $getItem == NULL){
        $type = $_POST['type'];
        header("Location: ./checkout.php?type=".$type);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getItem == NULL){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $item = $_POST['item'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype."&item=".$item);
    }

    echo "<br><br>";
    echo "<table class ='inventory'>";

    echo "<th>Item</th><th>Type</th><th>Subtype</th><th>Quantity Borrowed</th><th>Person</th>
    <th>Update Person</th><th>Checkout Date</th><th>Due Date</th>";

    $results_per_page = 5; //for pagination

    $sql='SELECT * FROM checkouts'; //for pagination
    $result = mysqli_query($conn, $sql); //for pagination
    $number_of_results = mysqli_num_rows($result); //for pagination

    $number_of_pages = ceil($number_of_results/$results_per_page); //for pagination

    if (!isset($_GET['page'])) { //for pagination
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page-1)*$results_per_page; //for pagination

    $sql = "SELECT Id, Item, subtypes.Type, checkouts.Subtype, `Quantity Borrowed`, Person, `Update Person`, `Checkout Date`, `Due Date` FROM checkouts JOIN subtypes ON checkouts.Subtype = subtypes.Subtype ORDER BY Id LIMIT " . $this_page_first_result . "," .  $results_per_page.";"; //limit rows shown
    $result = mysqli_query($conn, $sql);
    $namesCount = 0;
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td>".$row['Item']."</td><td>".$row['Type']."</td><td>".$row['Subtype']."</td><td>".$row['Quantity Borrowed']."</td>
        <td>".$row['Person']."</td><td>".$row['Update Person']."</td><td>".$row['Checkout Date']."</td><td>".$row['Due Date']."</td></tr>";
    }

    echo "</table>";

    echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPage: ";
    for ($page=1; $page<=$number_of_pages; $page++) {
        echo '<a href="checkout.php?page=' . $page . '">' . $page . '&nbsp</a> ';
    }
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>