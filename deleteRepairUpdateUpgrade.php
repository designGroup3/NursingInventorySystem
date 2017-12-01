<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];

    echo "<head>
              <Title>Delete Repair/Update/Upgrade</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $sql = "SELECT * FROM `repairs/updates/upgrades` WHERE Id = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(mysqli_num_rows($result) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='repairsUpdatesUpgrades.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    $type = $row['Type'];
    $serialnumber = $row['Serial Number'];
    $serialnumber = str_replace("\\","\\\\","$serialnumber");
    $serialnumber = str_replace("'","\'","$serialnumber");

    $sql2 = "SELECT * FROM inventory WHERE `Serial Number` = '$serialnumber';";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($result2);
    $item = $row2['Item'];

    echo "<div class='container'>
              <form action ='includes/deleteRepairUpdateUpgrade.inc.php' class='well form-horizontal' method ='POST' id=\"contact_form\">
                  <fieldset>
                      <h3 align=\"center\">Are you sure you want to delete this $item "." ".strtolower($type)."?</h3>
                      <p align=\"center\" style=\"color:red;\">*This action cannot be undone.</p><br/>
                      <div class=\"form-group\" style='text-align: center;'>
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <input type='hidden' name='id' value = $id>
                              <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
                              <input onclick=\"window.location.href='repairsUpdatesUpgrades.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
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