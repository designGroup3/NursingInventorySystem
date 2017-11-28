<?php
include 'header.php';
include 'decimalInputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo "<head>
              <Title>Add Repair/Update/Upgrade</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    error_reporting(E_ALL ^ E_NOTICE);
    $statedTypes = array();
    $getType = $_GET['type'];
    if($getType !== NULL && $getType !== ""){
        if($getType != "Repair" && $getType != "Update" && $getType != "Upgrade"){
            echo "<br>
        <h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
        <div style='text-align: center'>
            <input onclick=\"window.location.href='addRepairUpdateUpgrade.php';\" class='btn btn-warning' value='Back'>
        </div>";
            exit();
        }
    }
    $getType = str_replace("%5C","\\","$getType");
    $getType = str_replace("%27","'","$getType");
    $getItemType = $_GET['itemType'];
    if($getItemType !== NULL && $getItemType !== ""){
        $checkSql = "SELECT * FROM subtypes WHERE `Type` = '$getItemType';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br>
        <h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
        <div style='text-align: center'>
            <input onclick=\"window.location.href='addRepairUpdateUpgrade.php';\" class='btn btn-warning' value='Back'>
        </div>";
            exit();
        }
    }
    $getItemType = str_replace("%5C","\\","$getItemType");
    $getItemType = str_replace("%27","'","$getItemType");
    $getSubtype = $_GET['subtype'];
    if($getSubtype !== NULL && $getSubtype !== ""){
        $checkSql = "SELECT * FROM subtypes WHERE `Subtype` = '$getSubtype';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br>
        <h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
        <div style='text-align: center'>
            <input onclick=\"window.location.href='addRepairUpdateUpgrade.php';\" class='btn btn-warning' value='Back'>
        </div>";
            exit();
        }
    }
    $getSubtype = str_replace("%5C","\\","$getSubtype");
    $getSubtype = str_replace("%27","'","$getSubtype");
    $getSerial = $_GET['serial'];
    if($getSerial !== NULL && $getSerial !== ""){
        $checkSql = "SELECT * FROM inventory WHERE `Serial Number` = '$getSerial';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br>
        <h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
        <div style='text-align: center'>
            <input onclick=\"window.location.href='addRepairUpdateUpgrade.php';\" class='btn btn-warning' value='Back'>
        </div>";
            exit();
        }
    }
    $getSerial = str_replace("%5C","\\","$getSerial");
    $getSerial = str_replace("%27","'","$getSerial");
    $getItem = $_GET['item'];
    $getItem = str_replace("%5C","\\","$getItem");
    $getItem = str_replace("%27","'","$getItem");

    echo "<div class=\"container\">
              <form class=\"well form-horizontal\" method='POST' id=\"contact_form\">
                  <fieldset>
                      <h2 align=\"center\">Add Repair/Update/Upgrade</h2><br/>
                      <div class=\"form-group\">
                          <label class=\"col-md-4 control-label\">Service Type:
                              <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                          </label>
                          <div class=\"col-md-4 selectContainer\">
                              <div class=\"input-group\">
                                  <span class=\"input-group-addon\">
                                      <i class=\"glyphicon glyphicon-th-list\"></i>
                                  </span>";
    if($getType !== NULL && $getType !== ""){
        echo "<select name='type' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
                    <option value='$getType'>$getType</option>";
    }
    else{
        echo "<select name='type' required class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
                    <option value=''></option>
                    <option value='Repair'>Repair</option>
                    <option value='Update'>Update</option>
                    <option value='Upgrade'>Upgrade</option>";
    }
    echo "</select>
      </div>
  </div>
</div>";

    //start item type
    echo "<form class=\"well form-horizontal\" id=\"contact_form\" method=\"POST\">
              <div class=\"form-group\">
                  <label class=\"col-md-4 control-label\">Item Type:
                      <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                  </label>
                  <div class=\"col-md-4 inputGroupContainer\">
                      <div class=\"input-group\">
                          <span class=\"input-group-addon\">
                              <i class=\"glyphicon glyphicon-th-large\"></i>
                          </span>";
    if($getType !== NULL && $getType !== ""){
        $typeSQL = "SELECT DISTINCT Type FROM subtypes WHERE `TABLE` = 'Inventory' ORDER BY Type;";
        $typeResult = mysqli_query($conn, $typeSQL);
        echo "<input type=\"hidden\" name=\"type\" value = '$getType'>";
        if($getItemType !== NULL && $getItemType !== ""){
            echo "<select name='itemType' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
              <option value='$getItemType'>$getItemType</option>";
        }
        else{
            echo "<select name='itemType' required class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
              <option value=''></option>";
            while($typeRow = mysqli_fetch_array($typeResult)) {
                echo '<option value = "'.$typeRow['Type'].'">'.$typeRow['Type'].'</option>';
            }
        }
    }
    else{
        echo "<select name='itemType' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
              <option value=''>Select a service type first</option>";
    }
    echo "</select>
      </div>
  </div>
