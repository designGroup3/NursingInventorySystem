<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    include 'dbh.php';

    $columnNames = array();

    echo "<head><Title>Add Consumable</Title></head>";

    $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, 'error=exists') !== false){
        echo "<br>&nbsp&nbspAn item already exists by that name.<br>";
    }
    elseif(strpos($url, 'error=typeMismatch') !== false){
        $subtype= $_GET['subtype'];
        $type= $_GET['type'];
        echo "<br>&nbsp&nbspThe subtype $subtype already relates to the type $type. Subtypes can only have one type.<br>";
    }
    elseif(strpos($url, 'empty') !== false){
        echo "<br>&nbsp&nbspYou must name the item.<br>";
    }

    $sql="SHOW COLUMNS FROM consumables";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        array_push($columnNames, $row['Field']);
    }

    echo "<form action ='includes/addConsumable.inc.php' method = 'POST'><br>";
    for($count = 0; $count< count($columnNames); $count++){
        if($columnNames[$count] != "Last Processing Date" && $columnNames[$count] != "Last Processing Person") { //Last processing date & person should not be editable
            $isSelect = false;
            $columnName = $columnNames[$count];
            $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE table_name = 'consumables' AND COLUMN_NAME = '$columnNames[$count]';";
            $result2 = mysqli_query($conn, $sql2);
            $rowType = mysqli_fetch_array($result2);
            if ($rowType['DATA_TYPE'] == "tinyint") {
                $isSelect = true;
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<select name=";
            } elseif ($rowType['DATA_TYPE'] == "int") {
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='number' min='0' name=";
            } else {
                $inputs = "&nbsp&nbsp<label>$columnNames[$count]</label> <br>&nbsp&nbsp<input type='text' name=";
            }
            if (strpos($columnName, ' ')) {
                $columnName = str_replace(" ", "", $columnName);
            }
            if ($isSelect) {
                $inputs .= $columnName . ">";
                if ($count == 1) {
                    $sql3 = "SELECT Subtype FROM subtypes WHERE isConsumable = 1";
                    $result3 = mysqli_query($conn, $sql3);
                    while ($SubtypeRow = mysqli_fetch_array($result3)) {
                        $inputs .= "<option value= '".$SubtypeRow['Subtype']."'>".$SubtypeRow['Subtype']."</option>";
                    }
                    $inputs .= "</select><br><br>";
                } else {
                    $inputs .= "<option value= 0>No</option><option value= 1>Yes</option></select><br><br>";
                }
            } else {
                $inputs .= $columnName . " value='".$row[$columnNames[$count]]."'><br><br>";
            }

            if($count == 1){
                $inputs.= "&nbsp&nbsp<label>Type</label><br>&nbsp&nbsp<input type='text' name='type'><br><br>";
            }
            echo $inputs;
        }
    }
    echo"&nbsp&nbsp<button type='submit'>Add to Consumables</button></form>";
}

else{
    header("Location: ./login.php");
}
?>