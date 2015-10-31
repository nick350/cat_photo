<?php require_once("parts/header.php");?>
	<div class="top_img"><img src="images/top.jpg" alt="秋だにゃ！"></div>
	<h2>ねこ一覧</h2>
	<section class="list_cats">
		<?php		
			//ページネーション用 第1引数:テーブル名 第2引数：1ページの表示件数　第3引数：where文をかけるカラム　第4引数：where文をかける内容
			$pagenation = getPagenation("cats",6);

			//一覧取得用
			$query = "SELECT * FROM `cats` ORDER BY `cat_count_good` DESC LIMIT ? OFFSET ?";
			$sth = $dbh->prepare($query);
			$sth->bindParam( 1, $pagenation["perpage"], PDO::PARAM_INT );
			$sth->bindParam( 2, $pagenation["from"], PDO::PARAM_INT );
			$sth->execute();

			while($cat_info = $sth->fetch()):
		?>
		
			<div>
				<a href="cat.php?cat_id=<?=h($cat_info['cat_id']);?>"><img src="<?=h($cat_info['profile_photo_url']);?>"></a>
				<p><a href="cat.php?cat_id=<?=h($cat_info['cat_id']);?>"><?=h($cat_info["cat_name"]);?></a></p>
				<button data-id="<?=h($cat_info["cat_id"]);?>" data-count="<?=h($cat_info["cat_count_good"]);?>" class="nya">
					<span class="count_good<?=h($cat_info['cat_id']);?>"><?=h($cat_info["cat_count_good"]);?></span> にゃー
				</button>
			</div>

		<?php endwhile;?>

		<?php require_once("parts/pagenation.php");?>

	</section>
	
<?php require_once("parts/footer.php");?>