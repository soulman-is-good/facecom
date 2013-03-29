<?foreach($videos as $ind=>$video):?>
<div class="pw_list_item_open" id="pw_list_item_open_<?= $video['id'] ?>">
	<a href="/id<?= $user_id ?>/avideos/show/<?= $video['id'] ?>">
		<img src="<?=Yii::app()->request->baseUrl; ?>/upload/photos/small/<?=$video['file']?>.jpg" alt="" />
	</a>
</div>
<?endforeach?>

