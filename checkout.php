<?php
include 'table.php';
include 'inputJS.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $sql = "SELECT CURDATE();";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $date = $row['CURDATE()'];
    $date = date_format(date_create($date), "m/d/Y");

    echo "<head>
              <Title>Checkout</Title>
          </head>
          <body>
              <div class=\"parent\">
                  <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                      <i class='fa fa-question'></i>
                  </button>
              </div><br/>";

    error_reporting(E_ALL ^ E_NOTICE);
    $statedTypes = array();
    $getType = $_GET['type'];
    $getType = str_replace("%5C","\\","$getType");
    $getType = str_replace("%27","'","$getType");
    if($getType !== NULL && $getType !== ""){
        $getType = str_replace("\\","\\\\","$getType");
        $getType = str_replace("'","\\'","$getType");
        $checkSql = "SELECT * FROM subtypes WHERE `Type` = '$getType';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='checkout.php';\" class='btn btn-warning' value='Back'>
                  </div>";
            exit();
        }
    }

    $getSubtype = $_GET['subtype'];
    $getSubtype = str_replace("%5C","\\","$getSubtype");
    $getSubtype = str_replace("%27","'","$getSubtype");
    if($getSubtype !== NULL && $getSubtype !== ""){
        $getSubtype = str_replace("\\","\\\\","$getSubtype");
        $getSubtype = str_replace("'","\\'","$getSubtype");
        $checkSql = "SELECT * FROM subtypes WHERE `Subtype` = '$getSubtype';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='checkout.php';\" class='btn btn-warning' value='Back'>
                  </div>";
            exit();
        }
    }
    $getItem = $_GET['item'];
    $getItem = str_replace("%5C","\\","$getItem");
    $getItem = str_replace("%27","'","$getItem");
    if($getItem !== NULL && $getItem !== ""){
        $getItem = str_replace("\\","\\\\","$getItem");
        $getItem = str_replace("'","\\'","$getItem");
        $checkSql = "SELECT * FROM inventory WHERE `Item` = '$getItem';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='checkout.php';\" class='btn btn-warning' value='Back'>
                  </div>";
            exit();
        }
    }
    $getSerial = $_GET['serial'];
    $getSerial = str_replace("%5C","\\","$getSerial");
    $getSerial = str_replace("%27","'","$getSerial");
    if($getSerial !== NULL && $getSerial !== ""){
        $getSerial = str_replace("\\","\\\\","$getSerial");
        $getSerial = str_replace("'","\\'","$getSerial");
        $checkSql = "SELECT * FROM inventory WHERE `Item` = '$getItem' AND `Serial Number` = '$getSerial';";
        $checkResult = mysqli_query($conn, $checkSql);
        if(mysqli_num_rows($checkResult) == 0){
            echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='checkout.php';\" class='btn btn-warning' value='Back'>
                  </div>";
            exit();
        }
    }

    $noItem = false;

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=over') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        There are not that many of the item in inventory.</div><br><br><br>";
    }
    elseif(strpos($url, 'error=zero') !== false){
        echo "<div class='alert alert-danger col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        You must checkout at least one unit.</div><br><br><br>";
    }
    elseif(strpos($url, 'checkin') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Item checked-in.</div><br><br><br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<div class='alert alert-success col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-xl-offset-2 
        col-xs-8 col-sm-8 col-md-8 col-xl-8' style='text-align: center'>
        Item checked-out.</div><br><br><br>";
    }

    $sql = "SELECT DISTINCT Type FROM subtypes WHERE `Table` = 'Inventory' ORDER BY Type;";
    $result = mysqli_query($conn, $sql);

    echo '<br><div class="container">
                  <form class="well form-horizontal" id="contact_form" method="POST">
                      <fieldset>
                          <h2 align="center">Which item would you like to checkout?</h2><br>
                              <div class="form-group">
                                  <label class="col-md-4 control-label">Type:
                                      <a style="color:red;" title="This field must be filled">*</a>
                                  </label>
                                  <div class="col-md-4 selectContainer">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="glyphicon glyphicon-th-large"></i>
                                          </span>';
        if($getType == NULL){
            echo '<select required name="type" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        else{
            echo '<select disabled name="type" class="form-control selectpicker" onchange="this.form.submit()">';
        }
        if($getType == NULL){
            echo '<option selected value=""></option>';
        }
        else{
            echo '<option value=""></option>';
        }
    while ($row = mysqli_fetch_array($result)) {
            if($getType !== NULL && $getType !== ""){
                $showType = $getType;
                $showType = str_replace("\'","'","$showType");
                $showType = str_replace("\\\\","\\","$showType");
                echo '<option selected value = "' . $showType . '">' . $showType . '</option>';
            }
            else{
                $showNoQuotesType = $row['Type']; //Allows "
                $showNoQuotesType = str_replace("\"","&quot;","$showNoQuotesType");
                echo '<option value = "' . $showNoQuotesType . '">' . $row['Type'] . '</option>';
            }
    }
    echo '</select>
      </div>
  </div>
