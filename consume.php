<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Consume</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    error_reporting(E_ALL ^ E_NOTICE);
    $statedTypes = array();
    $getType = $_GET['type'];
    $getType = str_replace("%5C","\\","$getType");
    $getType = str_replace("%27","'","$getType");
    $getSubtype = $_GET['subtype'];
    $getSubtype = str_replace("%5C","\\","$getSubtype");
    $getSubtype = str_replace("%27","'","$getSubtype");
    $getItem = $_GET['item'];
    $getItem = str_replace("%5C","\\","$getItem");
    $getItem = str_replace("%27","'","$getItem");

    $noItem = false;

    $sql = "SELECT CURDATE();";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $date = $row['CURDATE()'];
    $date = date_format(date_create($date), "m/d/Y");

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=over') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        There are not that many of the consumable in stock.</div><br><br><br>";
        //echo "<br>&nbsp&nbspThere are not that many of the item in inventory.<br>";
    }
    elseif(strpos($url, 'error=zero') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        You must consume at least one unit.</div><br><br><br>";
        //echo "<br>&nbsp&nbspYou must consume at least one unit.<br>";
    }
    elseif(strpos($url, 'error=breakMin') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Cannot consume. Consuming that many would go under minimum stock.</div><br><br><br>";
        //echo "<br>&nbsp&nbspCannot consume. Consuming that many would go under the minimum stock.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Item consumed.</div><br><br><br>";
        //echo "<br>&nbsp&nbspItem consumed.<br>";
    }

    $sql = "SELECT Type FROM subtypes WHERE `Table` = 'Consumables';";
    $result = mysqli_query($conn, $sql);

    echo '<br><div class="container">
        <form class="well form-horizontal" style="border-bottom: none;" id="contact_form" method="POST"><fieldset>
        <h2 align="center">Which item would you like to consume?</h2><br>
        <div class="form-group"><label class="col-md-4 control-label">Type:<a style="color:red;" title="This field must be filled">*</a></label>
        <div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>';
        if($getType == NULL){
            echo '<select required name="type" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        else{
            echo '<select disabled name="type" class="form-control selectpicker" onchange="this.form.submit()">';
        }
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
        $getType = str_replace("\\","\\\\","$getType");
        $getType = str_replace("'","\'","$getType");
        $sql = "SELECT Subtype FROM subtypes WHERE Type = '".$getType."';";
        $getType = str_replace("\'","%27","$getType");
        $getType = str_replace("\\\\","%5C","$getType");
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        Subtype:<a style="color:red;" title="This field must be filled">*</a></label><div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>';
        if($getSubtype == NULL) {
            echo '<select required name="subtype" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        else{
            echo '<select disabled name="subtype" class="form-control selectpicker" onchange="this.form.submit()">';
        }
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
        echo '<div class="form-group"><label class="col-md-4 control-label">Subtype:<a style="color:red;" title="This field must be filled">*</a></label>
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a type first</option></select>
            </div></div></div>';
    }

    //start item
    if($getSubtype !== NULL && $getSubtype !== ""){
        $getSubtype = str_replace("\\","\\\\","$getSubtype");
        $getSubtype = str_replace("'","\'","$getSubtype");
        $sql = "SELECT Item FROM consumables WHERE Subtype = '".$getSubtype."';";
        $getSubtype = str_replace("\'","%27","$getSubtype");
        $getSubtype = str_replace("\\\\","%5C","$getSubtype");
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        Item:<a style="color:red;" title="This field must be filled">*</a></label><div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>';
        if(mysqli_num_rows($result) == 0){
            echo '<select disabled name="item" class="form-control selectpicker" onchange="this.form.submit()">';
            $noItem = true;
        }
        else{
            echo '<select name="item" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        if($getItem == NULL){
            if($noItem){
                echo '<option selected value="">No item with that subtype is consumable.</option>';
            }
            else{
                echo '<option selected value=""></option>';
            }
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
        echo '<div class="form-group"><label class="col-md-4 control-label">Item:<a style="color:red;" title="This field must be filled">*</a></label>
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a subtype first</option></select>
            </div></div></div>';
    }

    //Number in Stock
    if($getItem !== NULL && $getItem !== ""){
        $getItem = str_replace("\\","\\\\","$getItem");
        $getItem = str_replace("'","\'","$getItem");
        $sql = "SELECT `Number in Stock` FROM consumables WHERE Item = '".$getItem."';";
        $getItem = str_replace("\'","%27","$getItem");
        $getItem = str_replace("\\\\","%5C","$getItem");
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo '<form action ="includes/consume.inc.php" method="POST">
        <label>
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        <input type="hidden" name="item" value = \''.$getItem. '\'>
        <div class="form-group"><label class="col-md-4 control-label">Number in Stock:<a style="color:red;" title="This field must be filled">*</a></label> 
        <div class="col-md-4 inputGroupContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-question-sign"></i></span>
        <input type="number" required class="form-control" min="0" name="stock" value='.$row['Number in Stock'].'></div></div></div>';
    }
    else{
        echo '<div class="form-group"><label class="col-md-4 control-label">Number in Stock:<a style="color:red;" title="This field must be filled">*</a></label> 
            <div class="col-md-4 inputGroupContainer"><div class="input-group"><span class="input-group-addon">
            <i class="glyphicon glyphicon-question-sign"></i></span>
            <input class="form-control" required type="number" name="quantity" min="0" max="100" step="1" value="0">
            </div></div></div>';
    }

    //Person
    $sql = "SELECT First, Last FROM clients;";
    $result = mysqli_query($conn, $sql);
    echo'<div class="form-group"><label class="col-md-4 control-label">Person:<a style="color:red;" title="This field must be filled">*</a></label>
    <div class="col-md-4 selectContainer"><div class="input-group">
    <span class="input-group-addon"><i class="fa fa-users"></i></span>
    <select name="person" required class="form-control selectpicker"><option selected value=""></option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['First']." ".$row['Last'].'">'.$row['First']." ".$row['Last'].'</option>';
    }
    echo '</select></div></div></div>';

    //Reason & Consume Date
    echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Reason:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-question\" aria-hidden=\"true\"></i></span>
    <input type='text' required placeholder='Reason' name='reason' class=\"form-control\"></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\">Consume Date: <span>".$date."</span></div></div>";

    if($noItem){
        echo "<br><br><div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button disabled type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
        data-submit=\"...Sending\">Consume</button></div></div></form></fieldset></form>";
    }
    else{
        echo "<br><br><div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
        data-submit=\"...Sending\">Consume</button></div></div></form></fieldset></form>";
    }

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