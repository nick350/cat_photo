<?php
session_start();
require_once("/php/app.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ねこ写真共有サイト</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/voto.js" type="text/javascript"></script>
	<!--[if lt IE 9]> 
	<script src="js/html5shiv.js"></script>
	<script type="text/javascript">
    	document.createElement('main');
	</script>
	<![endif]-->
</head>
<body>
	<div class="container">
	<header>
		<h1>schoo web-campasの課題　かわいいねこの写真を共有するするサイトです。</h1>
		<!--ヘッダーロゴ画像 http://www.ac-illust.com/main/detail.php?id=226660&word=%E3%83%8F%E3%83%BC%E3%83%88%E3%81%AE%E3%81%AD%E3%81%93%E3%81%95%E3%82%93-->
		<a href="index.php"><h2></h2></a>
		<nav>
			<a href="about.php"><li>サイトについて</li></a>
			<a href="mypage.php"><li>マイページ</li></a>
			<a href="cats.php"><li>ねこちゃん一覧</li></a>
			<a href="index.php"><li>トップ</li></a>
		</nav>
	</header>
	<div class="content">
	<main>