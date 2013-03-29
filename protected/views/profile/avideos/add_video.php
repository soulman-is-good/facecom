<form action="/id<?= $user_id ?>/avideos/save/" method="post" id="add_photo_form">
	<div class="show_wnd">
		<div class="wnd_content" style="padding-right:0px;">
			<div class="photos_loader_scroll">
				<div class="photos_loader">
					<div class="upload_btn">
						<div class="uploadLinkWithButton" style="width:300px;margin:auto;">
							<input type="button" value="Выберите файлы на компьютере" />
							<input class="fileupload" id="main_button" type="file" name="files" data-url="/id<?= $user_id ?>/avideos/upload/" multiple />
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
					<a href="#">Выбрать еще видео</a>
					<input class="fileupload" id="main_button" type="file" name="files" data-url="/id<?= $user_id ?>/avideos/upload/" multiple />
				</div>
			</div>
		</div>
	</div>
</form>