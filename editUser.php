<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head>
              <Title>Edit User</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='./UserManual.pdf#page=10'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=username') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Username already in use.</div><br><br><br>";
    }
    elseif(strpos($url, 'error=noAdmin') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              There must be at least 1 Super Admin in the system.</div><br><br><br>";
    }
    elseif(strpos($url, 'error=email') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              That e-mail address is already in use.</div><br><br><br>";
    }

    $id = $_GET['edit'];

    $sql="SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(mysqli_num_rows($result) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='usersTable.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    $first = $row['First'];
    $first = str_replace("\"","&quot;","$first");
    $last = $row['Last'];
    $last = str_replace("\"","&quot;","$last");
    $user = $row['Uid'];
    $user = str_replace("\"","&quot;","$user");

    echo "<div class=\"container\">
              <form action='includes/editUser.inc.php' method='POST' class=\"well form-horizontal\" id=\"contact_form\">
                  <fieldset>
                      <h2 align=\"center\">Edit User</h2><br/>
                      <input type='hidden' name='id' value=$id>
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">First Name:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-user\"></i>
                                  </span>
                                  <input type='text' name='first' value=\"".$first."\" class=\"form-control\" required>
                              </div>
                          </div>
                      </div>
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Last Name:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-user\"></i>
                                  </span>
                                  <input type='text' name='last' value=\"".$last."\" class=\"form-control\" required>
                              </div>
                          </div>
                      </div>
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Username:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-user\"></i>
                                  </span>
                                  <input type='text' name='uid' value=\"".$user."\" class=\"form-control\" required>
                              </div>
                          </div>
                      </div>
                      <input type='hidden' name='originalType' value='".$row['Account Type']."'>
                      <input type='hidden' name='originalEmail' value=\"".$row['Email']."\">
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">E-Mail:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 inputGroupContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-envelope\"></i>
                                  </span>
                                  <input type='email' name='email' value=\"".$row['Email']."\" class=\"form-control\" required>
                              </div>
                          </div>
                      </div>
        
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Account Type:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-list\"></i>
                                  </span>
                                  <select name='type' required class=\"form-control selectpicker\">";
    if($row['Account Type'] == "Standard User"){
        echo "<option selected value='Standard User'>Standard User</option>
              <option value='Admin'>Admin</option>
              <option value='Super Admin'>Super Admin</option>";
    }
    elseif($row['Account Type'] == "Admin"){
        echo "<option value='Standard User'>Standard User</option>
              <option selected value='Admin'>Admin</option>
              <option value='Super Admin'>Super Admin</option>";
    }
    elseif($row['Account Type'] == "Super Admin"){
        echo "<option value='Standard User'>Standard User</option>
              <option value='Admin'>Admin</option>
              <option selected value='Super Admin'>Super Admin</option>";
    }
    echo "</select>
      </div>
  </div>
</div>
<div class=\"form-group\">
    <label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\">
        <button type='submit' class='btn btn-warning btn-block'>Edit User</button>
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