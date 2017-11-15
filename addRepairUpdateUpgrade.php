<?php
include 'header.php';
include 'decimalInputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Add Repair/Update/Upgrade</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
          <i class='fa fa-question'></i></button></div>";

    echo "<div class=\"container\"><form action='includes/addRepairUpdateUpgrade.inc.php' class=\"well form-horizontal\" 
          method='POST' id=\"contact_form\"><fieldset><h2 align=\"center\">Add Repair/Update/Upgrade</h2><br/>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">Service Type:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th-large\"></i></span>
          <select name='type' required class=\"form-control selectpicker\">
          <option value=''></option>
          <option value='Repair'>Repair</option>
          <option value='Update'>Update</option>
          <option value='Upgrade'>Upgrade</option></select></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">Serial Number:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-hashtag\"></i></span>
          <select name='serialNumber' required class=\"form-control selectpicker\">
          <option value=''></option>";
    $sql = "SELECT `Serial Number` FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['Serial Number'].'">'.$row['Serial Number'].'</option>';
    }
    echo "</select></div></div></div>

        <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Part:
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
}

else{
    header("Location: ./login.php");
}
?>