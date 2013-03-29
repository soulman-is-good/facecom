<div class="UpImDescription">
	<form action="/id<?= $user_id ?>/aphotos/set_photo_title/<?= $photo['id'] ?>" id="form_edit_photo_<?= $photo['id'] ?>" method="post">
		<textarea name="description" cols="20" rows="3" placeholder="Описание фото"><?= $photo['description'] ?></textarea>
		<div style="margin-top:12px">
			<input type="submit" value="Готово" />&nbsp;&nbsp;&nbsp; <input type="button" value="Отмена" class="closeMywnd" />
		</div>
	</form>
</div>