</div>";

    //start subtype
    if($getItemType !== NULL && $getItemType !== ""){
        $getItemType = str_replace("\\","\\\\","$getItemType");
        $getItemType = str_replace("'","\'","$getItemType");
        $subtypeSql = "SELECT Subtype FROM subtypes WHERE Type = '".$getItemType."' ORDER BY Subtype;";
        $getItemType = str_replace("\'","%27","$getItemType");
        $getItemType = str_replace("\\\\","%5C","$getItemType");
        $subtypeResult = mysqli_query($conn, $subtypeSql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
                  <div class="form-group">
                      <label class="col-md-4 control-label">
                          <input type="hidden" name="type" value = "'.$getType.'">
                          <input type="hidden" name="itemType" value = "'.$getItemType.'">
                          Subtype:
                          <a style="color:red;" title="This field must be filled">*</a>
                      </label>
                      <div class="col-md-4 selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="glyphicon glyphicon-th"></i>
                              </span>';
        if($getSubtype == NULL) {
            echo '<select required name="subtype" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        else{
            echo '<select disabled name="subtype" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        if($getSubtype == NULL){
            echo '<option selected value=""></option>';
        }
        else{
            echo '<option value=""></option>';
        }
        while ($subtypeRow = mysqli_fetch_array($subtypeResult)) {
            if($subtypeRow['Subtype'] == $getSubtype){
                echo '<option selected value = "' . $subtypeRow['Subtype'] . '">' . $subtypeRow['Subtype'] . '</option>';
            }
            else{
                echo '<option value = "' . $subtypeRow['Subtype'] . '">' . $subtypeRow['Subtype'] . '</option>';
            }
        }
        echo '</select>
          </div>
      </div>
  </div>';
    }
    else{
        echo '<div class="form-group">
                  <label class="col-md-4 control-label">Subtype:
                      <a style="color:red;" title="This field must be filled">*</a>
                  </label>
                  <div class="col-md-4 selectContainer">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="glyphicon glyphicon-th"></i>
                          </span>
                          <select class="form-control selectpicker" disabled>
                              <option value="">Select a type first</option>
                          </select>
                      </div>
                  </div>
              </div>';
    }

    //start serial number
    echo "<form class=\"well form-horizontal\" id=\"contact_form\" method=\"POST\">
              <div class=\"form-group\">
                  <label class=\"col-md-4 control-label\">Serial Number:
                      <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                  </label>
                  <div class=\"col-md-4 selectContainer\">
                      <div class=\"input-group\">
                          <span class=\"input-group-addon\">
                              <i class=\"fa fa-hashtag\"></i>
                          </span>";

    if($getSubtype !== NULL && $getSubtype !== ""){
        $getSubtype = str_replace("'","%27","$getSubtype");
        $getSubtype = str_replace("\\","%5C","$getSubtype");
        echo "<input type=\"hidden\" name=\"type\" value = '$getType'>
        <input type=\"hidden\" name=\"itemType\" value = '$getItemType'>
        <input type=\"hidden\" name=\"subtype\" value = '$getSubtype'>
        <select name='serialNumber' required class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
            <option value=''></option>";
        if($getSerial !== NULL && $getSerial !== ""){
            $getSubtype = str_replace("%5C","\\\\","$getSubtype");
            $getSubtype = str_replace("%27","\'","$getSubtype");
            $serialSQL = "SELECT * FROM inventory WHERE Subtype = '$getSubtype';";
            $getSubtype = str_replace("\'","%27","$getSubtype");
            $getSubtype = str_replace("\\\\","%5C","$getSubtype");
            $serialResult = mysqli_query($conn, $serialSQL);
            while($serialRow = mysqli_fetch_array($serialResult)) {
                if($serialRow['Serial Number'] == $getSerial){
                    echo '<option selected value = "'.$serialRow['Serial Number'].'">'.$serialRow['Serial Number'].'</option>';
                }
                else{
                    echo '<option value = "'.$serialRow['Serial Number'].'">'.$serialRow['Serial Number'].'</option>';
                }
            }
            echo "</select>
              </form>
          </div>
      </div>
  </div>";
        }
        else{
            $getSubtype = str_replace("%5C","\\\\","$getSubtype");
            $getSubtype = str_replace("%27","\'","$getSubtype");
            $sql = "SELECT `Serial Number` FROM inventory WHERE Subtype = '$getSubtype'";
            $getSubtype = str_replace("\'","%27","$getSubtype");
            $getSubtype = str_replace("\\\\","%5C","$getSubtype");
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)) {
                echo '<option value = "'.$row['Serial Number'].'">'.$row['Serial Number'].'</option>';
            }
            echo "</select>
              </div>
          </div>
      </div>";
        }
    }
    else{
        echo "<select name='serialNumber' disabled class=\"form-control selectpicker\" onchange=\"this.form.submit()\">
                  <option value=''>Select a subtype first</option>
              </select>
          </div>
      </div>
  </div>";
    }

    //Start Item
    if($getSerial !== NULL && $getSerial !== ""){
        $getSerial = str_replace("\\","\\\\","$getSerial");
        $getSerial = str_replace("'","\'","$getSerial");
        $serialSql = "SELECT * FROM inventory WHERE `Serial Number` = '".$getSerial."';";
        $getSerial = str_replace("\'","%27","$getSerial");
        $getSerial = str_replace("\\\\","%5C","$getSerial");
        $serialResult = mysqli_query($conn, $serialSql);
        $serialRow = mysqli_fetch_array($serialResult);
        echo "<form action =\"includes/addRepairUpdateUpgrade.inc.php\" method=\"POST\">
              <label>
                  <input type='hidden' name='type' value = '$getType'>
                  <input type='hidden' name='itemType' value = '$getItemType'>
                  <input type='hidden' name='subtype' value = '$getSubtype'>
                  <input type='hidden' name='serial' value = '$getSerial'>
                  <div class=\"form-group\">
                      <label class=\"col-md-4 control-label\">Item:
                          <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                      </label>
                      <div class=\"col-md-4 inputGroupContainer\">
                          <div class=\"input-group\">
                              <span class=\"input-group-addon\">
                                  <i class=\"glyphicon glyphicon-info-sign\"></i>
                              </span>
                              <select name='item' disabled class=\"form-control selectpicker\">";

        $item = $serialRow['Item'];

        echo "<option value='$item'>$item</option></select></div></div></div>";
        $item = str_replace("\\","\\\\","$item");
        $item = str_replace("'","\'","$item");
    }
    else{
        echo "<div class=\"form-group\">
                  <label class=\"col-md-4 control-label required\">Item:
                      <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                  </label>
                  <div class=\"col-md-4 inputGroupContainer\">
                      <div class=\"input-group\">
                          <span class=\"input-group-addon\">
                              <i class=\"glyphicon glyphicon-info-sign\"></i>
                          </span>
                          <select name='item' disabled class=\"form-control selectpicker\">
                              <option value=''></option>
                          </select>
                      </div>
                  </div>
              </div>";
    }

    //Part, Cost, Date, Supplier, Reason
    echo "<div class=\"form-group\">
              <label class=\"col-md-4 control-label\">Part:
                  <a style=\"color:red;\" title=\"This field must be filled\">*</a>
              </label>
              <div class=\"col-md-4 selectContainer\">
                  <div class=\"input-group\">
                      <span class=\"input-group-addon\">
                          <i class=\"fa fa-tablet\"></i>
                      </span>
                      <input type='text' name='part' class=\"form-control\" required>
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
                      <input name='cost' class='form-control data-fv-numeric-decimalseparator' required 
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
                      <input type='date' name='date' class=\"form-control\" required>
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
                      <input type='text' name='supplier' class=\"form-control\" required>
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
                      <input type='text' name='reason' class=\"form-control\" required>
                  </div>
              </div>
          </div>
    
          <div class=\"form-group\">
              <label class=\"col-md-4 control-label\"></label>
              <div class=\"col-md-4\">
                  <button type='submit' class='btn btn-warning btn-block'>Add Repair/Update/Upgrade</button>
              </div>
          </div>
      </form>
  </fieldset>
</form>";

    //posts
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getItemType == NULL && $getSubtype == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSubtype == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        $itemType = $_POST['itemType'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type."&itemType=".$itemType);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSerial == NULL){
        $type = $_POST['type'];
        $itemType = $_POST['itemType'];
        $subtype = $_POST['subtype'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type."&itemType=".$itemType."&subtype=".$subtype);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type = $_POST['type'];
        $itemType = $_POST['itemType'];
        $subtype = $_POST['subtype'];
        $serial = $_POST['serialNumber'];
        header("Location: ./addRepairUpdateUpgrade.php?type=".$type."&itemType=".$itemType."&subtype=".$subtype."&serial=".$serial);
    }
}
else{
    header("Location: ./login.php");
}
?>