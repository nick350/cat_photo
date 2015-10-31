<?php require_once("parts/header.php");?>
	<!--ねこ写真を下記リンクから頂きました。
		トップ画像用　http://www.photo-ac.com/main/detail/136081?title=%E7%A7%8B%E3%83%8B%E3%83%A3%E3%81%AE%E3%81%A0%EF%BC%81
	　　　タロ　http://www.ashinari.com/2013/06/18-379250.php?category=50
		ミー　http://www.ashinari.com/2012/12/06-373850.php?category=50
		ヒーちゃん　http://www.ashinari.com/2012/09/22-370300.php?category=50
		フカ http://www.ashinari.com/2012/07/30-366267.php?category=50
		タム http://www.ashinari.com/2012/03/04-358597.php?category=50
		マロン http://www.ashinari.com/2011/04/07-346541.php
		エミル http://www.ashinari.com/2010/01/04-032515.php?category=50
		ムー http://www.ashinari.com/2009/09/30-029099.php
	-->

	<div class="top_img"><img src="images/top.jpg"></div>
	<h2>トップ画面</h2>
	<p>こんにちは<?=$user_name;?>さん</p>
	<p>当サイトはねこの写真をみんなで共有していくサイトです。	</p>
	<h2>人気ねこランキング</h2>
	<section class="cat_ranking">
		<?php
			$query = 'SELECT * FROM `cats` ORDER BY `cat_count_good` DESC LIMIT 3';
			$sth = $dbh->prepare($query);
			$sth->execute();
			while($cat_info = $sth->fetch()):
		?>
			
			<div>
			<img src="<?=h($cat_info['profile_photo_url']);?>" alt="<?=h($cat_info['cat_name']);?>">
			<span><a href="cat.php?cat_id=<?=h($cat_info['cat_id']);?>"><?=h($cat_info['cat_name']);?></a></span> <p><?=h(mb_substr($cat_info["cat_comment"], 0, 50));?></p>
			<button data-id="<?=h($cat_info["cat_id"]);?>" data-count="<?=h($cat_info["cat_count_good"]);?>" class="nya">
				<span class="count_good<?=h($cat_info['cat_id']);?>"><?=h($cat_info["cat_count_good"]);?></span> にゃー
			</button>
			</div>

		<?php endwhile;?>
	</section>

	<h2>新着ねこ写真</h2>
	<section class="new_cats_photos">		
		<?php
			$query = "SELECT * FROM `photos` LEFT OUTER JOIN `cats` ON (photos.cat_id = cats.cat_id)  ORDER BY `photo_id` DESC LIMIT 6";
			$sth = $dbh->prepare( $query );
			$sth->execute();
			while ($photo_info = $sth->fetch()):
		?>
		
		<div>
			<a href="photo.php?photo_id=<?=h($photo_info['photo_id']);?>"><img src="<?=h($photo_info['url']);?>" alt="<?=h($photo_info['photo_id']);?>"></a>
			<p><a href="photo.php?photo_id=<?=h($photo_info['photo_id']);?>"><?=h($photo_info["cat_name"]);?></a></p>
			<button data-id="<?=h($photo_info["cat_id"]);?>" data-count="<?=h($photo_info["cat_count_good"]);?>" class="nya">
				<span class="count_good<?=h($photo_info['cat_id']);?>"><?=h($photo_info["cat_count_good"]);?></span> にゃー
			</button>
		</div>

  		<?php endwhile;	?>
  		<p><a href="photos.php">ねこ写真一覧へ</a></p>
  	</section>
<?php require_once("parts/footer.php");?>