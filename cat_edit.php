<?php require_once("parts/header.php");
	//ログインしていないと編集できない
	if(!isset($_SESSION['user'])):
		$msg = "<p class='alert'>ログインしないと編集できません。</p>";
	else:
		//メッセージの初期化
		$msg = "";

		$cat_id = $_GET["cat_id"];
		$query = "SELECT `user_id` FROM `cats` where `cat_id` = ?";
		$sth = $dbh->prepare($query);
		$sth->bindParam( 1, $cat_id, PDO::PARAM_INT );
		$sth->execute();
		$cat_owner = $sth->fetch(PDO::FETCH_ASSOC);

			if(!$cat_owner == $user_id):
				$msg = "<p class='alert'>この猫を編集する権限はありません。</p>";
			else:

							if(isset($_POST["type"])){
								//switch文・・・
								//変更処理
								if ($_POST["type"] == "edit_profile") {
									$cat_name = $_POST["cat_name"];
									$cat_comment = $_POST["cat_comment"];

									$query = "UPDATE cats SET `cat_name` = ? , `cat_comment` = ? where cat_id = ?";
									$sth = $dbh->prepare($query);
									$sth->bindParam( 1, $cat_name, PDO::PARAM_STR);
									$sth->bindParam( 2, $cat_comment, PDO::PARAM_STR);
									$sth->bindParam( 3, $cat_id, PDO::PARAM_INT);
									$result = $sth->execute();
										if($result){
											$msg = "<p class='correct'>変更完了しました。</p>";
										}else{
											$msg = "<p class='alert'>変更失敗しました。管理者にお問い合わせください。</p>";
										}
								}

								//画像追加処理
								if ($_POST["type"] == "add_photo") {
									if (!isset($_FILES["upfile"]["error"])){
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
              									$sth->bindParam(1, $cat_id, PDO::PARAM_INT);
              									$sth->bindParam(2, $src, PDO::PARAM_STR);
              									$result = $sth->execute();

              									if($result){
              										$msg = "<p class='correct'>変更完了しました。</p>";
												}else{
													echo "<p class='alert'>データーベース登録に失敗しました。</p>";
              									}

      										} else {
      											$dbh->rollBack();
      											echo "<p class='alert'>アップロードできませんでした。</p>";
      										}
  										}
									}
								}

								//画像削除処理
								if($_POST["type"] == "delete_photo"){
									$photo_id = $_POST["photo_id"];
									$photo_url = $_POST["photo_url"];


									//プロフィール画像であれば画像削除させない
									$chk = $dbh->query("SELECT COUNT(*) FROM `cats` WHERE `profile_photo_url` = '".$photo_url."'")->fetchColumn();
									
									if($chk == 0){

										$flg = unlink($photo_url);

										//データーベース削除
										if($flg){
											$query = "DELETE FROM `photos` where `photo_id` = ?";
											$sth = $dbh->prepare($query);
											$sth->bindParam(1, $photo_id, PDO::PARAM_INT);
											$sth->execute();
											$msg = "<p class='correct'>写真を消去しました。</p>";
										} else {
											$msg = "<p class='alert'>削除できませんでした。管理者にお問い合わせください。</p>";										
										}
									} else {
										$msg = "<p class='alert'>プロフィール画像は消去できません。</p>";
									}
								}

								//プロフィール画像変更
								if($_POST["type"] == "set_profile"){
									$photo_url = $_POST["photo_url"];

									$query = "UPDATE `cats` SET `profile_photo_url` = ? where `cat_id` = ?";
									$sth = $dbh->prepare($query);
									$sth->bindParam( 1, $photo_url, PDO::PARAM_STR);
									$sth->bindParam( 2, $cat_id, PDO::PARAM_INT);
									$result = $sth->execute();
										if($result){
											$msg = "<p class='correct'>変更完了しました。</p>";
										}else{
											echo "<p class='alert'>変更失敗しました。管理者にお問い合わせください。</p>";
										}
								}
							}

							//データベースよりねこ情報を取得
							$query = "SELECT * FROM `cats` where `cat_id` = ?";
							$sth = $dbh->prepare($query);
							$sth->bindParam( 1, $cat_id, PDO::PARAM_INT );
							$sth->execute();
							$cat_info = $sth->fetch(PDO::FETCH_ASSOC);
						?>
						<section class="single_cat">
							<img src="<?=h($cat_info['profile_photo_url']);?>">
						</section>
						<h2>ねこ編集ページ</h2>	
						<section class="cat_edit">
							<?=$msg;?>
							<dl>
							<form action="" method="POST" >
								<dt>ねこちゃんの名前：</dt><dd><input type="text" name="cat_name" value="<?=h($cat_info['cat_name']);?>" maxlength="100" required></dd>
								<dt>ねこちゃんのコメント:</dt><dd><textarea name="cat_comment" rows="5" cols="80" maxlength="200" required><?=h($cat_info['cat_comment']);?></textarea></dd>
								<input type="hidden" name="cat_id" value="<?=h($cat_id);?>">
								<input type="hidden" name="type" value="edit_profile">
								<button type="submit">変更する</button>
							</form>
							</dl>

							<dl>
							<form action="" method="POST" enctype="multipart/form-data">
								<dt>写真を追加する</dt><dd><input type="file" name="upfile" accept="image/*" capture="camera" id="upfile" onchange="chkFile()" required></dd>
								<input type="hidden" name="type" value="add_photo">
								<button type="submit" id="submit">写真を追加</button>
							</form>
							</dl>
							
							<dl>
								<dt>ねこを消去する</dt>
								<dd><button onclick="alert('ねこを消去することはできません。ずっと大切にしてください。');">ねこを消去する</button></dd>
							</dl>
						</section>

						<h2><?=h($cat_info["cat_name"]);?>の写真一覧</h2>
						<section class="list_photos">

						<?php
							//ページネーション用 第1引数:テーブル名 第２引数：1ページの表示件数;
							$pagenation = getPagenation("photos",12,"cat_id",$cat_id);

							//一覧取得用
							$query = "SELECT * FROM `photos` WHERE `cat_id` = ? LIMIT ? OFFSET ?";
							$sth = $dbh->prepare($query);
							$sth->bindParam( 1, $cat_id, PDO::PARAM_INT );
							$sth->bindParam( 2, $pagenation["perpage"], PDO::PARAM_INT );
							$sth->bindParam( 3, $pagenation["from"], PDO::PARAM_INT );
							$sth->execute();

							while($photo_info = $sth->fetch(PDO::FETCH_ASSOC)):
						?>

						<div>
							<a href="photo.php?photo_id=<?=$photo_info['photo_id']?>"><img src="<?=$photo_info['url']?>"></a>
							<form action="" method="post">
								<input type="hidden" name="photo_id" value="<?=$photo_info['photo_id'];?>">
								<input type="hidden" name="photo_url" value="<?=$photo_info['url'];?>">
								<input type="hidden" name="type" value="delete_photo">
								<button type="submit" onclick='return confirm("写真を削除してよろしいですか？");'>削除する</button>
							</form>
							<form action="" method="post">
								<input type="hidden" name="photo_url" value="<?=$photo_info['url'];?>">
								<input type="hidden" name="type" value="set_profile">
								<button type="submit">プロフィールにする</button>
							</form>
						</div>
		
						<?php endwhile;?>
			
						<?php require_once("parts/pagenation.php");?>

						</section>
			<?php endif;
	endif;?>

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