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
					<?$this->renderPartial('//profile/profile/_menu',array('current'=>3,'id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tbody><tr>
			<td class="left">
				<div class="p_container">
					<div class="p_container_left">Видео (<?= $videos_count ?>)<div class="p_container_left_created"></div></div>
					<? if($myPage): ?>
					<div class="p_container_right"><input type="button" value="Добавить видео" id="addVideoBtn" /></div>
					<? endif ?>
				</div>
				<div class="pv_list_fl">
					<input type="hidden" id="loadMoreOffset" value="0" />
					<?foreach($videos as $ind=>$video):?>
					<a href="/id<?= $profile->user_id ?>/avideos/show/<?= $video['id'] ?>" class="pw_list_item_open_link">
						<div class="pw_list_item_open" id="pw_list_item_open_<?= $video['id'] ?>" style="position:relative;">
							<img src="<?=Yii::app()->request->baseUrl; ?>/images/small/<?=$video['file']?>.jpg" alt="" />
							<? if(!empty($video['description'])): ?><div class="video_description"><?= $video['description'] ?></div><? endif ?>
						</div>
					</a>
					<?endforeach?>
				</div>
				<div>
					<? if($videos_count >= 20): ?>
					<input type="button" value="Загрузить еще" class="loadMore" onclick="loadMorePhotos(this, 0)" />
					<? endif ?>
				</div>
			</td>
			<? $this->renderPartial('//profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</tbody></table>
</div>
