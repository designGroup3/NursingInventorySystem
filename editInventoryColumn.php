<?php
include 'header.php';
//include "inputJS.php";
?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/v2.3.8/angular-strap.min.js"></script>
    <body>
    <script>
        $(document).ready(function() {
            $('#contact_form').bootstrapValidator({
                // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    newColumn: {
                        validators: {
                            regexp: {
                                regexp: /^[a-z\s]+$/i,
                                message: 'The full name can consist of alphabetical characters and spaces only'
                            }
                        }
                    },
                }
            })
                .on('success.form.bv', function(e) {
                    $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#contact_form').data('bootstrapValidator').resetForm();

                    // Prevent form submission
                    e.preventDefault();

                    // Get the form instance
                    var $form = $(e.target);

                    // Get the BootstrapValidator instance
                    var bv = $form.data('bootstrapValidator');

                    // Use Ajax to submit form data
                    $.post($form.attr('action'), $form.serialize(), function(result) {
                        console.log(result);
                    }, 'json');
                });
        });
    </script>
<?php

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Edit Inventory Column</Title><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div></script></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        A column already exists by that name.</div><br><br><br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        You must name the column.</div><br><br><br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Column changed successfully.</div><br><br><br>";
    }

    $columnNames = array();

    $sql = "SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo '<div class="container"><form class="well form-horizontal" id="contact_form" method="post"><fieldset>
          <h2 align="center">Which column would you like to edit?</h2><br>
          <div class="form-group"><label class="col-md-4 control-label"></label>
          <div class="col-md-4 selectContainer"><div  class="input-group">
          <span class="input-group-addon"><i class="fa fa-columns"></i></span>
          <select name="column" onchange="this.form.submit()" class="form-control selectpicker"><option selected value=""></option>';

    for($columnsCount = 0; $columnsCount < count($columnNames); $columnsCount++) {
        if($columnsCount > 10){
            echo '<option value = "'.$columnNames[$columnsCount].'">'.$columnNames[$columnsCount].'</option>';
        }
    }
    echo '</select></form></div></div></div>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $oldColumn = $_POST['column'];
        $type = "";

        $sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'inventory' AND
        COLUMN_NAME = '". $oldColumn. "';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $type = $row['DATA_TYPE'];

        if (strpos($oldColumn, ' ')) {
            $oldColumn = str_replace(" ", "%20", $oldColumn);
        }
        echo "<br><form action ='includes/editInventoryColumn.inc.php' method = 'POST'><br>
        <input type='hidden' name='oldColumn' value = $oldColumn>
        <input type='hidden' name='oldType' value = $type>
        <input type='hidden' name='source' value = 'editPage'>";
        if (strpos($oldColumn, '%20')) {
            $oldColumn = str_replace("%20", " ", $oldColumn);
        }

        echo "<br><br><div class=\"form-group\"><label class=\"col-md-4 control-label\">
        Column Name:<a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 inputGroupContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-columns\"></i></span>
        <input type='text' class=\"form-control\" required name='newColumn' value='".$oldColumn."'></div></div></div>

        <div class=\"form-group\"> <label class=\"col-md-4 control-label\">Data Type:
        <a style=\"color:red;\" title=\"This field must be filled\">*</a></label>
        <div class=\"col-md-4 selectContainer\"><div class=\"input-group\">
        <span class=\"input-group-addon\"><i class=\"fa fa-server\"></i></span>
        <select name='newType' id='newType' class=\"form-control selectpicker\">";
        if (strpos($oldColumn, '%20')) {
            $oldColumn = str_replace("%20", " ", $oldColumn);
        }
        if($type == "varchar") {
            echo '<option selected value="Letters & Numbers">Letters & Numbers</option><option value="Yes or No">Yes or No</option>';
        }
        else{
            echo '<option value="Letters & Numbers">Letters & Numbers</option><option selected value="Yes or No">Yes or No</option>';
        }
        echo "</select></div></div></div>
            <div class='form-group'><label class='col-md-4 control-label'></label><div class='col-md-4'>
            <button type='submit' class=\"btn btn-warning btn-block\">Edit Column</button><br><br></div></div></form></fieldset></form>";


        echo "<script>$('document').ready(function() {

    $('#newType').on('change',function(){
        alert(\"Warning: Changing type will delete all column data.\");
    });

});</script>";
    }
}
else{
    header("Location: ./login.php");
}
?>