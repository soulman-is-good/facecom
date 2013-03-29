<div class="show_wnd">
	<div class="wnd_content" style="padding-right:0px;">
		<div class="job_view">
			<div class="field">
				<b>Профессиональная область:</b>
				<?= $data['profArea']['title'] ?>
			</div>
			<div class="field">
				<b>Название вакансии:</b> 
				<?= $job['title'] ?>
			</div>
			<div class="field">
				<b>Зарплата:</b> 
				<? if($job['salary'] == 0): ?>Договорная<? else: ?><?= $job['salary'] ?> <?= $data['currency']['title'] ?><? endif ?>
			</div>
			<div class="field">
				<b>Описание вакансии:</b>
				<p><?= str_replace("\n", "<br />", $job['description']) ?></p>
			</div>
			<div class="field">
				<b>Опыт работы:</b> 
				<?= $data['exp']['title'] ?>
			</div>
			<div class="field">
				<b>Тип занятости:</b>
				<?= implode(', ', $data['employment']) ?>
			</div>
		</div>
	</div>
</div>