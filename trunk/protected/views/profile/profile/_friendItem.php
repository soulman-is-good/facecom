<div>
	<div class="authorAvatar">
		<div style="position: relative">
			<?
				if (empty($item->invited->profile->avatar) || !is_file('/upload/UserProfile/48x48_' . $item->invited->profile->avatar)) {
					$item->invited->profile->avatar = '48x48_testAvatar.png';
				}
			?>
			<img src="upload/UserProfile/<?= $item->invited->profile->avatar ?>" alt="" title="<?= $item->invited->profile->first_name ?> <?= $item->invited->profile->second_name ?>" />
			<img src="static/css/whatsNewArrow.png" alt="" class="arrow" />
		</div>
	</div>
	<!-- <div class="author">
		<strong><?/*= $item->invited->profile->first_name ?> <?= $item->invited->profile->second_name */?></strong> <? /*= Yii::app()->dateFormatter->format('H:ss, d MMMM yyyy', $item->timestamp) */?>
	</div> -->
	<!-- <div class="text">
		<?/*= nl2br($item->text) */?>
	</div> -->
	
</div>