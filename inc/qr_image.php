<?php
include_once '../lib/phpqrcode/qrlib.php';

    // outputs image directly into browser, as PNG stream
    QRcode::png($_REQUEST['string'],false,"",8);
?>