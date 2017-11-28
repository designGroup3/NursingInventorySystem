<style>
    .center {
        margin: auto;
        width: 136px;
        background-color: white;
    }

    .text{
        text-align: center;
    }

    .button{
        text-align: center;
    }
</style>

<?php
include 'header.php';

$id = $_GET['id'];

$sql = "SELECT * FROM inventory WHERE `Inv Id` = $id;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if(mysqli_num_rows($result) == 0){
    echo "<br>
        <h3 style='text-align: center'>Sorry, some information got lost along the way. Please go back and try again.</h3><br>
        <div style='text-align: center'>
            <input onclick=\"window.location.href='inventory.php';\" class='btn btn-warning' value='Back'>
        </div>";
    exit();
}

$serialNumber = $row['Serial Number'];

echo '<head><Title>Print QR Code</Title></head><div class="parent"><button class=\'help\' style="height:26px;" onclick="window.location.href=\'http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf\'">
        <i class=\'fa fa-question\'></i></button></div><br><br><div class="center">
    <img src=QRCode.php?text='.$id.' width="135" height="125" title="QR Code" alt="QR Code">
    <br><p class="text">'.$serialNumber.'</p></div><br><br><div class="button">
    <button class="btn btn-warning" style="text-align: center" onClick="window.print()">Print this page</button></div>';

?>