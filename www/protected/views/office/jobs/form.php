<div class="show_wnd">
	<div class="wnd_content" style="padding-right:0px;">
		<form action="/office<?= $oid ?>/jobs/save/<?= $mid ?>" method="post" class="create_jobs_frm">
			<!--<div class="field">
				<div class="label">Регион</div>
				<div class="select">
					<div class="selected">Алматы</div>
				</div>
			</div>-->
			<div class="field">
				<div class="label" style="margin:0px;">Профессиональная область</div>
				<div class="select">
					<div class="selected"><?= $fields['profArea'][$profAreaInd]['title'] ?></div>
					<input type="hidden" name="prof_area" value="<?= $fields['profArea'][$profAreaInd]['id'] ?>" />
					<div class="options" style="top:30px;width:208px;">
						<? foreach($fields['profArea'] as $prof): ?>
							<div class="option" val="<?= $prof['id'] ?>"><?= $prof['title'] ?></div>
						<? endforeach ?>
					</div>
				</div>
			</div>
			<div class="field">
				<div class="label">Название</div> 
				<input type="text" style="width:166px" name="title" value="<?= ((isset($job))?$job['title']:'') ?>" /> 
			</div>
			<div class="field">
				<div class="label">Описание</div> 
			</div>
			<div class="field">
				<textarea name="description"><?= ((isset($job))?$job['description']:'') ?></textarea>
			</div>
			<div class="field">
				<div class="label">Зарплата</div> 
				<input type="text" style="width:92px;" name="salary" value="<?= ((isset($job))?$job['salary']:'') ?>" /> 
				<div class="select" style="width:70px;left:-10px">
					<div class="selected"><?= $fields['currency'][$currencyInd]['title'] ?></div>
					<input type="hidden" name="currency" value="<?= $fields['currency'][$currencyInd]['id'] ?>" />
					<div class="options" style="top:30px;width:80px;">
						<? foreach($fields['currency'] as $item): ?>
							<div class="option" val="<?= $item['id'] ?>"><?= $item['title'] ?></div>
						<? endforeach ?>
					</div>
				</div>
			</div>
			<div class="field">
				<div class="label">Опыт работы</div> 
				<div class="select">
					<div class="selected"><?= $fields['exp'][$expInd]['title'] ?></div>
					<input type="hidden" name="experience" value="<?= $fields['exp'][$expInd]['id'] ?>" />
					<div class="options" style="top:30px;width:208px;">
						<? foreach($fields['exp'] as $item): ?>
							<div class="option" val="<?= $item['id'] ?>"><?= $item['title'] ?></div>
						<? endforeach ?>
					</div>
				</div>
			</div>
			<div class="field">
				<div class="label">Тип занятости</div>
				<div class="employment">
					<? foreach($fields['employment'] as $item): ?>
						<div class="field"><input type="checkbox" value="1" name="employment[<?= $item['id'] ?>]" id="emp_<?= $item['id'] ?>" <? if(in_array($item['id'], $empItems)): ?> checked <? endif ?> /> <label for="emp_<?= $item['id'] ?>"><?= $item['title'] ?></label></div>
						<div class="option" val="<?= $item['id'] ?>"></div>
					<? endforeach ?>
				</div>
			</div>
			<div class="field">
				<input type="submit" value="<? if($action == 'create'): ?>Создать<? else: ?>Сохранить<? endif ?>" class="blue" />
			</div>
		</form>
	</div>
</div>