<? (isset($display) && $display == 'none') ? $display = 'display: none' : $display = '' ?>
<div class="entry" style="position: relative; <?= $display ?>" entry_id="<?= $item->id ?>">
	<div class="authorAvatar">
		<div style="position: relative">
			<img width="48" src="<?=Yii::app()->request->baseUrl ?><?= $item->authors->profile->getAvatar('mini') ?>" alt="" />
			<img src="<?=Yii::app()->request->baseUrl ?>/static/css/whatsNewArrow.png" alt="" class="arrow" />
		</div>
	</div>
	<div class="author">
		<a href="<?=Yii::app()->request->baseUrl ?>/id<?= $item->authors->id ?>">
			<strong><?= $item->authors->profile->first_name ?> <?= $item->authors->profile->second_name ?></strong>
		</a><br /><?= Yii::app()->dateFormatter->format('H:ss, d MMMM yyyy', $item->create_time) ?><!-- 17:50, 15 октября 2012 -->
		<? if ($item->author_id == Yii::app()->user->id || $item->owner_id == Yii::app()->user->id): ?>
			<span class="control" onclick="deleteWallPost(this, '<?=Yii::app()->request->baseUrl ?>/id<?= $item->owner_id ?>/posts/delete/<?= $item->id ?>')">Удалить</span>
		<? endif ?>
		<? if ($item->master_id != 0): ?>
			<? $master = UserProfile::model()->getUserProfile($item->master_id); $textPadding = 'style="padding-left: 12px"'; ?>
			<div>
				<img style="margin-top: 4px;" src="<?= Yii::app()->request->baseUrl ?>/static/css/publishedBy.gif" alt="" title="Автор оригинала" /> <a href="<?= Yii::app()->request->baseUrl ?>/id<?= $item->master_id ?>"><img style="margin-top: 4px;" src="<?= Yii::app()->request->baseUrl ?>/upload/UserProfile/32x32/<?= $master->avatar ?>" alt=""></a> <a href="<?= Yii::app()->request->baseUrl ?>/id<?= $item->master_id ?>"><strong><?= $master->first_name ?> <?= $master->second_name ?></strong></a>
			</div>
		<? endif ?>
	</div>
	<div class="text" <?= isset($textPadding)?$textPadding:'' ?>>
		<? 
			$full = preg_replace('/([^\s]{35})[^\s]+/', '<span title="$0">$1...</span>', nl2br($item->content));
			if (mb_strlen($full, 'UTF-8') > 300):
		?>
			<div class="fullText">
				<?= $full ?>
			</div>
			<div class="shortText">
				<?= $short = mb_substr($full, 0, 300, 'UTF-8') ?>...
			</div>
			<span class="blue" onclick="showFull(this)">Показать полностью ...</span>
		<? else: ?>
			<?= $full ?>
		<? endif ?>
	</div>
	<div class="all_posts_files">
		<? if(isset($files)):foreach($files as $file): ?>
			<? if($file['type'] == 'photos'): ?>
				<div class="all_posts_files_item"><a href="/id<?= $item->authors->id ?>/aphotos/showposts/<?= $file['id'] ?>"><img src="/upload/photos/80x80_<?= $file['filename'] ?>" alt="" /></a></div>
			<? endif ?>
		<? endforeach;endif; ?>
	</div>
	<div class="information">
		<span class="rating"><img src="<?=Yii::app()->request->baseUrl ?>/static/css/like.png" alt="" onclick="_like(this, '<?= Yii::app()->request->baseUrl ?>/like', 'posts', '<?= $item->id ?>')" title="Нравится" /> <span class="likeCount"><?= $item->likes ?></span>&nbsp;&nbsp;<img src="<?=Yii::app()->request->baseUrl ?>/static/css/like2.png" alt="" title="Добавить себе" onclick="_share(this, '<?= Yii::app()->request->baseUrl ?>/share', 'posts', '<?= $item->id ?>')" /> <span class="shareCount"><?= $item->shares ?></span></span>
	</div>
	<div class="comments">
		<div class="count" count="<?= $count=isset($count)?$count:0 ?>">
			<? if ($count == 0): ?>
				Комментарии отсутствуют
			<? elseif ($count <= 5): ?>
				
			<? else: ?>
				Показаны последние 5 комментариев из <?= $count ?> <a href="javascript:void(0)" class="blue" onclick="showAllComments(this, '<?=Yii::app()->request->baseUrl ?>/comments/showAll', 'posts', <?= $item->id ?>)">Показать все</a>
			<? endif ?>
		</div>
		<div class="commentsContainer">
			<? if (!empty($comments)): ?>
				<? foreach ($comments as $comment): ?>
					<? $this->renderPartial('//comments/comments/_commentsItem', array('item' => $comment, 'owner' => $owner)) ?>
				<? endforeach ?>
			<? endif ?>
		</div>
		<form action="<?=Yii::app()->request->baseUrl ?>/comments/add" method="post">
			<div class="addCommentAreaContainer">
				<input type="hidden" name="tbl" value="posts" />
				<input type="hidden" name="item_id" value="<?= $item->id ?>" />
				<input type="hidden" name="owner" value="<?= $owner ?>" />
				<textarea name="text" class="addCommentArea" cols="58" rows="5" onfocus="this.value=(this.value=='Добавить комментарий') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Добавить комментарий' : this.value;">Добавить комментарий</textarea>
			</div>
			<div class="buttons">
				<input type="submit" class="send" value="Отправить" />
				<input type="button" class="cancel" value="Отмена" />
			</div>
		</form>
	</div>
</div>
