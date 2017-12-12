<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head>
              <Title>Delete Consumable Column</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='./UserManual.pdf#page=62'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'success') !== false){
        echo "<br><div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              Column deleted successfully.</div><br><br><br>";
    }

    $columnNames = array();

    $sql = "SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo '<div class="container">
              <form method="post" class="well form-horizontal" id="contact_form">
                  <fieldset>
                      <h2 align="center">Which column would you like to delete?</h2><br>
                      <div class="form-group">
                          <label class="col-md-4 control-label">Column Name:
                              <a style="color:red;" title="This field must be filled">*</a>
                          </label>
                          <div class="col-md-4 selectContainer">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                      <i class="fa fa-columns"></i>
                                  </span>
                                  <select name="column" onchange="this.form.submit()" class="form-control selectpicker">
                                      <option selected value=""></option>';

    for($columnsCount = 0; $columnsCount < count($columnNames); $columnsCount++) {
        if($columnsCount > 6){
            echo '<option value = "'.$columnNames[$columnsCount].'">'.$columnNames[$columnsCount].'</option>';
        }
    }
    echo '</select>
      </form>
  </div>
</div>
</div>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $column = $_POST['column'];

        echo "<form action ='includes/deleteConsumableColumn.inc.php' method ='POST'>   
                  <fieldset>
                      <h3 align=\"center\">Are you sure you want to delete the $column column?</h3>
                      <p align=\"center\" style=\"color:red;\">*All data it contains will be gone forever.</p><br/>
                      <div class=\"form-group\" style='text-align: center'>
                          <label class=\"col-md-4 col-xs-4 col-sm-4 col-xl-4 control-label\"></label>
                          <div class='col-md-4 col-xs-4 col-lg-4 col-xl-4'>
                              <input type='hidden' name='column' value = \"$column\">
                              <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
                              <input onclick=\"window.location.href = 'consumables.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
                          </div>
                      </div><br><br>
                  </fieldset>
              </form>";
    }
}
else{
    header("Location: ./login.php");
}
?>