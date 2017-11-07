<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Consume</Title></head>";

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
        echo "<br>&nbsp&nbspYou must consume at least one unit.<br>";
    }
    elseif(strpos($url, 'error=breakMin') !== false){
        echo "<br>&nbsp&nbspCannot consume. Consuming that many would go under the minimum stock.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspItem consumed.<br>";
    }

    $sql = "SELECT Type FROM subtypes WHERE isConsumable = '1';";
    $result = mysqli_query($conn, $sql);

    echo '<br><div class="container"><h2 align="center">Which item would you like to checkout?</h2>
        <form class="well form-horizontal" id="contact_form" method="POST">
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
    echo '</select></div></div></div></form>';

    //start subtype
    if($getType !== NULL && $getType !== ""){
        $sql = "SELECT Subtype FROM subtypes WHERE Type = '".$getType."';";
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        Subtype:</label><div class="col-md-4 selectContainer"><div class="input-group">
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
        echo '</select></div></div></div></form>';
    }
    else{
        echo '<form class="well form-horizontal" style="position:relative; bottom:20px;" id="contact_form" method="POST">
            <div class="form-group"><label class="col-md-4 control-label">Subtype: </label>
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a type first</option></select>
            </div></div></div>';
    }

    //start item
    if($getSubtype !== NULL && $getSubtype !== ""){
        $sql = "SELECT Item FROM consumables WHERE Subtype = '".$getSubtype."';";
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
        $sql = "SELECT `Number in Stock` FROM consumables WHERE Item = '".$getItem."';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo '<form action ="includes/consume.inc.php" method="POST">
        <label>
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        <input type="hidden" name="item" value = \''.$getItem. '\'>';
        echo'<br>&nbsp&nbspNumber in Stock: <input type="number" min="0" name= "stock" value='.$row['Number in Stock'].'>';
    }
    else{
        echo'<br>&nbsp&nbspNumber in Stock: <input type="number" min="0" name= "stock" value="0">';
    }

    //Person
    $sql = "SELECT First, Last FROM clients;";
    $result = mysqli_query($conn, $sql);
    echo'<br><br>&nbsp&nbspPerson: <select name="person"><option selected value=""></option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['First']." ".$row['Last'].'">'.$row['First']." ".$row['Last'].'</option>';
    }
    echo '</select>';

    //Reason & Consume Date
    echo "<br><br>&nbsp&nbspReason: <input type= 'text' name='reason'>
    <br><br>&nbsp&nbspConsume Date: <span>".date('m/d/Y')."</span>
    <br><br>&nbsp&nbsp<button type='submit'>Consume</button></form>";

    //posts
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSubtype == NULL && $getItem == NULL){
        $type = $_POST['type'];
        header("Location: ./consume.php?type=".$type);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getItem == NULL){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        header("Location: ./consume.php?type=".$type."&subtype=".$subtype);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $item = $_POST['item'];
        header("Location: ./consume.php?type=".$type."&subtype=".$subtype."&item=".$item);
    }
}
else{
    header("Location: ./login.php");
}
?>