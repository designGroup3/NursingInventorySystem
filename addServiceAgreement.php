<?php
include 'header.php';

//approval: {
//    validators: {
//        file: {
//            maxFiles:1,
//                        extension: 'jpeg,jpg,png,pdf',
//                        type: 'image/jpeg,image/png,application/pdf',
//                        message: 'The selected file is not valid. Only jpeg,jpg,png,pdf files are valid'
//
//                    }
//    }
//}

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head><Title>Add Service Agreement</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=wrongType') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Approval forms must a .pdf file.</div><br><br><br>";
        //echo "<br>&nbsp&nbspApproval forms must a .pdf file.<br>";
    }

    echo "<br><form action='includes/addServiceAgreement.inc.php' method='POST' enctype='multipart/form-data'>
        &nbsp&nbsp<label>Name<br></label>&nbsp&nbsp<input type='text' name='name'><br><br>
        &nbsp&nbsp<label>Annual Cost<br></label>&nbsp&nbsp$<input type='number' min='0' step='0.01' name='cost'><br><br>
        &nbsp&nbsp<label>Duration<br></label>&nbsp&nbsp<input type='text' name='duration'><br><br>
        &nbsp&nbsp<label>Expiration Date<br></label>&nbsp&nbsp<input type='date' name='date'><br><br>
        &nbsp&nbsp<label>Approval Form<br></label>&nbsp&nbsp<input type='file' name='file'><br><br><br>
        &nbsp&nbsp<button type='submit'>Add Service Agreement</button></form>";
}
else{
    header("Location: ./login.php");
}
?>