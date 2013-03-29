<?php
$this->renderPartial('//office/_info');
?>
<div class="content">
	<table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="mainblock2">
              <h1><?=$model->name?></h1>
              <p><?=nl2br($model->about)?></p>
			</td>
			<td class="rightblock">
			<?$this->renderPartial('//office/_right_table',array());?>
			</td>
		</tr>
	</table>
</div>