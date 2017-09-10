<?php

//include 'includes/bootstrap.inc.php';
include 'header.php';
include 'dbh.php';

if(isset($_SESSION['id'])) {
    echo "
            <form action ='includes/addColumn.inc.php' method = 'POST'><br>
                &nbsp&nbsp<label>Name: </label><br>&nbsp&nbsp<input type='text' name='name'><br><br>
                &nbsp&nbsp<label>Data Type: </label><br>&nbsp&nbsp<select name ='type'>
                <option value='varchar'>Letters & Numbers</option>
                <option value='tinyint'>Yes or No</option></select><br><br>
                &nbsp&nbsp<button type='submit'>Add Column</button>
             </form>";
}
else{
    echo "<br> Please log in to manipulate the database";
}

?>