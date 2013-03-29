<?php
$this->renderPartial('//office/_info',array('form'=>'//office/__item_search'));
?>
<div class="content">
	<table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="leftblock">
			  <?$this->renderPartial('//office/_leftblock',array());?>
			</td>
			<td class="mainblock">
			<?
			foreach($models as $model):
                            $this->renderPartial('__item_list',array('model'=>$model));
			endforeach;
			?>
			</td>
		</tr>
	</table>
</div>