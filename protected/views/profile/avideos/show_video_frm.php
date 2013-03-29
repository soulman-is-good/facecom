<div class="UpImDescription">
	<form action="/id<?= $user_id ?>/aphotos/set_photo_title/<?= $video['id'] ?>" id="form_edit_photo_<?= $video['id'] ?>" method="post">
		<textarea name="description" cols="20" rows="3" placeholder="Описание видео"><?= $photo['description'] ?></textarea>
		<div style="margin-top:12px">
			<input type="submit" value="Готово" />&nbsp;&nbsp;&nbsp; <input type="button" value="Отмена" class="closeMywnd" />
		</div>
	</form>
</div>