<aside>
  <?php require_once("login_form.php");?>

	<h3>気まぐれ　ねこ紹介</h3>
	<?php 
	$count = $dbh->query("SELECT COUNT(*) FROM `cats`") -> fetchColumn();
	$flg = true;

	while($flg){
		$rand_cat_id = rand(1,$count);
		$query = 'SELECT * FROM `cats` WHERE `cat_id` = ?';
 		$sth = $dbh->prepare($query);
 		$sth->execute(array($rand_cat_id));
 		
 		if($sth){
 			$rand_cat_info = $sth->fetch(PDO::FETCH_ASSOC);
 			$flg = false;
 		}
	}
	?>
	
	<h4><a href="cat.php?cat_id=<?=h($rand_cat_info['cat_id']);?>"><?=h($rand_cat_info["cat_name"]);?></a></h4>
	<a href="cat.php?cat_id=<?=h($rand_cat_info['cat_id']);?>"><img src="<?=h($rand_cat_info["profile_photo_url"]);?>"></a>
		<button data-id="<?=h($rand_cat_info["cat_id"]);?>" data-count="<?=h($rand_cat_info["cat_count_good"]);?>" class="nya">
			<span class="count_good<?=h($rand_cat_info['cat_id']);?>"><?=h($rand_cat_info["cat_count_good"]);?></span> にゃー
		</button>
</aside>