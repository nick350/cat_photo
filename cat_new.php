<?php require_once("parts/header.php");?>
	<div class="top_img"><img src="images/top.jpg"></div>
	<h2>ねこちゃん追加ページ</h2>
		<div>こんにちは<?=h($user_name);?>さん</div>
		<section class="cat_new">
			<?php if(isset($_SESSION["user"])):
					//メッセージの初期化
					$msg = "";
					if(isset($_POST["cat_name"]) && isset($_POST["cat_comment"])):
						$cat_name = $_POST["cat_name"];
						$cat_comment = $_POST["cat_comment"];

						//どこかで失敗したときのためにトランザクション処理
						$dbh->beginTransaction();
						
						$query = "INSERT INTO `cats` (`cat_name`, `user_id`, `cat_comment`) VALUES (?, ?, ?)";
						$sth = $dbh->prepare($query);
						$sth->bindParam(1, $cat_name, PDO::PARAM_STR);
						$sth->bindParam(2, $user_id, PDO::PARAM_INT);
						$sth->bindParam(3, $cat_comment, PDO::PARAM_STR);
						$result = $sth->execute();

						//データーベースのinsertが成功したら
						if($result){
							//insertされたcat_idの取得
							$last_cat_id = $dbh->lastInsertId();

							//画像取得のエラー
							if (!isset($_FILES["upfile"]["error"])){
								$dbh->rollBack();
								$msg = "<p class='alert'>パラメータが不正です</p>";
							}else{
  								$file_name = $_FILES["upfile"]["name"];
 								$extension = pathinfo($file_name, PATHINFO_EXTENSION);
 								$tmp_path  = $_FILES["upfile"]["tmp_name"];
 								$uniq_name = date("YmdHis").session_id() . "." . $extension; 

  								$img="";
  								if ( is_uploaded_file( $tmp_path ) ) {
      								if ( move_uploaded_file(  $tmp_path, "images/upload/".$uniq_name ) ) {
      									$src = "images/upload/".$uniq_name;
              							chmod( $src, 0644 );

              							//写真のデーターベース追加
              							$query = "INSERT INTO `photos` (`cat_id`, `url`) VALUES (?,?)";
              							$sth = $dbh->prepare($query);
              							$sth->bindParam(1, $last_cat_id, PDO::PARAM_INT);
              							$sth->bindParam(2, $src, PDO::PARAM_STR);
              							$sth->execute();

              							//ネコプロフィール写真の初期設定
              							$query = "UPDATE cats SET `profile_photo_url` = ? where cat_id = ?";
              							$sth = $dbh->prepare($query);
              							$sth->bindParam(1, $src, PDO::PARAM_STR);
              							$sth->bindParam(2, $last_cat_id, PDO::PARAM_INT);
              							$result2 = $sth->execute();

              							//すべてが完了したらネコページへ。
              							if($result2){
              								$dbh->commit();
              								echo "<meta http-equiv='refresh' content='0;URL=cat.php?cat_id=".$last_cat_id."'>";
										}else{
              								$dbh->rollBack();
              								$msg = "<p class='alert'>データーベース登録に失敗しました。</p>";
              							}

      								} else {
      									$dbh->rollBack();
      									$msg = "<p class='alert'>アップロードできませんでした。</p>";
      								}
  								}
							}
						} else{
							$dbh->rollBack();
							$msg = "<p class='alert'>データーベース登録に失敗しました。</p>";
						}
					
					else:
						$msg = "<p class='alert'>すべての項目を入力してください。</p>";
					endif;
			?>
					<?=$msg;?>
					<dl>
					<form action="" method="POST" enctype="multipart/form-data">
						<dt>ねこちゃんの名前：</dt><dd><input type="text" name="cat_name" maxlength="100" required></dd>
						<dt>ねこちゃんのコメント:</dt><dd><textarea name="cat_comment" rows="5" cols="80" maxlength="200" required></textarea></dd>
						<input type="file" name="upfile" accept="image/*" capture="camera" id="upfile" onchange="chkFile()"required>
						<button type="submit" id="submit">登録する</button>
					</form>
					</dl>
			<?php else :?>
				<a href="login.php">こちら</a>からログインしてください。
			<?php endif;?>
		</section>


	<script type="text/javascript">
	function chkFile(){
		var file = document.getElementById("upfile").files[0];
		if(file.size > 1048576){
			document.getElementById("submit").setAttribute("disabled","disabled");
			alert("ファイルサイズが大きすぎます");
		} else {
			document.getElementById("submit").removeAttribute("disabled");
		}
	}
	</script>

<?php require_once("parts/footer.php");?>