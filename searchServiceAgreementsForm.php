<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Service Agreements</Title></head><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "<div class=\"container\">
        <form action ='searchServiceAgreementsResults.php' class=\"well form-horizontal\" method ='POST'
        id=\"contact_form\" enctype='multipart/form-data'><fieldset><h2 align=\"center\">
        Search Service Agreements</h2><br/>
         
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Agreement Name:</label>
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-tag\" ></i></span>
        <input type='text' name='name' class=\"form-control\"></div></div></div>
         
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Annual Cost:</label>
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-usd\"></i></span>
        <input name='cost' class='form-control' type='number' min='0' step='0.01'></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Duration:</label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>  
        <input type='text' name='duration' class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\">Expiration Date:</label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
        <input type='date' name='date' class=\"form-control\"></div></div></div>
        
        <div class=\"form-group\"><label class=\"col-md-4 control-label\"></label><div class=\"col-md-4\">
        <button type='submit' class='btn btn-warning btn-block'>Search Service Agreements</button></div></div></fieldset></form></div>";
}
else{
    header("Location: ./login.php");
}
?>