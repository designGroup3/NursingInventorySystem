<?php
include 'table.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Checkout</Title></head>";

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
    elseif(strpos($url, 'checkin') !== false){
        echo "<br>&nbsp&nbspItem checked-in.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspItem checked-out.<br>";
    }

    $sql = "SELECT Type FROM subtypes WHERE isCheckoutable = '1';";
    $result = mysqli_query($conn, $sql);

    echo '<br><div class="container">
        <form class="well form-horizontal" style="border-bottom: none;" id="contact_form" method="POST"><fieldset>
        <h2 align="center">Which item would you like to checkout?</h2><br>
        <div class="form-group"><label class="col-md-4 control-label">Type:</label>
        <div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
        <select name="type" class="form-control selectpicker" onchange="this.form.submit()">';
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
    echo '</select></div></div></div>';

    //start subtype
    if($getType !== NULL && $getType !== ""){
        $sql = "SELECT Subtype FROM subtypes WHERE Type = '".$getType."';";
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        Subtype: </label><div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
        <select name="subtype" class="form-control selectpicker" onchange="this.form.submit()">';
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
        echo '</select></div></div></div>';
    }
    else{
        //echo '<br>&nbsp&nbspSubtype: <select disabled><option value="">Select a type first</option></select><br>';
        echo '<div class="form-group"><label class="col-md-4 control-label">Subtype: </label>
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a type first</option></select>
            </div></div></div>';
    }

    //start item
    if($getSubtype !== NULL && $getSubtype !== ""){
        $sql = "SELECT Item FROM inventory WHERE Subtype = '".$getSubtype."';";
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        Item: </label><div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
        <select name="item" class="form-control selectpicker" onchange="this.form.submit()">';
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
        echo '</select></form></div></div></div>';
    }
    else{
        //echo '<br>&nbsp&nbspItem: <select disabled><option value="">Select a subtype first</option></select><br>';
        echo '<div class="form-group"><label class="col-md-4 control-label">Type: </label>
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a subtype first</option></select>
            </div></div></div>';
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
        <input type="hidden" name="item" value = \''.$getItem. '\'>
        <div class="form-group"><label class="col-md-4 control-label">Number in Stock:</label>  
        <div class="col-md-4 inputGroupContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-question-sign"></i></span>
        <input type="number" class="form-control" min="0" name="stock" value='.$row['Number in Stock'].'></div></div></div>';
    }
    else{
        //echo '<br>&nbsp&nbspNumber in Stock: <input type="number" min="0" name= "stock" value="0">';
        echo '<div class="form-group"><label class="col-md-4 control-label">Number in Stock:</label>  
            <div class="col-md-4 inputGroupContainer"><div class="input-group"><span class="input-group-addon">
            <i class="glyphicon glyphicon-question-sign"></i></span>
            <input class="form-control" type="number" name="quantity" min="0" max="100" step="1" value="0">
            </div></div></div>';
    }

    //Person
    $sql = "SELECT First, Last FROM clients;";
    $result = mysqli_query($conn, $sql);
    //echo'<br><br>&nbsp&nbspPerson: <select name="person"><option selected value=""></option>';
    echo'<div class="form-group"><label class="col-md-4 control-label">Person:</label>
    <div class="col-md-4 selectContainer"><div class="input-group">
    <span class="input-group-addon"><i class="fa fa-users"></i></span>
    <select name="person" class="form-control selectpicker"><option selected value=""></option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['First']." ".$row['Last'].'">'.$row['First']." ".$row['Last'].'</option>';
    }
    echo '</select></div></div></div>';

    //Reason, Notes, Due Date, Checkout Date
//    echo "<br><br>&nbsp&nbspReason: <input type= 'text' name='reason'>
//    <br><br>&nbsp&nbspNotes: <input type= 'text' name='notes'>
//    <br><br>&nbsp&nbspDue Date: <input type= 'date' name='date'>
//    <br><br>&nbsp&nbspCheckout Date: <span>".date('m/d/Y')."</span>
//    <br><br>&nbsp&nbsp<button type='submit'>Checkout</button></form>";

    echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Reason:</label>  
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-question\" aria-hidden=\"true\"></i></span>
    <input type='text' placeholder='Reason' name='reason' class=\"form-control\"></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Notes:</label>  
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
    <input name=\"notes\" placeholder=\"Notes\" class=\"form-control\" type=\"text\"></div></div></div>

    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Due Date:</label>  
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
    <input name=\"date\" placeholder=\"MM/DD/YY\" class=\"form-control\" type=\"date\"></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\">Checkout Date: <span>".date('m/d/Y')."</span></div></div>
    
    <br><br><div class=\"form - group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
    <button type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
    data-submit=\"...Sending\">Check-out</button></div></div></form></fieldset></form>";

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

    echo "<br><br><h2 style='text-align: center';>Current Checked-Out Inventories</h2><br>";
    echo "<table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\"><thead>";

    echo "<th>Print</th><th>Serial Number</th><th>Item</th><th>Type</th><th>Subtype</th><th>Quantity Borrowed</th><th>Person</th>
    <th>Update Person</th><th>Checkout Date</th><th>Due Date</th><th>Check-In</th></thead>";

//    $results_per_page = 5; //for pagination
//
//    $sql='SELECT * FROM checkouts'; //for pagination
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

    $sql = "SELECT Id, Item, subtypes.Type, checkouts.Subtype, `Quantity Borrowed`, `Serial Number`, Person, `Update Person`, `Checkout Date`, `Due Date` FROM checkouts JOIN subtypes ON checkouts.Subtype = subtypes.Subtype WHERE `Return Date` IS NULL ORDER BY Id;";
    $result = mysqli_query($conn, $sql);
    $namesCount = 0;
    echo "<tbody>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td><a href='printCheckout.php?Id=$row[Id]'>Print<br></td><td>".$row['Serial Number']."</td><td>".$row['Item']."</td><td>".$row['Type']."</td><td>".$row['Subtype']."</td><td>".$row['Quantity Borrowed']."</td>
        <td>".$row['Person']."</td><td>".$row['Update Person']."</td><td>".$row['Checkout Date']."</td><td>".$row['Due Date']."</td>
        <td><a href='includes/checkin.inc.php?serialNumber=".$row['Serial Number']."'>Check-In<br></td></tr>";
    }

    echo "</tbody></table>";

//    echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPage: ";
//    for ($page=1; $page<=$number_of_pages; $page++) {
//        echo '<a href="checkout.php?page=' . $page . '">' . $page . '&nbsp</a> ';
//    }
//    echo "<br><br><br>";
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>