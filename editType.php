<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';
    echo "<head><Title>Edit Type</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspA type already exists by that name.<br>";
    }
    elseif(strpos($url, 'error=both') !== false){
        echo "<br>&nbsp&nbspA type cannot be both checkoutable and consumable.<br>";
    }
    elseif(strpos($url, 'success') !== false){
        echo "<br>&nbsp&nbspType changed successfully.<br>";
    }

    $sql = "SELECT DISTINCT Type FROM subtypes";
    $result = mysqli_query($conn, $sql);

    echo '<br>&nbsp&nbspWhich type to you want to edit?
    
    <form method="post">
        <label>
            <br>&nbsp&nbsp<select name="type" onchange="this.form.submit()">
                <option selected value=""></option>';
                while($row = mysqli_fetch_array($result)) {
                    echo '<option value = "'.$row['Type'].'">'.$row['Type'].'</option>';
                }
                echo '</select></label></form>';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $oldType = $_POST['type'];
        $isCheckoutable = FALSE;
        $isConsumable = FALSE;

        if (strpos($oldType, ' ')) {
            $oldType = str_replace(" ", "%20", $oldType);
        }

        $sql = "SELECT IsCheckoutable, IsConsumable FROM subtypes WHERE Type = '".$oldType."';";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
            $isCheckoutable = $row['IsCheckoutable'];
            $isConsumable = $row['IsConsumable'];
        }

        echo "<br><form action ='includes/editType.inc.php' method = 'POST'><br>
        <input type='hidden' name='oldType' value = $oldType>";
        if (strpos($oldType, '%20')) {
            $oldType = str_replace("%20", " ", $oldType);
        }
        echo "&nbsp&nbsp<label>Type Name: </label><br>&nbsp&nbsp<input type='text' name='newType' value='". $oldType. "'><br><br>
            &nbsp&nbsp<input type='checkbox' name='IsCheckoutable' value='1'
            ";
            if($isCheckoutable == 1){
                echo "checked";
            }
            echo"> This type of item can be checked-out<br><br>
            &nbsp&nbsp<input type='checkbox' name='IsConsumable' value='1'
            ";
            if($isConsumable == 1){
                echo "checked";
            }
            echo"> This type of item can be consumed<br><br>
            &nbsp&nbsp<button type='submit'>Edit Type</button>
        </form>";
    }
}
else{
    header("Location: ./login.php");
}
?>