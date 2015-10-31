<?php //cat_id,photo_idの取得
if(isset($_GET["cat_id"]) && preg_match("/^[1-9]+$/", $_GET["cat_id"])){
	$got_id = "&cat_id=".$_GET["cat_id"];
} elseif (isset($_GET["photo_id"]) && preg_match("/^[1-9]*$/", $_GET["photo_id"])) {
	$got_id = "&photo_id=".$_GET["photo_id"];
} else {
	$got_id = "";
}
?>

<div class="pagenation">

<?php if($pagenation["page"] > 1): ?>
	<a href="?page=<?=h($pagenation["page"] - 1);?><?=h($got_id);?>">前</a>
<?php endif;?>
	
<?php for($i = 1; $i <= $pagenation["total_pages"]; $i++):?>
	<?php if($pagenation["page"] == $i):?>
		<strong><a href="?page=<?=h($i.$got_id);?>"><?=h($i);?></a></strong>
	<?php else:?>
		<a href="?page=<?=h($i.$got_id);?>"><?=h($i);?></a>
	<?php endif;?>
<?php endfor;?>
	
<?php if($pagenation["page"] < $pagenation["total_pages"]):?>
	<a href="?page=<?=h($pagenation["page"] + 1);?><?=h($got_id);?>">次</a>
<?php endif;?>

</div>