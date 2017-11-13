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
        margin-left:auto;
        margin-right:auto;
        text-align: center;
    }
</style>

<?php
include 'header.php';

$serialNumber = $_GET['serialNumber'];

echo '<div class="parent"><button class=\'help\' onclick="window.location.href=\'http://flowtime.be/wp-content/uploads/2016/01/Naamloosdocument.pdf\'">
        <i class=\'fa fa-question\'></i></button></div><br><br><div class="center">
    <img src=QRCode.php?text='.$serialNumber.' width="135" height="125" title="QR Code" alt="QR Code">
    <br><p class="text">'.$serialNumber.'</p></div><br><br><div class="button">
    <button class="btn btn-warning" onClick="window.print()">Print this page</button></div>';

?>