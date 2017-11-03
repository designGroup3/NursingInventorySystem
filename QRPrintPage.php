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

echo '<br><br><div class="center">
    <img src=QRCode.php?text='.$serialNumber.' width="135" height="125" title="QR Code" alt="QR Code">
    <br><p class="text">'.$serialNumber.'</p></div><br><br><div class="button">
    <button onClick="window.print()">Print this page</button></div>';

?>