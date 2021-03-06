<?php
include 'header.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    echo '<head>
              <Title>Add Inventory</Title>
          </head>
          <div class="parent">
              <button class="help" onclick="window.location.href=\'./UserManual.pdf#page=33\'">
                  <i class=\'fa fa-question\'></i>
              </button>
          </div>';

    $columnNames = array();

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              An item with that serial number already exists.</div><br><br><br>";
    }
    elseif(strpos($url, 'error=typeMismatch') !== false){
        $subtype= $_GET['subtype'];
        $type= $_GET['type'];
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              The subtype $subtype already relates to the type $type. Subtypes can only have one type.</div><br><br><br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              You must name the item.</div><br><br><br>";
    }
    elseif(strpos($url, 'noSerial') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              An item must have a serial number to be checkoutable.</div><br><br><br>";
    }
    elseif(strpos($url, 'manySerial') !== false){
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              There can only be 0 or 1 of an item with a serial number.</div><br><br><br>";
    }
    elseif(strpos($url, 'sameType') !== false){
        $subtype= $_GET['subtype'];
        echo "<br><div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
              col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
              The subtype $subtype is used in the consumables table. Subtypes can only be used in one table.</div><br><br><br>";
    }

    $sql="SHOW COLUMNS FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<div class='container'>
              <form class='well form-horizontal' action ='includes/addInventory.inc.php'
              method = 'POST' id='contact_form'><br>
                  <fieldset>
                      <h1 align=\"center\">Add Item to Inventory</h1>
                      <p style=\"color:red; font-size:10px;\" align=\"center\">* required field</p><br>";

    for($count = 1; $count< count($columnNames); $count++){
        if($columnNames[$count] != "Last Processing Date" && $columnNames[$count] != "Last Processing Person") { //Last processing date & person should not be editable
            $isSelect = false;
            $columnName = $columnNames[$count];
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if ($rowType['DATA_TYPE'] == "tinyint" || $count == 3){
                $isSelect = true;
                if($count == 3){
                    $inputs = "<div class=\"form-group\">
                                   <label class=\"col-md-4 control-label\">Subtype:
                                       <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                                   </label>  
                                   <div class=\"col-md-4 inputGroupContainer\">
                                       <div class=\"input-group\">
                                           <span class=\"input-group-addon\">
                                               <i class=\"glyphicon glyphicon-th\"></i>
                                           </span>
                                           <input style='height:30px; width:100%;' list='Subtypes' required placeholder='   Subtype' name=";
                }
                elseif($count == 6){
                    $inputs = '<div class="form-group">
                                   <label class="col-md-4 control-label">Checkoutable?
                                       <a style="color:red;" title="This field must be filled">*</a>
                                   </label>
                                   <div class="col-md-4 inputGroupContainer">
                                       <div class="input-group">
                                           <span class="input-group-addon">
                                               <i class="glyphicon glyphicon-ok"></i>
                                           </span>
                                           <select required class="form-control selectpicker" name=';
                }
                else{
                    $inputs = "<div class='form-group'>
                                   <label class='col-md-4 control-label'>$columnNames[$count]:</label>
                                   <div class=\"col-md-4 inputGroupContainer\">
                                       <div class=\"input-group\">
                                           <span class=\"input-group-addon\">
                                               <i class=\"glyphicon glyphicon-th-list\"></i>
                                           </span>
                                           <select class=\"form-control selectpicker\" name=";
                }
            } elseif($rowType['DATA_TYPE'] == "int") {
                $inputs = '<div class="form-group">
                               <label class="col-md-4 control-label">Number in Stock:
                                   <a style="color:red;" title="This field must be filled">*</a>
                               </label>
                               <div class="col-md-4 inputGroupContainer">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           <i class="glyphicon glyphicon-question-sign"></i>
                                       </span>
                                       <input type="number" required placeholder="Number in Stock" min="0" class="form-control" name=';
            } else {
                if($count == 1){
                    $inputs = "<div class=\"form-group\">
                                   <label class=\"col-md-4 control-label\">Serial Number:</label>
                                   <div class=\"col-md-4 inputGroupContainer\">
                                       <div class=\"input-group\">
                                           <span class=\"input-group-addon\">
                                               <i class=\"glyphicon glyphicon-tag\"></i>
                                           </span>
                                           <input type='text' placeholder='Serial Number' class=\"form-control\" name=";
                }
                elseif($count == 2){
                    $inputs = "<div class=\"form-group\">
                                   <label class=\"col-md-4 control-label required\">Item:
                                       <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                                   </label> 
                                   <div class=\"col-md-4 inputGroupContainer\">
                                       <div class=\"input-group\">
                                           <span class=\"input-group-addon\">
                                               <i class=\"glyphicon glyphicon-info-sign\"></i>
                                           </span>
                                           <input type='text' required placeholder=\"Item Name\" class=\"form-control\" name=";
                }
                elseif($count == 4){
                    $inputs = "<div class=\"form-group\">
                                   <label class=\"col-md-4 control-label\">Assigned to:
                                       <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                                   </label>
                                   <div class=\"col-md-4 inputGroupContainer\">
                                       <div class=\"input-group\">
                                           <span class=\"input-group-addon\">
                                               <i class=\"glyphicon glyphicon-user\"></i>
                                           </span>
                                           <select name=\"Assignedto\" required class=\"form-control selectpicker\">
                                               <option selected value=''></option>
                                               <option value='Surplus'>Surplus</option>";

                    $clientSql = "SELECT First, Last FROM clients;";
                    $clientResult = mysqli_query($conn, $clientSql);
                    while ($clientRow = mysqli_fetch_array($clientResult)) {
                        $inputs .= '<option value = "'.$clientRow['Last'].", ".$clientRow['First'].'">'.$clientRow['Last'].", ".$clientRow['First'].'</option>';
                    }
                                    $inputs .= "</select>
                                      </div>
                                  </div>
                              </div>";
                }
                elseif($count == 5){
                    $inputs = '<div class="form-group">
                                   <label class="col-md-4 control-label">Location:
                                       <a style="color:red;" title="This field must be filled">*</a>
                                   </label>
                                   <div class="col-md-4 inputGroupContainer">
                                       <div class="input-group">
                                           <span class="input-group-addon">
                                               <i class="glyphicon glyphicon-home"></i>
                                           </span>
                                           <input type="text" required placeholder="Item\'s Location" class=\'form-control\' name=';
                }
                elseif($count == 8){
                    $inputs = '<div class="form-group">
                                   <label class="col-md-4 control-label">MAC Address:
                                       <p style="color:red; font-size:10px;">to view an example, hover over the field</p>
                                   </label> 
                                   <div class="col-md-4 inputGroupContainer">
                                       <div class="input-group">
                                           <span class="input-group-addon">
                                               <i class="fa fa-microchip"></i>
                                           </span>
                                           <input placeholder="MAC Address" title="MAC address should look like 00-15-E9-2B-99-3C"
                                           class="form-control" type="text" name="MACAddress" data-fv-mac="true">
                                       </div>
                                   </div>
                               </div>';
                }
                elseif($count == 9){
                    $inputs = '<div class="form-group">
                                   <label class="col-md-4 control-label">IP Address:
                                       <p style="color:red; font-size:10px;">to view an example, hover over the field</p>
                                   </label>   
                                   <div class="col-md-4 inputGroupContainer">
                                       <div class="input-group">
                                           <span class="input-group-addon">
                                               <i class="fa fa-address-book"></i>
                                           </span>
                                           <input placeholder="IP Address" title="IP addresses (IPv4) look like four blocks of digits ranging from 0 to 255 separated by a period like 192.168.0.255" 
                                           class="form-control" type="text" name="IPAddress" data-fv-mac="true">
                                       </div>
                                   </div>
                               </div>';
                }
                else{
                    $inputs = "<div class=\"form-group\">
                                   <label class=\"col-md-4 control-label\">$columnNames[$count]:</label>
                                       <div class=\"col-md-4 inputGroupContainer\">
                                           <div class=\"input-group\">
                                               <span class=\"input-group-addon\">
                                                   <i class=\"glyphicon glyphicon-info-sign\"></i>
                                               </span>
                                               <input type=\"text\" placeholder='$columnNames[$count]' class='form-control' name=";
                }
            }
            if (strpos($columnName, ' ')) {
                $columnName = str_replace(" ", "", $columnName);
            }
            if ($isSelect) {
                $inputs .= $columnName."><datalist id=\"Subtypes\">";
                if ($count == 3) {
                    $sql3 = "SELECT Subtype FROM subtypes WHERE `Table` = 'Inventory'";
                    $result3 = mysqli_query($conn, $sql3);
                    while ($SubtypeRow = mysqli_fetch_array($result3)) {
                        $inputs .= "<option value= '" . $SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
                    }
                    $inputs .= "</datalist>
                            </div>
                        </div>
                    </div>
                    <div class=\"form-group\">
                        <label class=\"col-md-4 control-label\">Type:
                            <a style=\"color:red;\" title=\"This field must be filled\">*</a>
                        </label>
                        <div class=\"col-md-4 inputGroupContainer\">
                            <div class=\"input-group\">
                                <span class=\"input-group-addon\">
                                    <i class=\"glyphicon glyphicon-th-large\"></i>
                                </span>
                                <input style='height:30px; width:100%;' list='Types' required placeholder='   Type' name='type'>
                                <datalist id=\"Types\">";
                    $sql4 = "SELECT DISTINCT Type FROM subtypes WHERE `Table` = 'Inventory'";
                    $result4 = mysqli_query($conn, $sql4);
                    while ($TypeRow = mysqli_fetch_array($result4)) {
                        $inputs .= "<option value= '" . $TypeRow['Type']."'>".$TypeRow['Type']."</option>";
                    }
                    $inputs .= "</datalist>
                            </div>
                        </div>
                    </div>";
                } else {
                    $inputs .= "<option value =''></option>
                                <option value= 0>No</option>
                                <option value= 1>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>";
                }
            } else {
                if($columnName != "MACAddress" && $columnName != "IPAddress" && $columnName != "Assignedto"){
                    $inputs .= $columnName . " value=" . $row[$columnNames[$count]] . ">
                               </div>
                           </div>
                       </div>";
                }
            }
            echo $inputs;
        }
    }
    echo "<div class=\"form-group\">
              <label class=\"col-md-4 control-label\"></label>
              <div class=\"col-md-4\">
                  <button type='submit' class='btn btn-warning btn-block'>Add to Inventory</button>
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