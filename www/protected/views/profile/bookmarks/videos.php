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
					<?$this->renderPartial('//profile/profile/_menu',array('current'=>5,'popupCurrent'=>7,'id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tbody><tr>
			<td class="left">
				<div class="p_container">
					<?$this->renderPartial('_bookmarkMenu',array('id'=>$profile->user_id,'current'=>1));?>
				</div>
				<div class="pv_list_fl">
					<input type="hidden" id="loadMoreOffset" value="<?= $videos_count ?>" />
					<?= $list ?>
				</div>
				<div>
					<? if($videos_count >= 20): ?>
					<input type="button" value="Загрузить еще" class="loadMore" onclick="loadMoreBookmarkVideos(this)" />
					<? endif ?>
				</div>
			</td>
			<? $this->renderPartial('//profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</tbody></table>
</div>