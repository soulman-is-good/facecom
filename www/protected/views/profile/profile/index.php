<?php
$this->renderPartial('_info',array('profile'=>$profile));
?>
<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
				<?$this->renderPartial('_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('_menu',array('current'=>'0','id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tr>
			<td class="left">
				<div class="whatsNew">
					<form action="<?=Yii::app()->request->baseUrl ?>/posts/add" method="post">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top" class="avatar">
									<div style="position: relative">
										<img width="48" src="<?=Yii::app()->request->baseUrl ?><?= $myProfile->getAvatar('mini') ?>" alt="" />
										<img src="<?=Yii::app()->request->baseUrl ?>/static/css/whatsNewArrow.png" alt="" class="arrow" />
									</div>
								</td>
								<td width="100%" class="text">
									<div class="whatsNewAreaContainer overflowContainer">
										<div class="attach">
											<img src="<?=Yii::app()->request->baseUrl ?>/static/css/attachImage.png" class="userWallAttachImage" url="/id<?= $profile->user_id ?>/attach/photo" alt="" style="border-right: solid 1px #e1e1e1" /><img src="<?=Yii::app()->request->baseUrl ?>/static/css/attachVideo.png" alt="" style="border-right: solid 1px #e1e1e1" /><img src="<?=Yii::app()->request->baseUrl ?>/static/css/attachFile.png" alt="" />
										</div>
										<textarea name="content" id="whatsNewArea" cols="58" rows="5" onfocus="this.value=(this.value=='Что нового') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Что нового' : this.value;">Что нового</textarea>
										<input type="hidden" name="owner_type" value="user" />
										<input type="hidden" name="owner_id" value="<?= $profile->user_id ?>" />
										<input type="hidden" name="author_type" value="user" />
										<input type="hidden" name="post_type" value="userwall" />
										<? if (!empty($wall[0]['id'])): ?>
											<input type="hidden" name="lastEntryId" value="<?= $wall[0]['id'] ?>" />
										<? else: ?>
											<input type="hidden" name="lastEntryId" value="-1" />
										<? endif ?>
									</div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<div id="post_appending_preview"></div>
									<input type="submit" id="send" value="Отправить" />
									<input type="button" id="cancel" value="Отмена" style="display: none" />
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div id="postsContainer">
					<?
						foreach ($wall as $item) {
							$this->renderPartial('//posts/_postItem', array('item' => $item, 'comments' => Comments::model()->getLast('posts', $item->id), 'count' => Comments::model()->countComments('posts', $item->id), 'owner' => $profile->user_id));
						}
					?>
				</div>
				<? if (count($wall) == Yii::app()->params->maxPostPerRequest): ?>
					<input type="button" class="loadMore" value="Загрузить еще" onclick="loadMorePosts(this, 'userwall', 'user', <?= $profile->user_id ?>)" />
				<? endif ?>
			</td>
			<? $this->renderPartial('_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
