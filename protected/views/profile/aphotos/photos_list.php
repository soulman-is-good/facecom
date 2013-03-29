<?foreach($photos as $ind=>$photo):?>
<div class="pw_list_item_open" id="pw_list_item_open_<?= $photo['id'] ?>">
	<a href="/id<?= $user_id ?>/aphotos/show/<?= $photo['id'] ?>"><img src="<?=Yii::app()->request->baseUrl; ?>/upload/photos/small/<?=$photo['file']?>.<?= $photo->image->extension ?>" alt="" /></a>
</div>
<?endforeach?>