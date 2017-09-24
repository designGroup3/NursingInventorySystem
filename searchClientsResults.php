<style>
    td, th {
        text-align: left;
        padding: 8px;
    }
</style>

<?php
include 'header.php';
include 'dbh.php';
if(isset($_SESSION['id'])) {
    $last = $_POST['last'];
    $first = $_POST['first'];
    $ext = $_POST['ext'];
    $email = $_POST['email'];
    $office = $_POST['office'];
    $tableHeadNeeded = true;
    $count = 0;
    $sql = "SELECT * FROM clients WHERE ";
    $andNeeded = false;
    if($last == "" && $first == "" && $ext == "" && $email == "" && $office == ""){
        echo "<br> Please fill out at least 1 search field.";
        echo "<br><br><form action='searchClientsForm.php'> 
                   <input type='submit' value='Search Clients'/>
              </form>";
        exit();
    }
    if($last !== "")
    {
        $sql .= "Last = '".$last."'";
        error_reporting(E_ERROR | E_PARSE); //silences warning that comes up if a string is searched for
        $andNeeded = true;
    }
    if($first !== "")
    {
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "First = '".$first."'";
        $andNeeded = true;
    }
    if($ext !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Ext = ".$ext;
        $andNeeded = true;
    }
    if($email !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Email = '".$email."'";
    }
    if($office !== "")
    {
        error_reporting(E_ERROR | E_PARSE);
        if($andNeeded){
            $sql .= " AND ";
        }
        $sql .= "Office = '".$office."'";
    }
    $sql .=";";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        if($tableHeadNeeded){
            $tableHeadNeeded = false;
            $count++;
            echo "<table><tr><th>Last</th>
            <th>First</th>
            <th>Ext</th>
            <th>Email</th>
            <th>Office</th></tr>";
        }
        echo "<tr>
              <td> ".$row['Last']."</td>
              <td> ".$row['First']."</td>
              <td> ".$row['Ext']."</td>
              <td> ".$row['Email']."</td>
              <td> ".$row['Office']."</td>
              <td> <a href='editClient.php?edit=$row[Number]'>Edit<br></td>
              <td> <a href='deleteClient.php?number=$row[Number]&last=$row[Last]&first=$row[First]'>Delete<br></td>
              </tr><br>";
    }
    if($count == 0) {
        echo "<br> No Items Found That Match All of Those Criteria.<br>";
    }
}
else{
    echo "<br> Please log in to manipulate the database";
}
?>