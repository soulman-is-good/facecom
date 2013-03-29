<?php
?>
<div class="content" style="min-height:500px">
        <h1>Ваши офисы</h1>
	<table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="mainblock">
                        <div><a href="<?=$this->createUrl('office/create')?>" class="button">Создать офис</a></div>
                        <br clear="all" />
                        <?if(count($models)>0):?>
			<?foreach($models as $model):
				$this->renderPartial('//office/_office_item',array('model'=>$model));
			endforeach;
			?>
                        <?else:?>
                        Не создано ни одного офиса
                        <?endif;?>
			</td>
		</tr>
	</table>
    </div>