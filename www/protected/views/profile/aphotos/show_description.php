<img src="/static/css/wnd_arrow.png" class="wnd_arrow" alt="" />
<div class="UpImDescription">
	<form action="/id<?= $user_id ?>/aphotos/set_description/<?= $photo['id'] ?>" id="form_description_<?= $photo['id'] ?>" method="post">
		<textarea name="description" cols="20" rows="3" placeholder="Описание фото"><?= $photo['description'] ?></textarea>
		<br />
		<input type="submit" value="Готово" />&nbsp;&nbsp;&nbsp; <input type="button" value="Отмена" class="closeMywnd" />
	</form>
</div>