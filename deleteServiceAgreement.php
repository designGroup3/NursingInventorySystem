<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM `serviceagreements` WHERE Id = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $name = $row['Name'];

    echo "<head>
              <Title>Delete Service Agreement</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='./UserManual.pdf#page=21'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    if(mysqli_num_rows($result) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='serviceAgreements.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    echo "<div class=\"container\">
              <form action ='includes/deleteServiceAgreement.inc.php' class=\"well form-horizontal\" method ='POST' id=\"contact_form\">
                  <fieldset>
                      <h3 align=\"center\">Are you sure you want to delete $name?</h3>
                      <p align=\"center\" style=\"color:red;\">*This action cannot be undone.</p><br/>
                      <div class=\"form-group\" style='text-align: center;'>
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <input type='hidden' name='id' value = $id>
                              <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
                              <input onclick=\"window.location.href='serviceAgreements.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
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