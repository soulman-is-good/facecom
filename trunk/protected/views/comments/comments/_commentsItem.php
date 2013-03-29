<? if (isset($display) && $display == 'none')
	$display = 'style="display: none"';
    else
        $display = '';
?>
<div class="item" <?= $display ?> commentId="<?= $item->id ?>">
	<div class="c_avatar">
		<img src="<?=Yii::app()->request->baseUrl ?>/upload/UserProfile/48x48/<?=$item->authors->profile->avatar?>" alt="" />
	</div>
	<div class="c_content">
		<div class="c_author">
			<a href="<?=Yii::app()->request->baseUrl ?>/id<?= $item->authors->id ?>">
				<strong><?= $item->authors->profile->first_name ?> <?= $item->authors->profile->second_name ?></strong>
			</a><br />
			<?= Yii::app()->dateFormatter->format('H:ss, d MMMM yyyy', $item->timestamp) ?>
			<? if ($item->author_id == Yii::app()->user->id || $item->owner_id == Yii::app()->user->id): ?>
				<span class="control" onclick="deleteComment(this, '<?=Yii::app()->request->baseUrl ?>/comments/delete', <?= $item->id ?>)">Удалить</span>
			<? endif ?>
		</div>
		<div class="c_text">
			<?
				$full = preg_replace('/([^\s]{35})[^\s]+/', '<span title="$0">$1...</span>', nl2br($item->text));
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
	</div>
	<div class="information2">
		<span class="rating"><img src="<?=Yii::app()->request->baseUrl ?>/static/css/like.png" alt="" onclick="_like(this, '<?= Yii::app()->request->baseUrl ?>/like', 'comments', '<?= $item->id ?>')" /> <span class="likeCount"><?= $item->likes ?></span></span>
	</div>
</div>