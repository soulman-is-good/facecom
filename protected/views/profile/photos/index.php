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
					<div class="p_container_left">Альбомы (<?= $albums_count ?>)</div>
					<? if($myPage): ?>
					<div class="p_container_right"><input type="button" value="Добавить фото" album="0" id="addPhotoBtn" /></div>
					<? endif ?>
				</div>
				<div class="pv_list_fl">
					<?foreach($albums as $ind=>$album):?>
					<div class="pw_list_item" <?=((($ind + 1) % 3 == 0)?'style="margin-right:0px;"':'')?>>
						<div class="pw_album_header">
							<? if($myPage): ?>
							<div class="pw_album_header_left">
								<img src="<?=Yii::app()->request->baseUrl; ?>/static/css/favorites_icon.png" alt="" />
							</div>
							<div class="pw_album_header_right">
								<a href="/id<?= $profile['user_id'] ?>/aphotos/edit_album/<?= $album['id'] ?>" class="edit_album_link"><img src="<?=Yii::app()->request->baseUrl; ?>/static/css/edit_icon.png" alt="" /></a>&nbsp;
								<a href="/id<?= $profile['user_id'] ?>/aphotos/delete_album/<?= $album['id'] ?>" class="delete_album_link"><img src="<?=Yii::app()->request->baseUrl; ?>/static/css/delete_icon.png" alt="" /></a>
							</div>
							<? endif ?>
						</div>
						<div class="pw_album_content">
							<a href="/id<?= $profile['user_id'] ?>/photos/show/<?= $album['id'] ?>">
								<? 
								if($album['current_photo']==0) 
									$poster_photo = $photos->getLastInAlbum($album->id) ;
								else 
									$poster_photo = $photos->findByPk($album['current_photo']); 
                                                                if($poster_photo):
								?>
								<img src="<?=Yii::app()->request->baseUrl; ?>/upload/photos/album/<?= $poster_photo->file.'.'.$poster_photo->image->extension; ?>" alt="" />
                                                                <?endif;?>
							</a>
							<div class="pw_list_item_title">
								<a href="/id<?= $profile['user_id'] ?>/photos/show/<?= $album['id'] ?>"><?=$album['title']?></a>
							</div>
							<div class="pw_list_item_description">
								<?=$photos->getCountInAlbum($album['id'])?> фото
							</div>
							<div class="pw_list_item_description">
								<?=Yii::app()->dateFormatter->format('d MMMM yyyy', $album->create_date);?>
							</div>
						</div>
						<div class="pw_album_footer"></div>
					</div>
					<?endforeach?>
				</div>
			</td>
			<? $this->renderPartial('//profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</tbody></table>
</div>