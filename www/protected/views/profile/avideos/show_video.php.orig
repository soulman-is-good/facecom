<div class="viewPhoto">
	<table cellpadding="0" cellspacing="0" width="1160px">
		<tr>
			<td class="left">
				<div class="container">
					<div class="title" style="margin-bottom:10px;">
						Видео <?= $aroundInfo['num'] ?> из <?= $aroundInfo['count'] ?>
					</div>
					<div class="photo">
						<a class="navigation prev" href="/id<?= $user_id ?>/avideos/<?= $nav_link ?>/<?= $aroundInfo['prev'] ?>"></a>
						<a class="navigation next" href="/id<?= $user_id ?>/avideos/<?= $nav_link ?>/<?= $aroundInfo['next'] ?>"></a>
						<object type="application/x-shockwave-flash" data="/static/js/videos/uppod.swf" height="550" width="700" style="margin-left:35px;">
							<param name="bgcolor" value="#000000" />
							<param name="allowFullScreen" value="true" />
							<param name="allowScriptAccess" value="always" />
							<param name="movie" value="lib/flvplayer.swf" />
							<param name="FlashVars" value="way=http://facecom.lc/upload/video/<?= $video->file ?>.flv&amp;swf=/static/js/videos/uppod.swf&amp;w=700&amp;h=550&amp;pic=&amp;autoplay=0&amp;tools=1&amp;skin=black&amp;volume=70&amp;q=1&amp;comment=" />
						</object>
						<? if($nav_link == 'show'): ?>
						<div class="video_controll">
							<div class="video_controll_links" style="overflow:hidden;">
								<? if($myPage): ?>
								   <a href="/id<?= $user_id ?>/avideos/edit_video/<?= $video['id'] ?>" class="edit_video_link" rel="<?= $video['id'] ?>" onclick="return false;">Редактировать</a>
								 | <a href="/id<?= $user_id ?>/avideos/delete_video/<?= $video['id'] ?>" class="delete_video_link" rel="<?= $video['id'] ?>" next="/id<?= $user_id ?>/avideos/show/<?= $aroundInfo['prev'] ?>" onclick="return false;">Удалить</a>
								<? else: ?>
									<? if(!in_array($video['file'], $my_videos)): ?>
										<div style="float:right;">
										<?/*  ссылку поменять потом, для добавления в закладки исп. Bookmarks::model()->addElem($owner,$content,1), где овнер - ИД пользователя, к которому добавить; контент - ИД фотографии из таблицы "фотос"
										      Метод сам определяет есть ли уже объект в избранном, так что можно вызывать в каждом случае лайка   */?>
											<a href="/id<?= $user_id ?>/avideos/video_add_to_my_page/<?= $video['id'] ?>" onClick="addToMyVideos(this, <?= $video['id'] ?>); return false;">Добавить в мои видео</a>
										</div>
									<? endif ?>
								<? endif ?>
							</div>
						</div>
						<? endif ?>
					</div>
					<div class="description" style="margin:10px 40px;"><?= $video['description'] ?></div>
				</div>
				<img src="<?=Yii::app()->request->baseUrl; ?>/static/css/modalWindowCorner.png" alt="" class="corner">
			</td>
			<td class="right">
				<div class="container">
					<span class="close closeMywnd closeLink">Закрыть</span>
					<!--<img src="<?=Yii::app()->request->baseUrl; ?>/static/css/close.png" class="close closeMywnd" />-->
					<div class="addTime">
						Добавлена <?= Yii::app()->dateFormatter->format('d MMMM yyyy', $video['upload_date']) ?>
					</div>
					<div class="title">
						<?= $myProfile->first_name ?> <? $myProfile->second_name ?>
					</div>
					<div class="comments">
						<form action="/comments/add" id="photo_comments_form">
							<div class="commentForm">
								<div class="avatar">
									<img width="48" src="<?= Yii::app()->request->baseUrl ?><?= $myProfile->getAvatar('mini') ?>" alt="" />
									<input type="hidden" name="tbl" value="<?= $comments_tbl ?>">
									<input type="hidden" name="item_id" value="<?= $comments_item_id ?>">
									<input type="hidden" name="owner" value="<?= $myProfile->user_id ?>">
									<textarea name="text"></textarea>
								</div>
							</div>
							<input type="submit" style="float: right; margin-top: 10px" value="Отправить" />
						</form>
						<div class="hint">
							Ctrl+Enter –<br />отправка сообщения
						</div>
						<div style="margin-top:20px">
							<div id="commentsScroll">
								<div class="commentsContainer">
									<?
									foreach($comments as $comment)
										$this->renderPartial('//comments/comments/_commentsItem', array('item' => $comment));
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>