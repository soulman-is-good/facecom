<div class="viewPhoto">
	<table cellpadding="0" cellspacing="0" width="1160px">
		<tr>
			<td class="left">
				<div class="container">
					<div class="title" style="margin-bottom:10px;">
						Фотография <?= $aroundInfo['num'] ?> из <?= $aroundInfo['count'] ?>
					</div>
					<div class="photo">
						<a class="navigation prev" href="/id<?= $user_id ?>/bookmarks/show/<?= $aroundInfo['prev'] ?>"></a>
						<a class="navigation next" href="/id<?= $user_id ?>/bookmarks/show/<?= $aroundInfo['next'] ?>"></a>
						<img src="<?= Yii::app()->request->baseUrl; ?>/upload/photos/big/<?= $photo['file'] ?>.<?= $photo['image']['extension'] ?>" alt="" />
						<? if($nav_link == 'show'): ?>
						<div class="photo_controll">
							<div class="photo_controll_links">
								<? if($myPage): ?>
								   <a href="/id<?= $user_id ?>/aphotos/set_poster_photo/<?= $photo['id'] ?>" class="set_poster_photo_link" rel="<?= $photo['id'] ?>" onclick="return false;">Сделать обложкой</a>
								 | <a href="/id<?= $user_id ?>/aphotos/edit_photo/<?= $photo['id'] ?>" class="edit_photo_link" rel="<?= $photo['id'] ?>" onclick="return false;">Редактировать</a>
								 | <a href="/id<?= $user_id ?>/aphotos/delete_photo/<?= $photo['id'] ?>" class="delete_photo_link" rel="<?= $photo['id'] ?>" next="/id<?= $user_id ?>/aphotos/show/<?= $aroundInfo['prev'] ?>" onclick="return false;">Удалить</a>
								<? endif ?>
								<div style="float:right;">
									<a href="/id<?= $user_id ?>/bookmarks/delete_photo/<?= $photo['id'] ?>" adhr="/id<?= $user_id ?>/bookmarks/photo_ajax_add/<?= $photo['id'] ?>" class="delete_bookmark_link" rel="<?= $photo['id'] ?>" stat="1"  onClick="return flase;">убрать из закладок</a>
								</div>
							</div>
						</div>
						<? endif ?>
					</div>
					<div class="description">
						<?= $photo['description'] ?>
					</div>
				</div>
				<img src="<?=Yii::app()->request->baseUrl; ?>/static/css/modalWindowCorner.png" alt="" class="corner">
			</td>
			<td class="right">
				<div class="container">
					<span class="close closeMywnd closeLink">Закрыть</span>
					<!--<img src="<?=Yii::app()->request->baseUrl; ?>/static/css/close.png" class="close closeMywnd" />-->
					<div class="addTime">
						Добавлена <?= Yii::app()->dateFormatter->format('d MMMM yyyy', $photo['upload_date']) ?>
					</div>
					<div class="title">
						<?= $myProfile->first_name ?> <? $myProfile->second_name ?>
					</div>
					<div class="comments">
						<form action="/comments/add" id="photo_comments_form">
							<div class="commentForm">
								<div class="avatar">
									<img src="<?= Yii::app()->request->baseUrl ?>/upload/UserProfile/48x48/<?= $myProfile->avatar ?>" alt="" />
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