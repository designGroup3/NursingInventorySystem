<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $number = $_GET['number'];

    $sql = "SELECT * FROM clients WHERE Number = $number;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $last = $row['Last'];
    $first = $row['First'];

    echo "<head>
              <Title>Delete Client</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='./UserManual.pdf#page=26'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    if(mysqli_num_rows($result) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='clients.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    echo "<div class=\"container\">
              <form action ='includes/deleteClient.inc.php' class=\"well form-horizontal\" method ='POST' id=\"contact_form\">
                  <fieldset>
                      <h3 align=\"center\">Are you sure you want to delete $first "." "." $last's account?</h3>
                      <p align=\"center\" style=\"color:red;\">*This action cannot be undone.</p>
                      <input type='hidden' name='number' value = $number>
            
                      <div class=\"form-group\" style='text-align: center;'>
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <input type='hidden' name='number' value = $number>
                              <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
                              <input onclick=\"window.location.href='clients.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
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