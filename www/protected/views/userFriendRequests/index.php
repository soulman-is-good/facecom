<?php
$this->renderPartial('../profile/profile/_info',array('profile'=>$profile));
?>
<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
                            <?$this->renderPartial('../profile/profile/_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('../profile/profile/_menu',array('current'=>'0','id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tr>
			<td class="left">
				<div id="postsContainer">
					<div class="c_container">
						<div class="c_container_left">Все подписчики (<? echo count($requestcount) ?>)</div>
					</div>
					<br>
					<? foreach ($friendsrequests as $item): ?>
						<? $this->renderPartial('_friendRequestItem', array('item' => $item)) ?>
					<? endforeach ?>

				</div>
			</td>
			<? $this->renderPartial('../profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
<input type="hidden" name="wallOwner" value="<?= $profile->user_id ?>" />