<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    $id = $_GET['edit'];
    echo "<head><Title>Edit Repair/Update/Upgrade</Title></head>";

    $sql="SELECT * FROM `repairs/updates/upgrades` WHERE Id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo "<form action ='includes/editRepairUpdateUpgrade.inc.php' method ='POST'><br>
            <input type='hidden' name='id' value = $id>
            &nbsp&nbsp<label>Type<br></label>&nbsp&nbsp<select name='type'>
          <option value=''></option>";
          if($row['Type'] == "Repair"){
              echo "<option selected value='Repair'>Repair</option>
              <option value='Update'>Update</option>
              <option value='Upgrade'>Upgrade</option></select><br><br>";
          }
          elseif($row['Type'] == "Update"){
              echo "<option value='Repair'>Repair</option>
              <option selected value='Update'>Update</option>
              <option value='Upgrade'>Upgrade</option></select><br><br>";
          }
          elseif($row['Type'] == "Upgrade"){
              echo "<option value='Repair'>Repair</option>
              <option value='Update'>Update</option>
              <option selected value='Upgrade'>Upgrade</option></select><br><br>";
          }

          echo "&nbsp&nbsp<label>Serial Number:</label><br>&nbsp&nbsp<select name='serialNumber'>";
          $sql2 = "SELECT `Serial Number` FROM inventory";
          $result2 = mysqli_query($conn, $sql2);
          while($row2 = mysqli_fetch_array($result2)) {
              if($row['Serial Number'] === $row2['Serial Number']){
                  echo '<option selected value = "'.$row2['Serial Number'].'">'.$row2['Serial Number'].'</option>';
              }
              else{
                  echo '<option value = "'.$row2['Serial Number'].'">'.$row2['Serial Number'].'</option>';
              }
          }

          echo "</select><br><br>
          &nbsp&nbsp<label>Part<br></label>&nbsp&nbsp<input type='text' name='part' value='".$row['Part']."'><br><br>
          &nbsp&nbsp<label>Cost<br></label>&nbsp&nbsp$<input type='number' step='0.01' name='cost'  value='".$row['Cost']."'><br><br>
          &nbsp&nbsp<label>Date Performed<br></label>&nbsp&nbsp<input type='date' name='date' value='".$row['Date']."'><br><br>
          &nbsp&nbsp<label>Supplier<br></label>&nbsp&nbsp<input type='text' name='supplier'  value='".$row['Supplier']."'><br><br>
          &nbsp&nbsp<label>Reason<br></label>&nbsp&nbsp<input type='text' name='reason' value='".$row['Reason']."'><br><br><br>
          &nbsp&nbsp<button type='submit'>Edit Repair/Update/Upgrade</button></form>";
}
else{
    header("Location: ./login.php");
}
?>