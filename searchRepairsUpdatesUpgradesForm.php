<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head>
              <Title>Search Repairs/Updates/Upgrades</Title>
          </head>
          <div class=\"parent\">
              <button class='help' onclick=\"window.location.href='./UserManual.pdf#page=32'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    echo "<div class=\"container\">
              <form action ='searchRepairsUpdatesUpgradesResults.php' method ='POST' class=\"well form-horizontal\" id=\"contact_form\">
                  <fieldset>
                      <h2 align=\"center\">Search Repairs/Updates/Upgrades</h2><br/>
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Service Type:</label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-th-list\"></i>
                                  </span>
                                  <select name='type' class=\"form-control selectpicker\">
                                      <option value=''></option>
                                      <option value='Repair'>Repair</option>
                                      <option value='Update'>Update</option>
                                      <option value='Upgrade'>Upgrade</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Serial Number:</label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"fa fa-hashtag\"></i>
                                  </span>
                                  <select name='serialNumber' class=\"form-control selectpicker\">
                                      <option value=''></option>";

    $sql = "SELECT `Serial Number` FROM `repairs/updates/upgrades` ORDER BY `Serial Number`;";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['Serial Number'].'">'.$row['Serial Number'].'</option>';
    }
    echo "</select>
      </div>
  </div>
</div>
<div class=\"form-group\">
    <label class=\"col-md-4 control-label required\">Item:</label> 
    <div class=\"col-md-4 inputGroupContainer\">
        <div class=\"input-group\">
            <span class=\"input-group-addon\">
                <i class=\"glyphicon glyphicon-info-sign\"></i>
            </span>
            <select name='item' class=\"form-control selectpicker\">
                <option value= ''></option>";

    $sql = "SELECT Item FROM inventory ORDER BY Item;";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['Item'].'">'.$row['Item'].'</option>';
    }
    echo "</select>
      </div>
  </div>
</div>

<div class=\"form-group\">
    <label class=\"col-md-4 control-label\">Part:</label>
    <div class=\"col-md-4 selectContainer\">
        <div class=\"input-group\">
            <span class=\"input-group-addon\">
                <i class=\"fa fa-tablet\"></i>
            </span>
            <input type='text' name='part' class=\"form-control\">
        </div>
    </div>
</div>

<div class=\"form-group\">
    <label class=\"col-md-4 control-label\">Cost:</label>
    <div class=\"col-md-4 inputGroupContainer\">
        <div class=\"input-group\">
            <span class=\"input-group-addon\">
                <i class=\"fa fa-usd\"></i>
            </span>
            <input name='cost' class='form-control' type='number' min='0' step='0.01'>
        </div>
    </div>
</div>

<div class=\"form-group\">
    <label class=\"col-md-4 control-label\">Date Performed:</label>
    <div class=\"col-md-4 selectContainer\">
        <div class=\"input-group\">
            <span class=\"input-group-addon\">
                <i class=\"fa fa-calendar\"></i>
            </span>
            <input type='date' name='date' class=\"form-control\">
        </div>
    </div>
</div>

<div class=\"form-group\">
    <label class=\"col-md-4 control-label\">Supplier:</label>
    <div class=\"col-md-4 selectContainer\">
        <div class=\"input-group\">
            <span class=\"input-group-addon\">
                <i class=\"fa fa-shopping-bag\"></i>
            </span>
            <input type='text' name='supplier' class=\"form-control\">
        </div>
    </div>
</div>

<div class=\"form-group\">
    <label class=\"col-md-4 control-label\">Reason:</label>
    <div class=\"col-md-4 selectContainer\">
        <div class=\"input-group\">
            <span class=\"input-group-addon\">
                <i class=\"fa fa-question\"></i>
            </span>
            <input type='text' name='reason' class=\"form-control\">
        </div>
    </div>
</div>

<div class=\"form-group\">
    <label class=\"col-md-4 control-label\"></label>
    <div class=\"col-md-4\">
        <button type='submit' class='btn btn-warning btn-block'>Search Repairs/Updates/Upgrades</button>
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