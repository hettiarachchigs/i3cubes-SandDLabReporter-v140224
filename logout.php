<?php

session_start();
require_once("lib/config.php");
session_destroy();
$url= APP_URL.'/index';
header('Location: '.$url);
?>

