<?php
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    echo "<br><form action='includes/addRepairUpdateUpgrade.inc.php' method='POST'>
        &nbsp&nbsp<label>Type<br></label>&nbsp&nbsp<select name='type'>
          <option value=''></option>
          <option value='Repair'>Repair</option>
          <option value='Update'>Update</option>
          <option value='Upgrade'>Upgrade</option></select><br><br>
        &nbsp&nbsp<label>Serial Number<br></label>&nbsp&nbsp<select name='serialNumber'>
          <option value=''></option>";
    $sql = "SELECT `Serial Number` FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['Serial Number'].'">'.$row['Serial Number'].'</option>';
    }
    echo "</select><br><br>
        &nbsp&nbsp<label>Part<br></label>&nbsp&nbsp<input type='text' name='part'><br><br>
        &nbsp&nbsp<label>Cost<br></label>&nbsp&nbsp$<input type='number' step='0.01' name='cost'><br><br>
        &nbsp&nbsp<label>Date Performed<br></label>&nbsp&nbsp<input type='date' name='date'><br><br>
        &nbsp&nbsp<label>Supplier<br></label>&nbsp&nbsp<input type='text' name='supplier'><br><br>
        &nbsp&nbsp<label>Reason<br></label>&nbsp&nbsp<input type='text' name='reason'><br><br><br>
        &nbsp&nbsp<button type='submit'>Add Repair/Update/Upgrade</button></form>";
}

else{
    header("Location: ./login.php");
}
?>