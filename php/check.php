<?php
require_once("app.php");
if (
    !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
    && (!empty($_SERVER['SCRIPT_FILENAME']) && 'json.php' === basename($_SERVER['SCRIPT_FILENAME']))
    ) 
{
    die ();
}

$item = $_POST["item"];
$value = $_POST["value"];

if($item == 1){
    $chk = $dbh->query("SELECT COUNT(*) FROM `users` WHERE `nickname` = '".$value."'")->fetchColumn();
} elseif ($item == 2) {
    $chk = $dbh->query("SELECT COUNT(*) FROM `users` WHERE `mail` = '".$value."'")->fetchColumn();
}

    echo $chk;

//echo $query;

