<?php
$this->renderPartial('//office/_info');
?>
<div class="content">

	<table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="mainblock2">
				<? if($my_office): ?><a href="javascript:void(0)" class="addJob">Добавить вакансию</a><? endif ?>
				Вакансии (<?= count($jobs) ?>)
				<? foreach($jobs as $ind => $item): ?>
					<div class="job<? if($ind == 0): ?> first<? endif ?>">
						<div class="jobName">
							<a href="javascript:void(0)" class="<? if($my_office): ?>editJob<? else: ?>viewJob<? endif ?>" rel="<?= $item['id'] ?>"><?= $item['title'] ?></a> 
							<? if($my_office): ?>&nbsp;&nbsp;&nbsp; <a href="javascript:void(0)" class="deleteJob" rel="<?= $item['id'] ?>" style="font-size:11px;font-weight:normal;">Удалить</a> <? endif ?>
						</div>
						<? if(strlen($item['description']) > 590): ?> 
						 	<?= mb_substr($item['description'], 0, 590, 'utf-8') ?>...
						<? else: ?>
						 	<?= $item['description'] ?>
						<? endif ?>
						<br />
						<span class="date">Добавлено <?= Yii::app()->dateFormatter->format('d MMMM yyyy', $item['date']) ?> в <?= Yii::app()->dateFormatter->format('HH:mm', $item['date']) ?></span>
						<!--<div class="jobActions">
							<span class="likes">+225</span>
							<span class="reposts">21</span>
						</div>-->
					</div>
				<? endforeach ?>
			</td>
			<td class="rightblock">
			<?$this->renderPartial('//office/_right_table',array());?>
			</td>
		</tr>
	</table>
</div>
<input type="hidden" name="wallOwner" value="<?= $profile->user_id ?>" />