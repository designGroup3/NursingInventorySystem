<?php
include 'header.php';
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
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

    echo "<head>
              <Title>Add Service Agreement</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=wrongType') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Approval forms must a .pdf file.</div><br><br><br>";
    }

    echo "<div class=\"container\">
              <form action='includes/addServiceAgreement.inc.php' class=\"well form-horizontal\" 
              id=\"contact_form\" method='POST' enctype='multipart/form-data'>
                  <fieldset>
                      <h2 align=\"center\">Add Service Agreement</h2>
                      <p style=\"color:red; font-size:10px;\" align=\"center\">* required field</p><br/><br/>
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Agreement Name:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label> 
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-tag\" ></i>
                                  </span>
                                  <input type='text' class=\"form-control\" name='name' required>
                              </div>
                          </div>
                      </div>
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Annual Cost:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-usd\"></i>
                                  </span>
                                  <input name='cost' class='form-control data-fv-numeric-decimalseparator' required 
                                  title=\"A valid number should not contain letters or commas or more than one decimal point e.g. 50.50 for fifty dollars and fifty cents\">
                              </div>
                          </div>
                      </div>
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Duration:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-clock-o\"></i>
                                  </span>
                                  <input type='text' class=\"form-control\" name='duration' required>
                              </div>
                          </div>
                      </div>
                    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Expiration Date:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-calendar\"></i>
                                  </span>
                                  <input type='date' name='date' class=\"form-control\" required>
                              </div>
                          </div>
                      </div>
                    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Approval Form:</label>
                          <div class=\"col-md-4\">
                              <input type=\"file\" class=\"form-control\" name=\"file\" id='file'/>
                          </div>
                      </div>
                    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <button type='submit' class='btn btn-warning btn-block'>Add Service Agreement</button>
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