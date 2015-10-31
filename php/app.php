<?php

//データベース接続
try{
    $dbh = new PDO('mysql:dbname=cats_photo;host=localhost', 'root', '');
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$sth = $dbh->query('SET NAMES utf8');

//ユーザー設定
$user_id = isset($_SESSION["user"]) ? $_SESSION["user"][0] : null ;
$user_name = isset($_SESSION["user"]) ? $_SESSION["user"][1] : "ゲストユーザー" ;

//XSS
function h($str){
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

//
function getVotoCount($id){
	global $dbh;
	$this_count = $dbh->query("SELECT `cat_count_good` FROM `cats` where `cat_id` = ".$id)->fetchColum();
	return $this_count;
}

//ページネーション用
function getPagenation($table,$perpage,$where = null,$where_is = null){
	global $dbh;
	$where_sentence = isset($where) ? "where `".$where."` = ". $where_is : "";
	$page = isset($_GET["page"]) && preg_match("/^[1-9]*$/", $_GET["page"]) ? $_GET["page"] : 1;
	$from = ($page - 1) * $perpage;
	$total = $dbh->query("SELECT COUNT(*) FROM `".$table."`".$where_sentence)->fetchColumn();
	$total_pages = ceil($total/$perpage);
	return array("page" => $page, "from" =>$from, "total" => $total, "total_pages" => $total_pages, "perpage" =>$perpage);
}