<?php require_once("parts/header.php");?>
	<div class="top_img"><img src="images/top.jpg"></div>

	<h2>写真一覧</h2>

	<section class="list_photos">
			<?php
				//ページネーション用 第1引数:テーブル名 第２引数：1ページの表示件数
				$pagenation = getPagenation("photos",12);

				$query = ("SELECT * FROM `photos` LEFT OUTER JOIN `cats` ON (photos.cat_id = cats.cat_id) ORDER BY `photo_id` DESC LIMIT ? OFFSET ?");
				$sth = $dbh->prepare($query);
				$sth->bindParam( 1, $pagenation["perpage"], PDO::PARAM_INT );
				$sth->bindParam( 2, $pagenation["from"], PDO::PARAM_INT );
				$sth->execute();
				while($photo_info = $sth->fetch()):
			?>

				<div>
					<img src="<?=h($photo_info['url']);?>" alt="<?=h($photo_info['cat_name']);?>">
					<p><a href="photo.php?photo_id=<?=h($photo_info['photo_id']);?>"><?=h($photo_info["cat_name"]);?></a></p>
					<button data-id="<?=h($photo_info["cat_id"]);?>" data-count="<?=h($photo_info["cat_count_good"]);?>" class="nya">
						<span class="count_good<?=h($photo_info['cat_id']);?>"><?=h($photo_info["cat_count_good"]);?></span> にゃー
					</button>
				</div>

			<?php endwhile;?>

		<?php require_once("parts/pagenation.php");?>

	</section>	

<?php require_once("parts/footer.php");?>