<?php

header('Content-Type: image/png');

require_once 'vendor/autoload.php';

if(isset($_GET['text'])){
    $URL = 'http://' . $_SERVER['HTTP_HOST'];

    $size = isset($_GET['size']) ? $_GET['size'] : 200;
    $padding = isset($_GET['padding']) ? $_GET['padding'] : 10;

    $qr = new Endroid\QrCode\QrCode();

    $qr->setText($URL."/nursinginventorysystem/QRLandingPage.php?show=".$_GET['text']);
    $qr->setSize($size);
    $qr->setPadding($padding);

    $qr->render();
}
?>