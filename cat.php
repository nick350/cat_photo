<?php require_once("parts/header.php");?>
	<section class="single_cat">
		<?php
			$cat_id = isset($_GET["cat_id"]) ? $_GET["cat_id"]: 1; 
 			$query = 'SELECT * FROM `cats` WHERE `cat_id` = ?';
 			$sth = $dbh->prepare($query);
 			$sth->execute(array($cat_id));
 			$cat_info = $sth->fetch(PDO::FETCH_ASSOC);
 		?>
		<img src="<?=h($cat_info['profile_photo_url']);?>" alt="<?=h($cat_info['cat_name']);?>"　id="cat_photo">
		<h2><?=h($cat_info["cat_name"]);?></h2>
		<p><?=h($cat_info["cat_comment"]);?></p>
		<button data-id="<?=h($cat_info["cat_id"]);?>" data-count="<?=h($cat_info["cat_count_good"]);?>" class="nya">
			<span class="count_good<?=h($cat_info['cat_id']);?>"><?=h($cat_info["cat_count_good"]);?></span> にゃー
		</button>
	</section>
	
	<h2><?=h($cat_info["cat_name"]);?>の写真一覧</h2>
	<section class="list_photos">
		<?php
			//ページネーション用 第1引数:テーブル名 第２引数：1ページの表示件数;
			$pagenation = getPagenation("photos",6,"cat_id",$cat_id);

			//一覧取得用
			$query = "SELECT * FROM `photos` WHERE `cat_id` = ? LIMIT ? OFFSET ?";
			$sth = $dbh->prepare($query);
			$sth->bindParam( 1, $cat_id, PDO::PARAM_INT );
			$sth->bindParam( 2, $pagenation["perpage"], PDO::PARAM_INT );
			$sth->bindParam( 3, $pagenation["from"], PDO::PARAM_INT );
			$sth->execute();

			while($photo_info = $sth->fetch(PDO::FETCH_ASSOC)):
		?>

			<div><a href="photo.php?photo_id=<?=h($photo_info['photo_id']);?>"><img src="<?=h($photo_info['url']);?>"></a></div>
		
		<?php endwhile;?>

		<?php require_once("parts/pagenation.php");?>

	</section>

<?php require_once("parts/footer.php");?>