<?$appcount=count($apps);
$aid=0;
$a1=Yii::app()->request->baseUrl.'/id'.Yii::app()->user->id.'/apps/';?>
<? (isset($display) && $display == 'none') ? $display = 'display: none;' : $display = '' ?>
<table border="0" cellspacing="10" cellpadding="0" class="appList" style="margin-right:-14px; margin-left:-10px; <?=$display?>">
<?for($i=0;$i<4;$i++):
if($aid>=$appcount)break;?>
<tr>
<?for($ii=0;$ii<3;$ii++):
	if($aid>=$appcount)break;
	$ca=$apps[$aid];
	$iHasIt=(in_array($ca->id,$user_apps_ids))?true:false;
	$cp=($iHasIt)?'my':'';
	$appAction=($iHasIt)?$a1.'play/':$a1.'add/';
	$appDelete=$a1.'delete/';
	$appButtonLabel=($iHasIt)?'играть':'добавить и играть';
	?>
	<td>
	<div onmouseover="showDesc(<?=$ca->id?>);" onmouseout="hideDesc(<?=$ca->id?>);" class="appItem">
		<img src="<?=Yii::app()->request->baseUrl?>/images/apps/<?=$ca->tn?>" width="180" height="165" alt="<?=$ca->caption?>" border="0" id="appImg<?=$ca->id?>" style="display:block;" />
		<div class="<?=$cp?>appDesc" id="appDesc<?=$ca->id?>" style="display:none;">
			<div class="title"><?=CHtml::encode($ca->caption)?></div>
			<?=CHtml::encode($ca->desc)?>
			<div class="btnAlign">
				<?/*<a href="<?=$this->createUrl('apps/play/'.$ca->id,array('id'=>Yii::app()->user->id))?>"><div class="setupBtn"><?=$appButtonLabel?></div></a>*/?>
				<a href="<?=$appAction.$ca->id?>"><div class="setupBtn"><?=$appButtonLabel?></div></a>
				<?if($iHasIt):?>
                <a href="<?=$appDelete.$ca->id?>" onCLick="return confirm('Удалить приложение?');"><div class="setupBtn" style="margin-top:10px;">удалить</div></a>
				<?endif;?>
			</div>
		</div>
		<a href="<?=$appAction.$ca->id?>"><?=CHtml::encode($ca->caption)?></a><br />
		<font class="usersCount">Пользователей: <?=Apps::model()->explodeToTreads($ca->users)?></font>
	</div>
	</td>
	<?$aid++;?>
<?endfor;?>
</tr>
<?endfor;?>
</table>