</div>';

    //start subtype
    if($getType !== NULL && $getType !== ""){
        $sql = "SELECT Subtype FROM subtypes WHERE Type = '".$getType."' ORDER BY Subtype;";
        $getType = str_replace("\'","%27","$getType");
        $getType = str_replace("\\\\","%5C","$getType");
        $result = mysqli_query($conn, $sql);
        echo '<form class="well form-horizontal" id="contact_form" method="POST">
                  <div class="form-group">
                      <label class="col-md-4 control-label">
                          <input type="hidden" name="type" value = \''.$getType. '\'>
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
        while ($row = mysqli_fetch_array($result)) {
            if($getSubtype !== NULL && $getSubtype !== ""){
                $showSubtype = $getSubtype;
                $showSubtype = str_replace("\'","'","$showSubtype");
                $showSubtype = str_replace("\\\\","\\","$showSubtype");
                echo '<option selected value = "' . $showSubtype . '">' . $showSubtype . '</option>';
            }
            else{
                $showNoQuotesSubtype = $row['Subtype']; //Allows "
                $showNoQuotesSubtype = str_replace("\"","&quot;","$showNoQuotesSubtype");
                echo '<option value = "' . $showNoQuotesSubtype . '">' . $row['Subtype'] . '</option>';
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

    //start item
    if($getSubtype !== NULL && $getSubtype !== ""){
        $sql = "SELECT DISTINCT Item FROM inventory WHERE Subtype = '".$getSubtype."' AND Checkoutable = '1' ORDER BY Item;";
        $getSubtype = str_replace("\'","%27","$getSubtype");
        $getSubtype = str_replace("\\\\","%5C","$getSubtype");
        $result = mysqli_query($conn, $sql);

        echo '<form class="well form-horizontal" id="contact_form" method="POST">
                  <div class="form-group">
                      <label class="col-md-4 control-label">
                          <input type="hidden" name="type" value = \''.$getType. '\'>
                          <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
                          Item:
                          <a style="color:red;" title="This field must be filled">*</a>
                      </label>
                      <div class="col-md-4 selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="glyphicon glyphicon-list"></i>
                              </span>';
        if(mysqli_num_rows($result) == 0){
            echo '<select disabled name="item" class="form-control selectpicker" onchange="this.form.submit()">';
            $noItem = true;
        }

        if($getItem !== NULL && $getItem !== ""){
            echo '<select name="item" disabled class="form-control selectpicker" onchange="this.form.submit()">
                  <option selected value=""></option>';
        }
        else{
            if($noItem){
                echo '<option selected value="">No item with that subtype is checkoutable.</option>';
            }
            else{
                echo '<select name="item" class="form-control selectpicker" onchange="this.form.submit()">
                      <option selected value=""></option>';
            }
        }
        while ($row = mysqli_fetch_array($result)) {
            if($getItem !== NULL && $getItem !== "") {
                $showItem = $getItem;
                $showItem = str_replace("\'", "'", "$showItem");
                $showItem = str_replace("\\\\", "\\", "$showItem");
                echo '<option selected value = "' . $showItem . '">' . $showItem . '</option>';
            }
            else{
                $showNoQuotesItem = $row['Item']; //Allows "
                $showNoQuotesItem = str_replace("\"","&quot;","$showNoQuotesItem");
                echo '<option value = "' . $showNoQuotesItem . '">' . $row['Item'] . '</option>';
            }
        }
        echo '</select>
          </div>
      </div>
  </div>';
    }
    else{
        echo '<div class="form-group">
                  <label class="col-md-4 control-label">Item:
                      <a style="color:red;" title="This field must be filled">*</a>
                  </label> 
                  <div class="col-md-4 selectContainer">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="glyphicon glyphicon-th"></i>
                          </span>
                          <select class="form-control selectpicker" disabled>
                              <option value="">Select a subtype first</option>
                          </select>
                      </div>
                  </div>
              </div>';
    }

    //start Serial
    if($getItem !== NULL && $getItem !== ""){
        $sql = "SELECT `Serial Number` FROM inventory WHERE Item = '".$getItem."' AND Checkoutable = '1' ORDER BY `Serial Number`;";
        $getItem = str_replace("\'","%27","$getItem");
        $getItem = str_replace("\\\\","%5C","$getItem");
        $result = mysqli_query($conn, $sql);

        echo '<form class="well form-horizontal" id="contact_form" method="POST">
                  <div class="form-group">
                      <label class="col-md-4 control-label">
                          <input type="hidden" name="type" value = \''.$getType. '\'>
                          <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
                          <input type="hidden" name="item" value = \''.$getItem. '\'>
                          Serial Number:
                          <a style="color:red;" title="This field must be filled">*</a>
                      </label>
                      <div class="col-md-4 selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="glyphicon glyphicon-tag"></i>
                              </span>
                              <select name="serial" class="form-control selectpicker" onchange="this.form.submit()">
                                  <option selected value=""></option>';

        while ($row = mysqli_fetch_array($result)) {
            if($getSerial !== NULL && $getSerial !== ""){
                $showSerial = $getSerial;
                $showSerial = str_replace("\'","'","$showSerial");
                $showSerial = str_replace("\\\\","\\","$showSerial");
                echo '<option selected value = "' . $showSerial . '">' . $showSerial . '</option>';
            }
            else{
                $showNoQuotesSerial = $row['Serial Number']; //Allows "
                $showNoQuotesSerial = str_replace("\"","&quot;","$showNoQuotesSerial");
                echo '<option value = "' . $showNoQuotesSerial . '">' . $row['Serial Number'] . '</option>';
            }
        }
        echo '</select>
          </form>
      </div>
  </div>
</div>';
    }
    else{
        echo '<div class="form-group">
                  <label class="col-md-4 control-label">Serial Number:
                      <a style="color:red;" title="This field must be filled">*</a>
                  </label> 
                  <div class="col-md-4 selectContainer">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="glyphicon glyphicon-tag"></i>
                          </span>
                          <select class="form-control selectpicker" disabled>
                              <option value="">Select an item first</option>
                          </select>
                      </div>
                  </div>
              </div>';
    }

    //Number in Stock
    if($getSerial !== NULL && $getSerial !== ""){
        $sql = "SELECT `Number in Stock` FROM inventory WHERE `Serial Number` = '".$getSerial."';";
        $getSerial = str_replace("\'","%27","$getSerial");
        $getSerial = str_replace("\\\\","%5C","$getSerial");
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo '<form action ="includes/checkout.inc.php" method="POST">
                  <label>
                      <input type="hidden" name="type" value = \''.$getType. '\'>
                      <input type="hidden" name="subtype" value = \''.$getSubtype. '\'>
                      <input type="hidden" name="item" value = \''.$getItem. '\'>
                      <input type="hidden" name="serial" value = \''.$getSerial. '\'>
                      <div class="form-group">
                          <label class="col-md-4 control-label">Number in Stock:
                              <a style="color:red;" title="This field must be filled">*</a>
                          </label>   
                          <div class="col-md-4 inputGroupContainer">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                      <i class="glyphicon glyphicon-question-sign"></i>
                                  </span>
                                  <input type="number" required class="form-control" min="0" name="stock" value='.$row['Number in Stock'].'>
                              </div>
                          </div>
                      </div>';
    }
    else{
        echo '<div class="form-group">
                  <label class="col-md-4 control-label">Number in Stock:
                      <a style="color:red;" title="This field must be filled">*</a>
                  </label>  
                  <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="glyphicon glyphicon-question-sign"></i>
                          </span>
                          <input class="form-control" required type="number" name="quantity" min="0" max="100" step="1" value="0">
                      </div>
                  </div>
              </div>';
    }

    //Person
    $sql = "SELECT First, Last FROM clients;";
    $result = mysqli_query($conn, $sql);
    echo '<div class="form-group">
              <label class="col-md-4 control-label">Person:
                  <a style="color:red;" title="This field must be filled">*</a>
              </label> 
              <div class="col-md-4 selectContainer">
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="fa fa-users"></i>
                      </span>
                      <select name="person" required class="form-control selectpicker">
                          <option selected value=""></option>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['First']." ".$row['Last'].'">'.$row['First']." ".$row['Last'].'</option>';
    }
    echo '</select>
      </div>
  </div>
</div>';

    //Reason, Notes, Due Date, Checkout Date
    echo "<div class=\"form-group\">
              <label class=\"col-md-4 control-label\">Reason:
                  <a style=\"color:red;\" title=\"This field must be filled\">*</a>
              </label> 
              <div class=\"col-md-4 inputGroupContainer\">
                  <div class=\"input-group\">
                      <span class=\"input-group-addon\">
                          <i class=\"fa fa-question\" aria-hidden=\"true\"></i>
                      </span>
                      <input type='text' required placeholder='Reason' name='reason' class=\"form-control\">
                  </div>
              </div>
          </div>
        
          <div class=\"form-group\">
              <label class=\"col-md-4 control-label\">Notes:</label> 
              <div class=\"col-md-4 inputGroupContainer\">
                  <div class=\"input-group\">
                      <span class=\"input-group-addon\">
                          <i class=\"glyphicon glyphicon-th-large\"></i>
                      </span>
                      <input name=\"notes\" placeholder=\"Notes\" class=\"form-control\" type=\"text\">
                  </div>
              </div>
          </div>
    
          <div class=\"form-group\">
              <label class=\"col-md-4 control-label\">Due Date:
                  <a style=\"color:red;\" title=\"This field must be filled\">*</a>
              </label>
              <div class=\"col-md-4 inputGroupContainer\">
                  <div class=\"input-group\">
                      <span class=\"input-group-addon\">
                          <i class=\"glyphicon glyphicon-calendar\"></i>
                      </span>
                      <input name=\"date\" required placeholder=\"MM/DD/YY\" class=\"form-control\" type=\"date\">
                  </div>
              </div>
          </div>
        
          <div class=\"form-group\">
              <label class=\"col-md-4 control-label\"></label>
              <div class=\"col-md-4\">Checkout Date: 
                  <span>".$date."</span>
              </div>
          </div>";

    if($noItem){
        echo "<br><br><div class=\"form-group\">
                          <label class=\"col-md-4 control-label\"></label>
                          <div class=\"col-md-4\">
                              <button disabled type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
                              data-submit=\"...Sending\">Check-out</button><br><br>
                          </div>
                      </div>
                  </form>
              </fieldset>
          </form>";
    }
    else{
        echo "<br><br><div class='form-group'>
                          <label class='col-md-4 control-label'></label>
                          <div class='col-md-4'>
                              <button type='submit' class=\"btn btn-warning btn-block\" id=\"contact-submit\" 
                              data-submit=\"...Sending\">Check-out</button><br><br>
                          </div>
                      </div>
                  </form>
              </fieldset>
          </form>";
    }

    //posts
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSubtype == NULL && $getItem == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        header("Location: ./checkout.php?type=".$type);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getItem == NULL && $getSerial == NULL){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $getSerial == NULL){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $item = $_POST['item'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype."&item=".$item);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $item = $_POST['item'];
        $serial = $_POST['serial'];
        header("Location: ./checkout.php?type=".$type."&subtype=".$subtype."&item=".$item."&serial=".$serial);
    }

    echo "<br><br><h2 style='text-align: center'>Current Checked-Out Inventories</h2><br>
    <table id=\"example\" class=\"table table-striped table-bordered dt-responsive nowrap\" cellspacing=\"0\" width=\"100%\">
        <thead>
            <th>Print</th>
            <th>Serial Number</th>
            <th>Item</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Quantity Borrowed</th>
            <th>Person</th>
            <th>Update Person</th>
            <th>Checkout Date</th>
            <th>Due Date</th>
            <th>Check-In</th>
        </thead>";

    $sql = "SELECT Id, Item, subtypes.Type, checkouts.Subtype, `Quantity Borrowed`, `Serial Number`, Person, `Update Person`, `Checkout Date`, `Due Date` FROM checkouts JOIN subtypes ON checkouts.Subtype = subtypes.Subtype WHERE `Return Date` IS NULL ORDER BY Id;";
    $result = mysqli_query($conn, $sql);
    $namesCount = 0;
    echo "<tbody>";
    while ($row = mysqli_fetch_array($result)) {
        $serial2 = $row['Serial Number'];
        $serial2 = str_replace("\\","\\\\","$serial2");
        $serial2 = str_replace("'","\'","$serial2");

        $sql2 = "SELECT `Inv Id` FROM inventory WHERE `Serial Number` = '$serial2';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);

        if(date_create($row['Due Date']) < date_create($date)){
            echo "<tr style='background: #d6010c!important;'>";
        }
        else{
            echo "<tr>";
        }
        echo "<td><a href='printCheckout.php?Id=$row[Id]'>Print<br></td>
              <td>".$row['Serial Number']."</td>
              <td>".$row['Item']."</td>
              <td>".$row['Type']."</td>
              <td>".$row['Subtype']."</td>
              <td>".$row['Quantity Borrowed']."</td>
              <td>".$row['Person']."</td>
              <td>".$row['Update Person']."</td>
              <td>".date_format(date_create($row['Checkout Date']),'m/d/Y')."</td>
              <td>".date_format(date_create($row['Due Date']),'m/d/Y')."</td>
              <td><a href='includes/checkin.inc.php?Id=".$row2['Inv Id']."'>Check-In<br></td>
          </tr>";
    }
    echo "</tbody>
      </table>";
}
else{
    header("Location: ./login.php");
}
include 'tableFooter.php';
?>