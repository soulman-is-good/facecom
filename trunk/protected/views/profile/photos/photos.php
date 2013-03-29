<?php
$this->renderPartial('//profile/profile/_info',array('profile'=>$profile));
?>
<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
				<?$this->renderPartial('//profile/profile/_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('//profile/profile/_menu',array('current'=>2,'id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tbody><tr>
			<td class="left">
				<div class="p_container">
					<div class="p_container_left"><a href="/id<?= $profile['user_id'] ?>/photos">Все альбомы</a> &gt; <?= $album['title'] ?><div class="p_container_left_created"><?= $model->getCountInAlbum($album['id']) ?> фото - создан <?= Yii::app()->dateFormatter->format('d MMMM', $album['create_date']) ?></div></div>
					<? if($myPage): ?>
					<div class="p_container_right"><input type="button" value="Добавить фото" album="<?= $album['id'] ?>" id="addPhotoBtn" /></div>
					<? endif ?>
				</div>
				<div class="pv_list_fl">
					<input type="hidden" id="loadMoreOffset" value="<?= $photos_count ?>" />
					<?= $list ?>
				</div>
				<div>
					<? if($photos_count >= 20): ?>
					<input type="button" value="Загрузить еще" class="loadMore" onclick="loadMorePhotos(this, <?= $album['id'] ?>)" />
					<? endif ?>
				</div>
			</td>
			<? $this->renderPartial('//profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</tbody></table>
</div>