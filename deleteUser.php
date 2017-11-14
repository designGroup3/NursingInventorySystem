<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = $id;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $uid = $row['uid'];

    echo "<head><Title>Delete User</Title></head><div class=\"parent\"><button class=\"help\" onclick=\"window.location.href='http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf'\">
        <i class='fa fa-question'></i></button></div>";

    echo "<div class=\"container\">
          <form action ='includes/deleteUser.inc.php' method ='POST' class=\"well form-horizontal\" id=\"contact_form\">
          <fieldset><h3 align=\"center\">Are you sure you want to delete $uid?</h3>
          <p align=\"center\" style=\"color:red;\">*This action cannot be undone.</p><br/>
          <input type='hidden' name='id' value = $id>
          <div class=\"form-group\" style='text-align: center;'><label class=\"col-md-4 control-label\"></label>
          <div class=\"col-md-4\"><input type='hidden' name='id' value = $id>
          <input type=\"submit\" class=\"btn btn-danger\" value='Yes'>
          <input onclick=\"window.location.href='usersTable.php';\" class=\"btn btn-warning\" style='width:45px;' value='No'>
          </span></form></div></div></div>";
}
else{
    header("Location: ./login.php");
}
?>