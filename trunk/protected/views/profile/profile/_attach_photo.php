<div class="show_wnd">
	<div id="profile_avatar">
		<input type="hidden" id="fc-tab-selected" value="computer" />
		<table width="100%" cellspacing="0" cellpadding="0" style="height: 558px;">
		<tr>
			<td width="190" style="vertical-align:top;padding:15px;border-right:1px solid #E1E1E1">
				<div class="fc-avatar-menu">
					<div>
						<a href="javascript:void(0)" class="active" onclick="change_upload_tab(this,'fc-avatar-computer','computer')">С компьютера</a>
					</div>
					<div>
						<a href="javascript:void(0)" onclick="change_upload_tab(this,'fc-avatar-gallery','album')">Из моих фото</a>
					</div>
				</div>
			</td>
			<td style="padding:15px;text-align:center">
				<div id="upload_tabs">
					<div id="fc-avatar-computer" class="upload_tab" style="position: relative; height: 528px;">
						

						<div class="photos_loader_scroll">
							<div class="photos_loader">
								<div class="upload_btn">
									<div class="uploadLinkWithButton" style="width:300px;margin:auto;">
										<input type="button" value="Выберите файлы на компьютере" />
										<input class="fileupload" id="main_button" type="file" name="files" data-url="/id<?= $profile['user_id'] ?>/aphotos/upload/" multiple />
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="photo_ids" id="photo_ids" />
						<div class="clear"></div>

						<span id="filestatus"></span>

						<div class="wnd_footer_right">
							<div class="uploadLinkWithButton uploadLinkWithButtonMore">
								<a href="#">Выбрать еще фотографии</a>
								<input class="fileupload" id="main_button" type="file" name="files" data-url="/id<?= $profile['user_id'] ?>/aphotos/upload/" multiple />
							</div>
						</div>


					</div>
					<div id="fc-avatar-gallery" class="upload_tab" style="display: none;"></div>
				</div>
			</td>
		</tr>
		</table>
	</div>
	<div class="wnd_footer" logic="footer">
		<div>
			<input type="button" value="Добавить" class="posts_append_images" />
			<input type="button" value="Отменить" class="closeMywnd" style="margin-left:15px" />
		</div>
	</div>
</div>