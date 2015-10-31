<?php require_once("parts/header.php");?>
	<section class="single_photo">
		<?php
			$photo_id = isset($_GET["photo_id"]) ? $_GET["photo_id"] : 1 ;

			//コメント追加
			if(isset($_POST["nickname"]) && isset($_POST["comment"])){
				$nickname = $_POST["nickname"];
				$comment = $_POST["comment"];

				$query = "INSERT INTO `comments` (`photo_id`, `nickname`, `photo_comment`) VALUES (?,?,?)";
				$sth = $dbh->prepare($query);
				$sth->bindParam(1, $photo_id, PDO::PARAM_INT);
				$sth->bindParam(2, $nickname, PDO::PARAM_STR);
				$sth->bindParam(3, $comment, PDO::PARAM_STR);
				$sth->execute();
			}

 			$query = "SELECT * FROM `photos` LEFT OUTER JOIN `cats` ON (photos.cat_id = cats.cat_id) WHERE `photo_id` = ?";
 			$sth = $dbh->prepare($query);
 			$sth->execute(array($photo_id));
 			$photo_info = $sth->fetch(PDO::FETCH_ASSOC);
 		?>
		<img src="<?=h($photo_info['url']);?>" alt="<?=h($photo_info['cat_name']);?>">
		<h2><?=h($photo_info['cat_name']);?></h2>
		<p><?=h($photo_info['cat_comment']);?></p>
	</section>

	<h2>この写真へのコメント</h2>
	<section class="comments">
		<?php
			//ページネーション用 第1引数:テーブル名 第2引数：1ページの表示件数　第3引数：where文をかけるカラム　第4引数：where文をかける内容
			$pagenation = getPagenation("comments",10,"photo_id",$photo_id);

			//コメント一覧取得
			$query = "SELECT * FROM `comments` WHERE `photo_id` = ? LIMIT ? OFFSET ?";
			$sth = $dbh->prepare($query);
			$sth->bindParam( 1, $photo_id, PDO::PARAM_INT );
			$sth->bindParam( 2, $pagenation["perpage"], PDO::PARAM_INT );
			$sth->bindParam( 3, $pagenation["from"], PDO::PARAM_INT );
			$sth->execute();
			while($comment_info = $sth->fetch(PDO::FETCH_ASSOC)):
		?>

			<article>
				<address><?=h($comment_info['nickname']);?></address>
				<p><?=h($comment_info['photo_comment']);?></p>
			</article>

		<?php endwhile;?>
	
	<?php require_once("parts/pagenation.php");?>
	</section>

	<h2>コメント追加</h2>
	<section class="comments">

	<dl>
		<form action="" method="POST">
		<dt>ユーザー名：</dt>
		<dd><input type="text" name="nickname" maxlength="20" value="<?=h($user_name);?>" required></dd>
		<dt>コメント：</dt>
		<dd><textarea name="comment" rows="5" cols="80" maxlength="200" required></textarea></dd>
		<input type="submit"　value="登録する">
		</form>
	</dl>

	</section>

<?php require_once("parts/footer.php");?>