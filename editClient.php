<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $number = $_GET['edit'];
    echo "<head><Title>Edit Client</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $sql="SELECT * FROM clients WHERE number = $number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<div class=\"container\"><form action ='includes/editClient.inc.php' class=\"well form-horizontal\"
          method ='POST' id=\"contact_form\"><fieldset><h2 align=\"center\">Edit Client</h2><br/>
          <input type='hidden' name='number' value = $number>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">First Name:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
          <input type='text' name='first' class=\"form-control\" required placeholder='First Name' value=\"".$row['First']."\"></div></div></div>
            
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">Last Name:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label> 
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
          <input type='text' name='last' class=\"form-control\" required placeholder='Last Name' value=\"".$row['Last']."\"></div></div></div>
              
          <div class=\"form-group\"><label class=\"col-md-4 control-label\" >Ext.
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-phone-square\"></i></span>  
          <input type='number' min='0' name='ext' class=\"form-control\" required placeholder='Extension' value='".$row['Ext']."'></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">E-Mail:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>
          <input type='email' name='email' class=\"form-control\" required placeholder='E-mail' value=\"".$row['Email']."\"></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\">Office:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a></label> 
          <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
          <span class=\"input-group-addon\"><i class=\"fa fa-building\"></i></span>
          <input type='text' name='office' class=\"form-control\" required placeholder='Office' value=\"".$row['Office']."\"></div></div></div>
          
          <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
          <button type='submit' class='btn btn-warning btn-block'>Edit Client</button></div></div></fieldset></form></div>";
}
else{
    header("Location: ./login.php");
}
?>