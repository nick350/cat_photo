<?php require_once("parts/header.php");
require_once('php/password.php');

//メッセージの初期化 *登録フォームと同じよう、ajaxにて入力チェックしようかと思ったが却下。
$msg = "";

//ニックネーム変更処理
	if(isset($_POST["nickname"])){
		$new_nickname = htmlspecialchars($_POST["nickname"]);

		$chk = $dbh->query("SELECT COUNT(*) FROM `users` WHERE `nickname` = '".$new_nickname."'")->fetchColumn();
		if($chk != 0 ){
			$msg = "<p class='alert'>このニックネームは既に登録されています。</p>";
		} else {
			$query = "UPDATE users SET `nickname` = ? where `user_id` = ?";
			$sth = $dbh->prepare($query);
			$sth->bindParam(1, $new_nickname, PDO::PARAM_STR);
			$sth->bindParam(2, $user_id, PDO::PARAM_INT);
			$result = $sth->execute();
			if($result){
				$msg = "<p class='correct'>変更完了しました!</p>";
				$_SESSION["user"][1] = $new_nickname;
				$user_name = $new_nickname;
			} else {
				$msg = "<p class='alert'>変更に失敗しました。管理者にお問い合わせください。</p>";
			}
		}
	}

//パスワード変更処理
	if(isset($_POST["password1"]) && isset($_POST["password2"])){
		$password1 = $_POST["password1"];
		$password2 = $_POST["password2"];

		if($password1 != $password2){
			$msg = "<p class='alert'>入力された2つのパスワードが違います</p>";
		} else {
			$hashed_password = password_hash($password2, PASSWORD_DEFAULT);
			$query = "UPDATE `users` SET `password` = ? where `user_id` = ?";
			$sth = $dbh->prepare($query);
			$sth->bindParam(1, $hashed_password, PDO::PARAM_STR);
			$sth->bindParam(2, $user_id, PDO::PARAM_INT);
			$result = $sth->execute();

			if($result){
				$msg = "<p class='correct'>変更しました！</p>";
			} else {
				$msg = "<p class='alert'>変更に失敗しました。管理者にご確認ください。</p>";
			}
		}
	}

?>
	<div class="top_img"><img src="images/top.jpg"></div>
	<h2>マイページ</h2>
		<section class="mypage">
			<?php if(isset($_SESSION["user"])):?>
				<?=$msg;?>
				<h3>ニックネーム編集</h3>
					<dl class="form" style="maring-bottom:20px;">
						<form action="" method="POST">
						<dt>ニックネーム</dt>
       					<dd><input type="text" name="nickname" id="nickname" onchange="checkNickname()" value="<?=$user_name;?>" maxlength="20" required></dd>
       				 	<div id="nickname_message"></div>
       				 	<button type="submit" id="nickname_button">ニックネームを変更する</button>
       				 	</form>
       				 </dl>

       			<h3>パスワード変更</h3>
					<dl class="form">
						<form action="" method="POST">
        				<dt>パスワード</dt>
      					<dd><input type="password" name="password1" id="password1" onchange="checkPassword()" maxlength="20" required></dd>

      					<dt>パスワード（確認用)</dt>
      					<dd><input type="password" name="password2" id="password2" onchange="checkPassword()" maxlength="20" required></dd>
        				<div id="password_message"></div>
        				<button type="submit" id="password_button">ニックネームを変更する</button>
        				</form>
    				</dl>

				<h3>あなたの猫ちゃん一覧</h3>
					<?php
						//登録しているネコの件数チェック。登録数が0の場合はメッセージを表示
						$chk = true;
						//ページネーション用 第1引数:テーブル名 第2引数：1ページの表示件数　第3引数：where文をかけるカラム　第4引数：where文をかける内容
						$pagenation = getPagenation("cats",6,"user_id",$user_id);

						$query = "SELECT * FROM `cats` WHERE `user_id` = ? LIMIT ? OFFSET ?";
						$sth = $dbh->prepare($query);
						$sth->bindParam( 1, $user_id, PDO::PARAM_INT );
						$sth->bindParam( 2, $pagenation["perpage"], PDO::PARAM_INT);
						$sth->bindParam( 3, $pagenation["from"], PDO::PARAM_INT);
						$sth->execute();
						while($cat_info =  $sth->fetch(PDO::FETCH_ASSOC)):
					?>
							<div>
								<img src="<?=$cat_info['profile_photo_url']?>">
								<?=$cat_info["cat_name"];?>
								<?=$cat_info["cat_comment"];?>
								<form action="cat_edit.php" method="GET">
									<input type="hidden" name="cat_id" value="<?=$cat_info['cat_id'];?>">
									<button type="submit" id="password_button">この子を編集する</button>
								</form>
							</div>
							<hr>
							<?php $chk = false;?> 
					<?php endwhile;
						require_once("parts/pagenation.php");
						if($chk){echo "あなたが登録しているネコはいません";}
					?>
							<a href="cat_new.php"><button type="submit">新しいネコを登録する</button></a>
			<?php else :?>
				<a href="login.php">こちらからログインしてください。</a>
			<?php endif;?>
		</section>

		<script>
			var nickname = document.getElementById("nickname");
        	var password1 = document.getElementById("password1");
        	var password2 = document.getElementById("password2");

        	var nickname_message = document.getElementById("nickname_message");
        	var password_message = document.getElementById("password_message");

        	var nickname_button = document.getElementById("nickname_button");
        	var password_button = document.getElementById("password_button");

        	nickname_button.setAttribute("disabled","disabled");
        	password_button.setAttribute("disabled","disabled");

        function checkNickname(){
            var input_nickname = nickname.value;
            if(input_nickname == ""){
               nickname_button.setAttribute("disabled","disabled");
               return;
            }
    		$.ajax({
                type : "POST",
                url : "php/check.php",
                data: {
                    "item" : "1",
                    "value" : input_nickname
                }
            })
            .done(function(data){
                if(data == 1){
                    nickname_button.setAttribute("disabled","disabled");
                    nickname_message.innerHTML = "<p class='alert'>このニックネームは既に使われています。</p>";
                }else if(data == 0){
                    nickname_button.removeAttribute("disabled");
                    nickname_message.innerHTML = "<p class='correct'>このニックネームは使用できます。</p>";
                } else {
                    nickname_button.removeAttribute("disabled");
                    nickname_message.innerHTML = "エラーです。";
                }
            })
            .fail(function(){nickname_button.removeAttribute("disabled");;});
        }

        //パスワードチェック
    	function checkPassword(){
            var input_password1 = password1.value;
            var input_password2 = password2.value;
            if(input_password2 == ""){
                password_button.setAttribute("disabled","disabled");
                password_message.innerHTML = "<p class='alert'>確認パスワードを入力してください</p>";
                return;
            }
            
            if(input_password1 == input_password2){
                password_button.removeAttribute("disabled");
                password_message.innerHTML = "<p class='correct'>パスワード一致しました。</p>";
            } else {
                password_button.setAttribute("disabled","disabled");
                password_message.innerHTML = "<p class='alert'>パスワードが一致しません。</p>";
            }

    	}

		</script>

<?php require_once("parts/footer.php");?>