<?php
include 'table.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $sql = "SELECT CURDATE();";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $date = $row['CURDATE()'];
    $date = date_format(date_create($date), "m/d/Y");

    echo "<head><Title>Checkout</Title></head><body><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div><br/>";

    error_reporting(E_ALL ^ E_NOTICE);
    $statedTypes = array();
    $getType = $_GET['type'];
    $getSubtype = $_GET['subtype'];
    $getItem = $_GET['item'];
    $getSerial = $_GET['serial'];

    $noItem = false;

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=over') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        There are not that many of the item in inventory.</div><br><br><br>";
        //echo "<br>&nbsp&nbspThere are not that many of the item in inventory.<br>";
    }
    elseif(strpos($url, 'error=zero') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        You must checkout at least one unit.</div><br><br><br>";
        //echo "<br>&nbsp&nbspYou must checkout at least one unit.<br>";
    }
    elseif(strpos($url, 'checkin') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Item checked-in.</div><br><br><br>";
        //echo "<br>&nbsp&nbspItem checked-in.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Item checked-out.</div><br><br><br>";
        //echo "<br>&nbsp&nbspItem checked-out.<br>";
    }

    $sql = "SELECT Type FROM subtypes WHERE `Table` = 'Inventory';";
    $result = mysqli_query($conn, $sql);

    echo '<br><div class="container">
        <form class="well form-horizontal" id="contact_form" method="POST"><fieldset>
        <h2 align="center">Which item would you like to checkout?</h2><br>
        <div class="form-group"><label class="col-md-4 control-label">Type:
        <a style="color:red;" title="This field must be filled">*</a></label>
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
        $sql = "SELECT Subtype FROM subtypes WHERE Type = '".$getType."';";
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        Subtype:<a style="color:red;" title="This field must be filled">*</a></label> <div class="col-md-4 selectContainer"><div class="input-group">
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
        echo '<div class="form-group"><label class="col-md-4 control-label">Subtype:
            <a style="color:red;" title="This field must be filled">*</a></label>
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a type first</option></select>
            </div></div></div>';
    }

    //start item
    if($getSubtype !== NULL && $getSubtype !== ""){
        $sql = "SELECT DISTINCT Item FROM inventory WHERE Subtype = '".$getSubtype."' AND Checkoutable = '1';";
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

        if($getItem !== NULL && $getItem !== ""){
            echo '<select name="item" disabled class="form-control selectpicker" onchange="this.form.submit()">
                  <option selected value=""></option>';
        }
        else{
            //echo '<select name="item" class="form-control selectpicker" onchange="this.form.submit()">';
            if($noItem){
                echo '<option selected value="">No item with that subtype is checkoutable.</option>';
            }
            else{
                echo '<select name="item" class="form-control selectpicker" onchange="this.form.submit()">
                      <option selected value=""></option>';
            }
        }
//        if($getItem == NULL){
//            if($noItem){
//                echo '<option selected value="">No item with that subtype is checkoutable.</option>';
//            }
//            else{
//                echo '<option selected value=""></option>';
//            }
//        }
//        else{
//            echo '<option value=""></option>';
//        }
        while ($row = mysqli_fetch_array($result)) {
            if($row['Item'] == $getItem){
                echo '<option selected value = "' . $row['Item'] . '">' . $row['Item'] . '</option>';
            }
            else{
                echo '<option value = "' . $row['Item'] . '">' . $row['Item'] . '</option>';
            }
        }
        echo '</select></div></div></div>';
    }
    else{
        echo '<div class="form-group"><label class="col-md-4 control-label">Item:<a style="color:red;" title="This field must be filled">*</a></label> 
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select a subtype first</option></select>
            </div></div></div>';
    }

    //start Serial
    if($getItem !== NULL && $getItem !== ""){
        $sql = "SELECT `Serial Number` FROM inventory WHERE Item = '".$getItem."' AND Checkoutable = '1';";
        $result = mysqli_query($conn, $sql);

        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        <input type="hidden" name="item" value = \''.$getItem. '\'>
        Serial Number:<a style="color:red;" title="This field must be filled">*</a></label><div class="col-md-4 selectContainer"><div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
        <select name="serial" class="form-control selectpicker" onchange="this.form.submit()">
        <option selected value=""></option>';

        while ($row = mysqli_fetch_array($result)) {
            if($getSerial !== NULL && $getSerial !== "" && $getSerial == $row['Serial Number']){
                echo '<option selected value = "' . $row['Serial Number'] . '">' . $row['Serial Number'] . '</option>';
            }
            else{
                echo '<option value = "' . $row['Serial Number'] . '">' . $row['Serial Number'] . '</option>';
            }
        }
        echo '</select></form></div></div></div>';
    }
    else{
        echo '<div class="form-group"><label class="col-md-4 control-label">Serial Number:<a style="color:red;" title="This field must be filled">*</a></label> 
            <div class="col-md-4 selectContainer"><div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
            <select class="form-control selectpicker" disabled><option value="">Select an item first</option></select>
            </div></div></div>';
    }

    //Number in Stock
    if($getItem !== NULL && $getItem !== ""){
        $sql = "SELECT `Number in Stock` FROM inventory WHERE `Serial Number` = '".$getSerial."';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo '<form action ="includes/checkout.inc.php" method="POST"><label>
        <input type="hidden" name="type" value = \''.$getType. '\'>
        <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
        <input type="hidden" name="item" value = \''.$getItem. '\'>
        <input type="hidden" name="serial" value = \''.$getSerial. '\'>
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

    //Reason, Notes, Due Date, Checkout Date
    echo "<div class=\"form-group\"><label class=\"col-md-4 control-label\">Reason:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label> 
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-question\" aria-hidden=\"true\"></i></span>
    <input type='text' required placeholder='Reason' name='reason' class=\"form-control\"></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Notes:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label> 
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
    <input name=\"notes\" required placeholder=\"Notes\" class=\"form-control\" type=\"text\"></div></div></div>

    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Due Date:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
    <input name=\"date\" required placeholder=\"MM/DD/YY\" class=\"form-control\" type=\"date\"></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\">Checkout Date: <span>".$date."</span></div></div>";

    if($noItem){
        echo "<br><br><div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button disabled type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
        data-submit=\"...Sending\">Check-out</button></div></div></form></fieldset></form>";
    }
    else{
        echo "<br><br><div class='form-group'><label class='col-md-4 control-label'></label><div class='col-md-4'>
        <button type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
        data-submit=\"...Sending\">Check-out</button><br><br></div></div></form></fieldset></form>";
    }

    //posts
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSubtype == NULL && $getItem == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        header("Location: ./checkout.php?type=".$type);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getItem == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSerial == NULL){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $item = $_POST['item'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype."&item=".$item);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $item = $_POST['item'];
        $serial = $_POST['serial'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype."&item=".$item."&serial=".$serial);
    }

    echo "<br><br><h2 style='text-align: center';>Current Checked-Out Inventories</h2><br>
    <table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\"><thead><th>Print</th><th>Serial Number</th><th>Item</th><th>Type</th><th>Subtype</th><th>Quantity Borrowed</th><th>Person</th>
    <th>Update Person</th><th>Checkout Date</th><th>Due Date</th><th>Check-In</th></thead>";

    $sql = "SELECT Id, Item, subtypes.Type, checkouts.Subtype, `Quantity Borrowed`, `Serial Number`, Person, `Update Person`, `Checkout Date`, `Due Date` FROM checkouts JOIN subtypes ON checkouts.Subtype = subtypes.Subtype WHERE `Return Date` IS NULL ORDER BY Id;";
    $result = mysqli_query($conn, $sql);
    $namesCount = 0;
    echo "<tbody>";
    while ($row = mysqli_fetch_array($result)) {
        $serial2 = $row['Serial Number'];
        $sql2 = "SELECT Id FROM inventory WHERE `Serial Number` = '$serial2';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);

        if(date_create($row['Due Date']) < date_create($date)){
            echo "<tr style='background: #d6010c!important;'>";
        }
        else{
            echo "<tr>";
        }
        echo "<td><a href='printCheckout.php?Id=$row[Id]'>Print<br></td><td>".$row['Serial Number']."</td><td>".$row['Item']."</td><td>".$row['Type']."</td><td>".$row['Subtype']."</td><td>".$row['Quantity Borrowed']."</td>
        <td>".$row['Person']."</td><td>".$row['Update Person']."</td><td>".date_format(date_create($row['Checkout Date']),'m/d/Y')."</td><td>".date_format(date_create($row['Due Date']),'m/d/Y')."</td>
        <td><a href='includes/checkin.inc.php?Id=".$row2['Id']."'>Check-In<br></td></tr>";
    }

    echo "</tbody></table>";
}
else{
    header("Location: ./login.php");
}

include 'tableFooter.php';
?>