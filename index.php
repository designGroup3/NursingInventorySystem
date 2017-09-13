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

	//$firstColumnNames= array();
	//$secondColumnNames = array();
    $columnNames= array();
	$outerCount = 0;

	if(isset($_SESSION['id'])) {
        echo "<br>";
        echo "<table class ='inventory'>";

        $sql = "SHOW COLUMNS FROM inventory"; //gets first headers for page
        $result = mysqli_query($conn, $sql);
        $innerCount = 0;
        while ($row = mysqli_fetch_array($result)) {
            if ($innerCount < 3) {
                $innerCount++;
                array_push($columnNames, $row['Field']);
            }
        }
        array_push($columnNames,"Subtype"); //from Type table
        $sql = "SHOW COLUMNS FROM inventory"; //gets second headers for page
        $result = mysqli_query($conn, $sql);
        $innerCount = 0;
        while ($row = mysqli_fetch_array($result)) {
            $innerCount++;
            if ($innerCount > 3) {
                array_push($columnNames, $row['Field']);
            }
        }

        for ($count = 0; $count < count($columnNames); $count++) {
            echo "<th>$columnNames[$count]</th>";
        }
        for($bigCount = 0; $bigCount < count($columnNames); $bigCount++){
            echo "<tr>";

            $sql = "SELECT inv_id, Item, inventory.Type, types.Subtype FROM inventory JOIN types ON inventory.Type = types.Type ORDER BY inv_id"; //display first four columns
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                $done = false;
                $done2 = false;
                for ($count = 0; $count <count($columnNames); $count++) {
                    if($bigCount < 4 && !$done) {
                        for($innerCount = 0; $innerCount < 4; $innerCount++){
                            echo '<td> ' . $row[$columnNames[$innerCount]] . '</td>';
                            $done = true;
                        }
                    }
                    else if($count >= 4 && !$done2){
                        echo " Count >4: ". $count;
                        $sql = "SELECT * FROM inventory"; //display later columns
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result)) {
                            for ($innerCount = 0; $innerCount <count($columnNames); $innerCount++) {
                                if($count >= 4){
                                    echo '<td> ' . $row[$columnNames[$count]] . '</td>';
                                    $done2 = true;
                                }
                            }
                        }
                    }
                }
                echo "</tr>";
            }

//            else{
//                $sql = "SELECT * FROM inventory"; //display later columns
//                $result = mysqli_query($conn, $sql);
//
//                while ($row = mysqli_fetch_array($result)) {
//                    for ($count = 0; $count <count($columnNames); $count++) {
//                        if($count >= 4){
//                            echo '<td> ' . $row[$columnNames[$count]] . '</td>';
//                            echo "</tr>";
//                        }
//                    }
//                }
//            }


    //        echo "<td> <a href='QRCode.php?text=$row[Item]'>Show QR Code<br></td>
    //                <td> <a href='editInventory.php?edit=$row[inv_id]'>Edit<br></td>
    //                <td> <a href='deleteInventory.php?id=$row[inv_id]&item=$row[Item]'>Delete<br></td>";
    //        }
    //
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