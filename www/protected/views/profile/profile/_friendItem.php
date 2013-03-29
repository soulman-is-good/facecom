<div>
	<div class="authorAvatar">
		<div style="position: relative">
			<img width="" src="<?= $item->invited->profile->getAvatar() ?>" alt="" title="<?= $item->invited->profile->first_name ?> <?= $item->invited->profile->second_name ?>" />
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