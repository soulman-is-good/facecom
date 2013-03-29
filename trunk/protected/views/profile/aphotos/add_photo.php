<form action="/id<?= $user_id ?>/aphotos/save/" method="post" id="add_photo_form">
	<div class="show_wnd">
		<div class="wnd_content" style="padding-right:0px;">
			<div class="album_name">
				<input type="hidden" name="album_set" class="album_set" id="album_set" value="<? if( count($albums) > 0): ?>0<? else: ?>1<? endif ?>" />
				<div><span>Альбом:</span></div>
				<div class="album_select">
					<? if( count($albums) > 0): ?>
					<div class="can_select_album">
						<div class="select">
							<input type="hidden" name="albom_sel" value="<?= $albums[$album_selected]['id'] ?>" />
							<div class="selected"><?= $albums[$album_selected]['title'] ?></div>
							<div class="options">
								<? foreach($albums as $album): ?>
								<div class="option" val="<?= $album['id'] ?>"><?= $album['title'] ?></div>
								<? endforeach ?>
							</div>
						</div>
					</div>
					<?endif?>
					<div class="can_create_album" <? if( count($albums) == 0): ?>style="display:block"<?endif?>>
						<input type="text" name="album_create" id="album_create" />
					</div>
				</div>
				<div class="change_album_set">
					<?if( count($albums) > 0):?>
					<span class="album_create_set">&nbsp;&nbsp; Можно <a href="#">создать новый альбом</a></span>
					<span class="album_select_set">&nbsp;&nbsp; Можно <a href="#">добавить файлы в существующий альбом</a></span>
					<?endif?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="photos_loader_scroll">
				<div class="photos_loader">
					<div class="upload_btn">
						<div class="uploadLinkWithButton" style="width:300px;margin:auto;">
							<input type="button" value="Выберите файлы на компьютере" />
							<input class="fileupload" id="main_button" type="file" name="files" data-url="/id<?= $user_id ?>/aphotos/upload/" multiple />
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="photo_ids" id="photo_ids" value="," />
			<div class="clear"></div>
			
		</div>
		<div class="wnd_footer">
			<div class="wnd_footer_left">
				<input type="submit" disabled class="add_photo_submit" value="Готово" />&nbsp;&nbsp;&nbsp;
				<input type="button" class="closeMywnd" value="Закрыть" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span id="filestatus"></span>
			</div>
			<div class="wnd_footer_right">
				<div class="uploadLinkWithButton uploadLinkWithButtonMore">
					<a href="#">Выбрать еще фотографии</a>
					<input class="fileupload" id="main_button" type="file" name="files" data-url="/id<?= $user_id ?>/aphotos/upload/" multiple />
				</div>
			</div>
		</div>
	</div>
</form>