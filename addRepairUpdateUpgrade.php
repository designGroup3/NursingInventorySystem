<?php
include 'header.php';
include 'decimalInputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    error_reporting(E_ALL ^ E_NOTICE);
    $getType = $_GET['type'];
    $getItemType = $_GET['itemType'];
    $getSubtype = $_GET['subtype'];
    $getSerial = $_GET['serial'];
    $getItem = $_GET['item'];

    echo "<head><Title>Add Repair/Update/Upgrade</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
          <i class='fa fa-question'></i></button></div>";

    echo "<div class=\"container\"><form class=\"well form-horizontal\" method='POST' id=\"contact_form\">
          <fieldset><h2 align=\"center\">Add Repair/Update/Upgrade</h2><br/>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">Service Type:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-list\"></i></span>";
          if($getType !== NULL && $getType !== ""){
              echo "<select name='type' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
                    <option value='$getType'>$getType</option>";
          }
          else{
              echo "<select name='type' required class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
                    <option value=''></option>
                    <option value='Repair'>Repair</option>
                    <option value='Update'>Update</option>
                    <option value='Upgrade'>Upgrade</option>";
          }
    echo"</select></div></div></div>";

    //start item type
    echo "<form class=\"well form-horizontal\" id=\"contact_form\" method=\"POST\">
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Item Type:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>";
    if($getType !== NULL && $getType !== ""){
        $typeSQL = "SELECT DISTINCT Type FROM subtypes;";
        $typeResult = mysqli_query($conn, $typeSQL);
        echo "<input type=\"hidden\" name=\"type\" value = '$getType'>";
        if($getItemType !== NULL && $getItemType !== ""){
            echo "<select name='itemType' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
              <option value='$getItemType'>$getItemType</option>";
        }
        else{
            echo "<select name='itemType' required class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
              <option value=''></option>";
            while($typeRow = mysqli_fetch_array($typeResult)) {
                echo '<option value = "'.$typeRow['Type'].'">'.$typeRow['Type'].'</option>';
            }
        }
    }
    else{
        echo "<select name='itemType' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
              <option value=''>Select a service type first</option>";
    }
    echo "</select></div></div></div>";

    //start subtype
    if($getItemType !== NULL && $getItemType !== ""){
        $subtypeSql = "SELECT Subtype FROM subtypes WHERE Type = '".$getItemType."';";
        $subtypeResult = mysqli_query($conn, $subtypeSql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
        <div class="form-group"><label class="col-md-4 control-label">
        <input type="hidden" name="type" value = "'.$getType.'">
        <input type="hidden" name="itemType" value = "'.$getItemType.'">
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
        while ($subtypeRow = mysqli_fetch_array($subtypeResult)) {
            if($subtypeRow['Subtype'] == $getSubtype){
                echo '<option selected value = "' . $subtypeRow['Subtype'] . '">' . $subtypeRow['Subtype'] . '</option>';
            }
            else{
                echo '<option value = "' . $subtypeRow['Subtype'] . '">' . $subtypeRow['Subtype'] . '</option>';
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
      
    //start serial number
    echo "<form class=\"well form-horizontal\" id=\"contact_form\" method=\"POST\">
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Serial Number:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-hashtag\"></i></span>";

    if($getSubtype !== NULL && $getSubtype !== ""){
        echo "<input type=\"hidden\" name=\"type\" value = '$getType'>
        <input type=\"hidden\" name=\"itemType\" value = '$getItemType'>
        <input type=\"hidden\" name=\"subtype\" value = '$getSubtype'>
        <select name='serialNumber' required class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
        <option value=''></option>";
        if($getSerial !== NULL && $getSerial !== ""){
            $serialSQL = "SELECT * FROM inventory WHERE Subtype = '$getSubtype';";
            $serialResult = mysqli_query($conn, $serialSQL);
            while($serialRow = mysqli_fetch_array($serialResult)) {
                if($serialRow['Serial Number'] == $getSerial){
                    echo '<option selected value = "'.$serialRow['Serial Number'].'">'.$serialRow['Serial Number'].'</option>';
                }
                else{
                    echo '<option value = "'.$serialRow['Serial Number'].'">'.$serialRow['Serial Number'].'</option>';
                }
            }
        }
        else{
            $sql = "SELECT `Serial Number` FROM inventory WHERE Subtype = '$getSubtype'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)) {
                echo '<option value = "'.$row['Serial Number'].'">'.$row['Serial Number'].'</option>';
            }
        }
    }
    else{
        echo "<select name='serialNumber' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
        <option value=''>Select a subtype first</option>";
    }

    echo "</select></form></div></div></div><form action =\"includes/addRepairUpdateUpgrade.inc.php\" method=\"POST\">
    <input type='hidden' name='type' value = '$getType'>
    <input type='hidden' name='itemType' value = '$getItemType'>
    <input type='hidden' name='subtype' value = '$getSubtype'>
    <input type='hidden' name='serialNumber' value = '$getSerial'>
    <div class=\"form-group\"><label class=\"col-md-4 control-label required\">Item:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label> 
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-info-sign\"></i></span>
    <select name='item' disabled class=\"form-control selectpicker\">";

    if($getSerial !== NULL && $getSerial !== ""){
        $serialSql = "SELECT * FROM inventory WHERE `Serial Number` = '$getSerial';";
        echo $serialSql;
        $serialResult = mysqli_query($conn, $serialSql);
        $serialRow = mysqli_fetch_array($serialResult);
        $item = $serialRow['Item'];

        echo "<option value='$item'>$item</option>";
    }
    else{
        echo "<option value=''></option>";
    }

    echo "</select></div></div></div><div class=\"form-group\"> <label class=\"col-md-4 control-label\">Part:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-tablet\"></i></span>
    <input type='text' name='part' class=\"form-control\" required></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Cost:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-usd\"></i></span>
    <input name='cost' class='form-control data-fv-numeric-decimalseparator' required 
    title=\"A valid number should not contain letters or commas or more than one decimal point e.g. 50.50 for fifty dollars and fifty cents\">
    </div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Date Performed:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
    <input type='date' name='date' class=\"form-control\" required></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Supplier:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-shopping-bag\"></i></span>
    <input type='text' name='supplier' class=\"form-control\" required></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\">Reason:
    <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
    <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
    <span class=\"input-group-addon\"><i class=\"fa fa-question\"></i></span>
    <input type='text' name='reason' class=\"form-control\" required></div></div></div>
    
    <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
    <button type='submit' class='btn btn-warning btn-block'>Add Repair/Update/Upgrade</button></div></div></fieldset></form></div>";

    //posts
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getItemType == NULL && $getSubtype == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSubtype == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        $itemType = $_POST['itemType'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type."&itemType=".$itemType);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSerial == NULL){
        $type = $_POST['type'];
        $itemType = $_POST['itemType'];
        $subtype = $_POST['subtype'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type."&itemType=".$itemType."&subtype=".$subtype);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type = $_POST['type'];
        $itemType = $_POST['itemType'];
        $subtype = $_POST['subtype'];
        $serial = $_POST['serialNumber'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type."&itemType=".$itemType."&subtype=".$subtype."&serial=".$serial);
    }
}

else{
    header("Location: ./login.php");
}
?>