<?php
$textPadding = '';
(isset($display) && $display == 'none') ? $display = 'display: none' : $display = '' ;
?>
<div class="entry" style="position: relative; <?= $display ?>" entry_id="<?= $item->id ?>">
	<div class="authorAvatar">
		<div style="position: relative">
			<img width="48" src="<?=Yii::app()->request->baseUrl ?><?= $item->authors->profile->getAvatar('mini') ?>" alt="" />
			<img src="<?=Yii::app()->request->baseUrl ?>/static/css/whatsNewArrow.png" alt="" class="arrow" />
		</div>
	</div>
	<div class="author">
		<? if ($item->parent_id != 0): ?>
			<? $post_owner = UserProfile::model()->getUserProfile($item->owner_id) ?>
			<a href="<?=Yii::app()->request->baseUrl ?>/id<?= $post_owner->user_id ?>">
				<strong><?= $post_owner->first_name ?> <?= $post_owner->second_name ?></strong>
			</a><br /><?= Yii::app()->dateFormatter->format('H:ss, d MMMM yyyy', $item->creation_date) ?><!-- 17:50, 15 октября 2012 -->
			<? if ($item->author_id == Yii::app()->user->id || $item->owner_id == Yii::app()->user->id): ?>
				<span class="control" onclick="deleteWallPost(this, '<?=Yii::app()->request->baseUrl ?>/posts/delete/', <?= $item->id ?>)">Удалить</span>
			<? endif ?>
			<?
                            $o_post = Posts::model()->findByPk($item->parent_id);
                            if($o_post!=null):
				$o_author = UserProfile::model()->getUserProfile($o_post->author_id); $textPadding = 'style="padding-left: 12px"';
			?>
			<div>
				<img style="margin-top: 4px;" src="<?= Yii::app()->request->baseUrl ?>/static/css/publishedBy.gif" alt="" title="Автор оригинала" /> <a href="<?= Yii::app()->request->baseUrl ?>/id<?= $o_author->user_id ?>"><img width="32" style="margin-top: 4px;" src="<?= Yii::app()->request->baseUrl ?><?= $o_author->getAvatar('micro') ?>" alt=""></a> <a href="<?= Yii::app()->request->baseUrl ?>/id<?= $o_author->user_id ?>"><strong><?= $o_author->first_name ?> <?= $o_author->second_name ?></strong></a>
			</div>
                        <?
                            endif;//$o_post == null
                        else: ?>
			<a href="<?=Yii::app()->request->baseUrl ?>/id<?= $item->authors->id ?>">
				<strong><?= $item->authors->profile->first_name ?> <?= $item->authors->profile->second_name ?></strong>
			</a><br /><?= Yii::app()->dateFormatter->format('H:ss, d MMMM yyyy', $item->creation_date) ?><!-- 17:50, 15 октября 2012 -->
			<? if ($item->author_id == Yii::app()->user->id || $item->owner_id == Yii::app()->user->id): ?>
				<span class="control" onclick="deleteWallPost(this, '<?=Yii::app()->request->baseUrl ?>/posts/delete/', <?= $item->id ?>)">Удалить</span>
			<? endif ?>
		<? endif ?>
	</div>
	<div class="text" <?= $textPadding ?>>
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
		<?
		$multimedia = json_decode($item->multimedia);
		if(is_array($multimedia)):
		foreach($multimedia as $ind => $file):
		    $image = Files::model()->findByPk($file->id);
		?>
		<div class="all_posts_files_item"><a href="/id<?= $item->authors->id ?>/aphotos/showposts/<?= $file->nomber ?>/<?= $item->id ?>"><img src="<?=Yii::app()->request->baseUrl ?>/upload/photos/80x80/<?= $image->id ?>.<?= $image->extension ?>" alt="" /></a></div>
		<?endforeach; endif;?>
	</div>
	<div class="information">
		<span class="rating"><img src="<?=Yii::app()->request->baseUrl ?>/static/css/like.png" alt="" onclick="_like(this, '<?= Yii::app()->request->baseUrl ?>/like', 'posts', '<?= $item->id ?>')" title="Нравится" /> <span class="likeCount"><?= $item->likes ?></span>&nbsp;&nbsp;<img src="<?=Yii::app()->request->baseUrl ?>/static/css/like2.png" alt="" title="Добавить себе" onclick="_share(this, '<?= Yii::app()->request->baseUrl ?>/share', '<?= $item->id ?>')" /> <span class="shareCount"><?= $item->shares ?></span></span>
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