<?php require_once("parts/header.php");
	
	//メッセージを初期化
	$msg = "";
	
	if(isset($_POST["forget_mail"])){
		$forget_mail = h($_POST["forget_mail"]);

		$chk = $dbh->query("SELECT COUNT(*) FROM `users` WHERE `mail` = '".$forget_mail."'")->fetchColumn();
		if($chk == 0){
			$msg = "<p class='alert'>このメールアドレスは登録がありません。</p>";
		} else {
			//新パスワード生成
			$new_password = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);

			//メールが送れなかったときの場合に備えてトランザクション処理
			//$dbh->beginTransaction();
			$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
			$query = "UPDATE users SET `password` = ? where `mail` = ?";
			$sth = $dbh->prepare($query);
			$sth->bindParam(1, $hashed_password, PDO::PARAM_STR);
			$sth->bindParam(2, $forget_mail, PDO::PARAM_STR);
			$result = $sth->execute();

			/*テスト用のためコメントアウト　代わりに直接表示
			mb_language("Japanese");
			mb_internal_encoding("UTF-8");

			if (mb_send_mail($forget_mail, "ねこ写真共有サイト　パスワード再送信", "新しいパスワードは".$new_password."です。", "From: test@example.com") && $result) {
				$msg = "<p class='correct'>登録時に設定したメールアドレスに新しいパスワードを送信しました。</p>";
			} else {
				$dbh->rollBack();
				$msg = "<p class='alert'>エラーが起きました。お手数ですが、管理者にお問い合わせください。</p>";
			}*/

			$msg = "<p class='correct'>新しいパスワードは、".$new_password."です。";
		}
	}
?>


<div class="top_img"><img src="images/top.jpg"></div>
	<h2>パスワード再発行</h2>
	<section class="forget_password">
	<?=$msg;?>
	<p>パスワードをお忘れの方は、こちからにメールアドレスを記入し、送信を押してください。<br>設定したメールアドレスにパスワードを送信いたします。</p>

	<form action="" method="POST" class="register_form">
		<input type="email" name="forget_mail" value="">
		<button type="submit">パスワードを送信</button> 
	</form>
	</section>

<?php require_once("parts/footer.php");?>