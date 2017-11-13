<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Search Repairs/Updates/Upgrades</Title></head><div class=\"parent\"><button class='help' onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "<br>&nbsp&nbspEnter what criteria you would like to see any matching repairs/updates/upgrades for.
        <form action ='searchRepairsUpdatesUpgradesResults.php' method ='POST'><br>
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
    echo "</select><br><br>&nbsp&nbsp<label>Item<br></label>&nbsp&nbsp<select name='item'>
          <option value=''></option>";
    $sql = "SELECT Item FROM inventory";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        echo '<option value = "'.$row['Item'].'">'.$row['Item'].'</option>';
    }
    echo "</select><br><br>
        &nbsp&nbsp<label>Part<br></label>&nbsp&nbsp<input type='text' name='part'><br><br>
        &nbsp&nbsp<label>Cost<br></label>&nbsp&nbsp$<input type='number' min='0' step='0.01' name='cost'><br><br>
        &nbsp&nbsp<label>Date Performed<br></label>&nbsp&nbsp<input type='date' name='date'><br><br>
        &nbsp&nbsp<label>Supplier<br></label>&nbsp&nbsp<input type='text' name='supplier'><br><br>
        &nbsp&nbsp<label>Reason<br></label>&nbsp&nbsp<input type='text' name='reason'><br><br><br>
        &nbsp&nbsp<button type='submit'>Search Repair/Update/Upgrade</button></form>";
}
else{
    header("Location: ./login.php");
}
?>