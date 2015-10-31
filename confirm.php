<?php
require_once("parts/header.php");

require_once('php/password.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["nickname"]) && !empty($_POST["mail"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])){
	$nickname = $_POST["nickname"];
	$mail = $_POST["mail"];
	$password1 = $_POST["password1"];
	$password2 = $_POST["password2"];
	$msg = "";

	//register時点でチェックをかけているが、JSが無効の場合の対策
	$chk1 = $dbh->query("SELECT COUNT(*) FROM `users` WHERE `nickname` = '".$nickname."'")->fetchColumn();
	$chk2 = $dbh->query("SELECT COUNT(*) FROM `users` WHERE `mail` = '".$mail."'")->fetchColumn();
	$chk3 = false;
	if($password1 == $password2){
		$chk3 = true;
	}

	if($chk1 != 0){
		$msg = "<p class='alert'>ニックネームが登録されています。<a href='javascript:history.back();'>戻って変更を行なってください。</a></p>";
	}elseif($chk2 != 0){
		$msg = "<p class='alert'>メールが登録されています。<a href='javascript:history.back();'>戻って変更を行なってください。</a></p>";
	}elseif(!$chk3){
		$msg = "<p class='alert'>パスワードが不一致です。<a href='javascript:history.back();'>戻って変更を行なってください。</a></p>";
	}else{

		$hidden_password = "";
		for ($i=0; $i < mb_strlen($password1); $i++) { 
			$hidden_password .= "●";
		}
		$hashed_password = password_hash($password1, PASSWORD_DEFAULT);
?>
	<div class="top_img"><img src="images/top.jpg"></div>

	<h2>確認画面</h2>
	<section class="comfirm">
	<div>以下の内容で登録します。</div>
	<dl>
		<dt>ニックネーム</dt>
        <dd><?=h($nickname);?></dd>
    </dl>
    <dl>
        <dt>メールアドレス</dt>
        <dd><?=h($mail);?></dd>
    </dl>
    <dl>
        <dt>パスワード</dt>
        <dd><?=h($hidden_password);?></dd>
    </dl>

	<form action="complete.php" method="POST">
		<input type="hidden" name="nickname" value="<?=$nickname;?>">
		<input type="hidden" name="mail" value="<?=$mail;?>">
		<input type="hidden" name="password" value="<?=$hashed_password;?>">
     	<button id="register" type="submit">登録する</button>
    </form>
    	<a href="register.php"><button>やり直す</button></a>

<?php
}
}else{
	$msg = "<a href='register.php'>失礼ですが、最初から登録を行なってください。</a>";
}
?>
	<?=$msg;?>
	</section>
<?php require_once("parts/footer.php");?>