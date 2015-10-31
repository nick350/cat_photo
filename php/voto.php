<?php
require_once("app.php");
if (
    !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
    && (!empty($_SERVER['SCRIPT_FILENAME']) && 'json.php' === basename($_SERVER['SCRIPT_FILENAME']))
    ) 
{
    die ();
}


$cat_id = $_POST["cat_id"];
$count = $_POST["count"];
$cookie_name = "voto_" . $cat_id;
$cookie_time = time() + 86400;

     if(!isset($_COOKIE[$cookie_name])){
          $query = "UPDATE cats SET `cat_count_good` = ? where cat_id = ?";
          $sth = $dbh->prepare($query);
          $sth->bindParam(1, $count, PDO::PARAM_INT);
          $sth->bindParam(2, $cat_id, PDO::PARAM_INT);
          $sth->execute();

          setcookie($cookie_name, $count, $cookie_time);

          echo "「にゃー」しました！";
     }else{
          echo "24時間内は「にゃー」できません";
     }