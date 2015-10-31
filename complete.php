<?php require_once("parts/header.php");?>
	<div class="top_img"><img src="images/top.jpg"></div>
	<h2>登録完了画面</h2>
	<section>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$nickname = $_POST["nickname"];
	$mail = $_POST["mail"];
	$password = $_POST["password"];
	$msg = "";

	$query = "INSERT INTO  `users` (`nickname`, `mail`, `password`) VALUES (?, ?, ?);";
	$sth = $dbh->prepare($query);
	$sth->bindParam( 1, $nickname, PDO::PARAM_STR );
	$sth->bindParam( 2, $mail, PDO::PARAM_STR );
	$sth->bindParam( 3, $password, PDO::PARAM_STR );
	$result = $sth->execute();
	if($result){
		$msg = "<p class='correct'>登録完了しました。当サイトをぜひともご活用ください</p>";
		/*テスト用のためコメントアウト
			mb_language("Japanese");
			mb_internal_encoding("UTF-8");

			mb_send_mail($forget_mail, "ねこ写真共有サイト　登録ありがとうございます", "こんにちは".$nickname."さん\r\nご登録ありがとうございます。ぜひとも当サイトをご利用ください。", "From: test@example.com")
		*/
	} else{
		$msg = "<p class='alert'>登録に失敗しました。管理者にお問い合わせください</p>";
	}
}else{
	$msg = "<p class='alert'><a href='register.php'>失礼ですが、最初から登録を行なってください。</a></p>";
}
echo $msg;
require_once("parts/footer.php");?>
	</section>