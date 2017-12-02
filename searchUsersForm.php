<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head>
              <Title>Search Users</Title>
          </head>
          <div class=\"parent\">
              <button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    echo "<br>
          <div class=\"container\">
              <form class='well form-horizontal' action='searchUsersResults.php' method='post' id='contact_form'>
                  <fieldset>
                      <h2 style='text-align: center'>Search Users</h2><br/>                        
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">First Name:</label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-user\"></i>
                                  </span>
                                  <input name='first' placeholder='First Name' class='form-control' type='text'>
                              </div>
                          </div>
                      </div>
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Last Name:</label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-user\"></i>
                                  </span>
                                  <input name='last' placeholder='Last Name' class='form-control' type='text'>
                              </div>
                          </div>
                      </div>
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Username:</label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-user\"></i>
                                  </span>
                                  <input name='accountName' placeholder=\"Username\" class='form-control' type='text'>
                              </div>
                          </div>
                      </div>
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">E-Mail:</label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-envelope\"></i>
                                  </span>
                                  <input name=\"email\" placeholder=\"E-Mail Address\" class=\"form-control\" type=\"email\">
                              </div>
                          </div>
                      </div>
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Account Type:</label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-list\"></i>
                                  </span>
                                  <select name='accountType' class=\"form-control selectpicker\">
                                      <option selected value=''></option>
                                      <option value='Standard User'>Standard User</option>
                                      <option value='Admin'>Admin</option>
                                      <option value='Super Admin'>Super Admin</option>
                                  </select>
                              </div>
                          </div>
                      </div>
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Date Added:</label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-calendar\"></i>
                                  </span>
                                  <input name='dateAdded' placeholder=\"Date Added\" class=\"form-control\" type='date'>
                              </div>
                          </div>
                      </div>
    
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <button name=\"submit\" type=\"submit\" class=\"btn btn-warning btn-block\" id=\"contact-submit\" data-submit=\"...Sending\">Search Users</button>
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