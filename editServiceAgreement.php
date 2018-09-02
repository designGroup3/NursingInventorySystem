<?php
include 'header.php';
?>
<script src="js/bootstrapvalidator.min.js"></script>
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
                cost: {
                    validators: {
                        numeric:{
                            decimalSeparator : true,
                            thousandsSeparator :true,
                            message: 'Please add a valid cost'
                        },
                        notEmpty: {
                            message: 'Please add a valid cost'
                        },
                        step:{
                            step: 0.01,
                            message: 'Please add a valid cost'
                        },
                        greaterThan:{
                            inclusive: true,
                            value: -0.01,
                            message: 'Please add a valid cost'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your email address'
                        },
                        emailAddress: {
                            message: 'Please supply a valid email address'
                        }
                    }
                },
                file: {
                    validators: {
                        file: {
                            maxFiles:1,
                            extension: 'pdf',
                            type: 'application/pdf',
                            message: 'The selected file is not valid. Only .pdf files are valid.'
                        }
                    }
                }
            }
        })
    });
</script>
<?php

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $id = $_GET['edit'];
    echo "<head>
              <Title>Edit Service Agreement</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $checkSql = "SELECT * FROM serviceAgreements WHERE `Id` = '$id';";
    $checkResult = mysqli_query($conn, $checkSql);
    if(mysqli_num_rows($checkResult) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='serviceAgreements.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=wrongType') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Approval forms must a .pdf file.</div><br><br><br>";
    }
    elseif(strpos($url, 'error=reverseDates') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        The start date must be before the end date.</div><br><br><br>";
    }

    $sql="SELECT * FROM serviceAgreements WHERE Id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $name = $row['Name'];
    $name = str_replace("\"","&quot;","$name");
    $duration = $row['Duration'];
    $duration = str_replace("\"","&quot;","$duration");

    echo "<div class=\"container\">
          <form class=\"well form-horizontal\" action='includes/editServiceAgreement.inc.php' method='POST' id=\"contact_form\" enctype='multipart/form-data'>
              <fieldset>
                  <h2 align=\"center\">Edit Service Agreement</h2><br/>
                  <input type='hidden' name='id' value=$id>
                  <div class=\"form-group\">
                      <label class=\"col-md-4 control-label\">Agreement Name: 
                          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                      </label>
                      <div class=\"col-md-4 inputGroupContainer\">
                          <div class=\"input-group\">
                              <span class=\"input-group-addon\">
                                  <i class=\"glyphicon glyphicon-tag\"></i>
                              </span>
                              <input name=\"name\" class=\"form-control\" required type=\"text\" value=\"".$name."\">
                          </div>
                      </div>
                  </div>
        
        <div class=\"form-group\">
            <label class=\"col-md-4 control-label\">Annual Cost: 
                <a style=\"color:red;\" title=\"This field must be filled\">*</a>
            </label>
            <div class=\"col-md-4 inputGroupContainer\">
                <div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"fa fa-usd\"></i></span>
                    <input name='cost' class='form-control data-fv-numeric-decimalseparator' required title=\"A valid number should not contain letters or commas or more than one decimal point e.g. 50.50 for fifty dollars and fifty cents\" value='".$row['Annual Cost']."'>
                </div>
            </div>
        </div>
        
        <div class=\"form-group\">
            <label class=\"col-md-4 control-label\">Duration:
                <a style=\"color:red;\" title=\"This field must be filled\">*</a>
            </label>
            <div class=\"col-md-4 selectContainer\">
                <div class=\"input-group\">
                    <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                    <input type='text' name='duration' required value=\"".$duration."\" class=\"form-control\">
                </div>
            </div>
        </div>
        
        <div class=\"form-group\">
            <label class=\"col-md-4 control-label\">Start Date:
                <a style=\"color:red;\" title=\"This field must be filled\">*</a>
            </label>
            <div class=\"col-md-4 dateContainer\">
                <div class=\"input-group input-append date\">
                    <span class=\"input-group-addon add-on\">
                        <span class=\"glyphicon glyphicon-calendar\"></span>
                    </span>
                    <input type=\"date\" required class=\"form-control\" name=\"startDate\" value='".$row['Start Date']."'/>
                </div>
            </div>
        </div>
      
        <div class=\"form-group\">
            <label class=\"col-md-4 control-label\">End Date:
                <a style=\"color:red;\" title=\"This field must be filled\">*</a>
            </label>
            <div class=\"col-md-4 dateContainer\">
                <div class=\"input-group input-append date\">
                    <span class=\"input-group-addon add-on\">
                        <span class=\"glyphicon glyphicon-calendar\"></span>
                    </span>
                    <input type=\"date\" required class=\"form-control\" name=\"endDate\" value='".$row['End Date']."'/>
                </div>
            </div>
        </div>
        
        <div class=\"form-group\">
            <label class=\"col-md-4 control-label\">Approval Form: </label>
            <div class=\"col-md-4\">
                <input type=\"file\" class=\"form-control\" name=\"file\" id='file' />
            </div>
        </div>
        
        <div class=\"form-group\">
            <label class=\"col-md-4 control-label\"></label>
            <div class=\"col-md-4\">
                <button type='submit' class='btn btn-warning btn-block'>Edit Service Agreement</button>
            </div>
        </div>
    </fieldset>
</form>
</div>";
}
else{
    header("Location: ./login.php");
}
?>