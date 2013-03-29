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
						<div class="c_container_left">Общие друзья c <a class="blue_little" href="/id<?php echo $mutualfriendinfo->user_id?>"><?php echo $mutualfriendinfo->first_name . ' ' . $mutualfriendinfo->second_name ?></a> </div>
					</div>
					<br>
					<? foreach ($mutualfriends as $item): ?>
						<? $this->renderPartial('_mutualfriendItem', array('item' => $item)) ?>
					<? endforeach ?>

				</div>
			</td>
			<? $this->renderPartial('../profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
<input type="hidden" name="wallOwner" value="<?= $profile->user_id ?>" />