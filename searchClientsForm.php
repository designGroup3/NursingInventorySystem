<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Clients</Title></head><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "<div class=\"container\">
        <form action ='searchClientsResults.php' class=\"well form-horizontal\" method ='POST' id=\"contact_form\">
        <fieldset><h2 align=\"center\">Search Clients</h2><br/>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">First Name:</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
        <input type='text' name='first' placeholder=\"First Name\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\" >Last Name:</label> 
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
        <input type='text' name='last' placeholder=\"Last Name\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\" >Ext.</label> 
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-phone-square\"></i></span>
        <input type='number' min='0' name='ext' placeholder=\"Extension\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">E-Mail:</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>
        <input type='email' name='email' placeholder=\"E-Mail Address\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Office:</label>  
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-building\"></i></span>
        <input type='text' name='office' placeholder=\"Office\" class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button type='submit' class='btn btn-warning btn-block'>Search Clients</button></div></div></fieldset></form></div>";
}
else{
    header("Location: ./login.php");
}
?>