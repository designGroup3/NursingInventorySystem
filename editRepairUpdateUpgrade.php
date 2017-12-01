<?php
include 'header.php';
include 'decimalInputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $id = $_GET['edit'];
    echo "<head>
              <Title>Edit Repair/Update/Upgrade</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $sql="SELECT * FROM `repairs/updates/upgrades` WHERE Id = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(mysqli_num_rows($result) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='repairsUpdatesUpgrades.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    $part = $row['Part'];
    $part = str_replace("\"","&quot;","$part");
    $supplier = $row['Supplier'];
    $supplier = str_replace("\"","&quot;","$supplier");
    $reason = $row['Reason'];
    $reason = str_replace("\"","&quot;","$reason");

    echo "<div class=\"container\">
              <form action='includes/editRepairUpdateUpgrade.inc.php' method='POST' class=\"well form-horizontal\" id=\"contact_form\">
                  <fieldset>
                      <h2 align=\"center\">Edit Repair/Update/Upgrade</h2><br/>
                      <input type='hidden' name='id' value=$id>
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Service Type:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-th-list\"></i>
                                  </span>
                                  <select name='type' required class=\"form-control selectpicker\">
                                      <option value=''></option>";
          if($row['Type'] == "Repair"){
              echo "<option selected value='Repair'>Repair</option>
                    <option value='Update'>Update</option>
                    <option value='Upgrade'>Upgrade</option>
                </select>
            </div>
        </div>
    </div>";
          }
          elseif($row['Type'] == "Update"){
              echo "<option value='Repair'>Repair</option>
                    <option selected value='Update'>Update</option>
                    <option value='Upgrade'>Upgrade</option>
                </select>
            </div>
        </div>
    </div>";
          }
          elseif($row['Type'] == "Upgrade"){
              echo "<option value='Repair'>Repair</option>
                    <option value='Update'>Update</option>
                    <option selected value='Upgrade'>Upgrade</option>
                </select>
            </div>
        </div>
    </div>";
          }

          echo "<div class=\"form-group\">
                    <label class=\"col-md-4 control-label\">Serial Number:
                        <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                    </label>
                    <div class=\"col-md-4 selectContainer\">
                        <div class=\"input-group\">
                            <span class=\"input-group-addon\">
                                <i class=\"fa fa-hashtag\"></i>
                            </span>
                            <select name='serialNumber' required class=\"form-control selectpicker\">";
          $sql2 = "SELECT `Serial Number` FROM inventory WHERE `Serial Number` IS NOT NULL ORDER BY `Serial Number`;";
          $result2 = mysqli_query($conn, $sql2);
          while($row2 = mysqli_fetch_array($result2)) {
              $showNoQuotesSerial = $row2['Serial Number']; //Allows "
              $showNoQuotesSerial = str_replace("\"","&quot;","$showNoQuotesSerial");
              if($row['Serial Number'] === $row2['Serial Number']){
                  echo '<option selected value = "'.$showNoQuotesSerial.'">'.$row2['Serial Number'].'</option>';
              }
              else{
                  echo '<option value = "'.$showNoQuotesSerial.'">'.$row2['Serial Number'].'</option>';
              }
          }
        echo "</select>
          </div>
      </div>
  </div>
  <div class=\"form-group\">
      <label class=\"col-md-4 control-label\">Part:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
      </label>
      <div class=\"col-md-4 selectContainer\">
          <div class=\"input-group\">
              <span class=\"input-group-addon\">
                  <i class=\"fa fa-tablet\"></i>
              </span>
              <input type='text' name='part' value=\"".$part."\" class=\"form-control\" required>
          </div>
      </div>
  </div>
  
  <div class=\"form-group\">
      <label class=\"col-md-4 control-label\">Cost:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
      </label>
      <div class=\"col-md-4 inputGroupContainer\">
          <div class=\"input-group\">
              <span class=\"input-group-addon\">
                  <i class=\"fa fa-usd\"></i>
              </span>
              <input name='cost' class='form-control data-fv-numeric-decimalseparator' required value='".$row['Cost']."'
              title=\"A valid number should not contain letters or commas or more than one decimal point e.g. 50.50 for fifty dollars and fifty cents\">
          </div>
      </div>
  </div>
  
  <div class=\"form-group\">
      <label class=\"col-md-4 control-label\">Date Performed:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
      </label>
      <div class=\"col-md-4 selectContainer\">
          <div class=\"input-group\">
              <span class=\"input-group-addon\">
                  <i class=\"fa fa-calendar\"></i>
              </span>
              <input type='date' name='date' value='".$row['Date']."' class=\"form-control\" required>
          </div>
      </div>
  </div>
  
  <div class=\"form-group\">
      <label class=\"col-md-4 control-label\">Supplier:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
      </label>
      <div class=\"col-md-4 selectContainer\">
          <div class=\"input-group\">
              <span class=\"input-group-addon\">
                  <i class=\"fa fa-shopping-bag\"></i>
              </span>
              <input type='text' name='supplier' value=\"".$supplier."\" class=\"form-control\" required>
          </div>
      </div>
  </div>
  
  <div class=\"form-group\">
      <label class=\"col-md-4 control-label\">Reason:
          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
      </label>
      <div class=\"col-md-4 selectContainer\">
          <div class=\"input-group\">
              <span class=\"input-group-addon\">
                  <i class=\"fa fa-question\"></i>
              </span>
              <input type='text' name='reason' value=\"".$reason."\" class=\"form-control\" required>
          </div>
      </div>
  </div>
  
  <div class=\"form-group\">
      <label class=\"col-md-4 control-label\"></label>
      <div class=\"col-md-4\">
          <button type='submit' class='btn btn-warning btn-block'>Edit Repair/Update/Upgrade</button>
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