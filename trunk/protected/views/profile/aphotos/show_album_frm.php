<div class="UpImDescription">
	<form action="/id<?= $user_id ?>/aphotos/set_album_name/<?= $album['id'] ?>" method="post">
		<input type="text" name="title" value="<?= $album['title'] ?>" />
		<div style="margin-top:12px">
			<input type="submit" value="Готово" />&nbsp;&nbsp;&nbsp; <input type="button" value="Отмена" class="closeMywnd" />
		</div>
	</form>
</div>