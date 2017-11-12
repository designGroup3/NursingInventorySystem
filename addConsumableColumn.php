<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Add Consumable Column</Title></head><div class=\"parent\"><button onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspA column already exists by that name.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the column.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspColumn added successfully.<br>";
    }

    echo "<div class=\"container\"><form class=\"well form-horizontal\" id=\"contact_form\"
          action ='includes/addConsumableColumn.inc.php' method = 'POST'><fieldset><h2 align=\"center\">
          Add Consumable Column</h2><br/><div class=\"form-group\"><label class=\"col-md-4 control-label\">Column Name:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-columns\"></i></span>
          <input type='text' class=\"form-control\" required name='name'></div></div></div>
          
          <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Data Type:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-server\"></i></span>
          <select name ='type' required class=\"form-control selectpicker\">
          <option value=''></option><option value='varchar'>Letters & Numbers</option>
          <option value='tinyint'>Yes or No</option></select></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
          <button type=\"submit\" class=\"btn btn-warning btn-block\">Add Column</button></div></div><br><br></fieldset>
          </form></div>";
}
else{
    header("Location: ./login.php");
}

?>