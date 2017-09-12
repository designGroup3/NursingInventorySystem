<style>
    td, th {
        text-align: left;
        padding: 8px;
    }

</style>

<?php
	//include 'includes/bootstrap.inc.php';
    include 'header.php';
	include 'dbh.php';

	$columnNames= array();
	$outerCount = 0;

	if(isset($_SESSION['id'])) {
        echo "<br>";
        $sql = "SHOW COLUMNS FROM inventory"; //gets headers for page
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            array_push($columnNames, $row['Field']);
        }

        echo "<table class ='inventory'>";
        for ($count = 0; $count < count($columnNames); $count++) {
            echo "<th>$columnNames[$count]</th>";
        }

        if($outerCount < 4){
            $outerCount++;
        $sql = "SELECT * FROM inventory"; //displays headers for page
        //$sql="SELECT inv_id, Item, inventory.Type, types.Subtype FROM inventory JOIN types ON inventory.Subtype = types.subtype ORDER BY inv_id"; //displays headers for page
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";

                for($count = 0; $count< count($columnNames); $count++){
                    $sql2 = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE table_name = 'inventory' AND COLUMN_NAME = '$columnNames[$count]';";
                    $result2 = mysqli_query($conn, $sql2);
                    $rowType = mysqli_fetch_array($result2);

                    if($rowType['DATA_TYPE'] == "tinyint"){ //if column is a boolean
                        if($row[$columnNames[$count]] == 0 && $row[$columnNames[$count]] !== null){
                            echo '<td>No</td>';
                        }
                        elseif($row[$columnNames[$count]] !== null){
                            echo '<td>Yes</td>';
                        }
                        else{
                            echo '<td></td>';
                        }
                    }
                    else{ //if column is a varchar
                        echo '<td> '.$row[$columnNames[$count]].'</td>';
                    }
                }
            }

                echo "<td> <a href='QRCode.php?text=$row[Item]'>Show QR Code<br></td>
                <td> <a href='editInventory.php?edit=$row[inv_id]'>Edit<br></td>
                <td> <a href='deleteInventory.php?id=$row[inv_id]&item=$row[Item]'>Delete<br></td>
                
            </tr>";
            $count++;
        }
        else{

        }

        echo "&nbsp&nbsp<form action='usersTable.php'>
               <input type='submit' value='See Users'/>
              </form>";

        echo "&nbsp&nbsp<form action='newPassword.php'>
                   <input type='submit' value='Change My Password'/>
                  </form>";

        echo "&nbsp&nbsp<form action='addColumn.php'>
               <input type='submit' value='Add Column'/>
              </form>";

    } else {
        $url ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($url, 'error=input') !== false){
            echo "<br> &nbsp Your username or password is incorrect!";
        } else {
            echo "<br> &nbsp Welcome to the PHP System! Please log in or create an account.";
            echo '<br><br>&nbsp<img src="http://www.pngall.com/wp-content/uploads/2016/07/Success-Free-Download-PNG.png"
            width="280" height="125" title="Logo of a company" alt="Logo of a company"/>
            <!--<div class="dropdown">
             <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
               Dropdown
               <span class="caret"></span>
             </button>
             <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
               <li><a href="#">Action</a></li>
               <li><a href="#">Another action</a></li>
               <li><a href="#">Something else here</a></li>
               <li role="separator" class="divider"></li>
               <li><a href="#">Separated link</a></li>
             </ul>
           </div>-->';
        }
    }
?>