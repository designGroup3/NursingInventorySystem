<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['delete'];

    $serialSql = "SELECT `Serial Number` FROM inventory WHERE `Inv Id` = '$id';";
    $serialResult = mysqli_query($conn, $serialSql);
    $serialRow = mysqli_fetch_array($serialResult);
    $serialNumber = $serialRow['Serial Number'];
    $serialNumber = str_replace("\\","\\\\","$serialNumber");
    $serialNumber = str_replace("'","\'","$serialNumber");

    $checkoutSql = "SELECT * FROM checkouts WHERE `Serial Number` = '$serialNumber' AND `Return Date` IS NULL;";
    $checkoutResult = mysqli_query($conn, $checkoutSql);
    $checkoutRow = mysqli_num_rows($checkoutResult);
    if($checkoutRow > 0){
        header("Location: ./inventory.php?error=deleteCheckout");
        exit();
    }

    $sql = "SELECT * FROM `inventory` WHERE `Inv Id` = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $item = $row['Item'];

    echo "<head>
              <Title>Delete Inventory</Title>
          </head>
          <div class=\"parent\">
              <button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
                  <i class='fa fa-question'></i>
              </button>
          </div>";

    $checkSql = "SELECT * FROM inventory WHERE `Inv Id` = '$id';";
    $checkResult = mysqli_query($conn, $checkSql);
    if(mysqli_num_rows($checkResult) == 0){
        echo "<br><h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
                  <div style='text-align: center'>
                      <input onclick=\"window.location.href='inventory.php';\" class='btn btn-warning' value='Back'>
                  </div>";
        exit();
    }

    echo "<div class='container'>
              <form action ='includes/deleteInventory.inc.php' class='well form-horizontal' method ='POST'>
                  <h2 align='center'>Are you sure you want to delete ".$item."?</h2><br>
                  <div class=\"form-group\" style='text-align: center;'>
                      <label class=\"col-md-4 control-label\"></label>
                      <div class=\"col-md-4\">
                          <input type='hidden' name='id' value = $id>
                          <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
                          <input onclick=\"window.location.href='inventory.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
                      </div>
                  </div>
              </form>
          </div>";
}
else{
    header("Location: ./login.php");
}
?>