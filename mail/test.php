<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../connect.php';
include __DIR__ . '/mailer.php';  // now matches the renamed file

getAllData("users","1 = 1");


?>
