<?php
if(!isset($app))
    $app = false;
$all=($list==='my')?false:true;
//$classPrefix=($list==='my')?'my':'';
if(!isSet($user_apps_ids))$user_apps_ids=array();
$isMyList=(($list==='my')&&($profile->user_id==Yii::app()->user->id))?true:false;
$userplabel=($isMyList)?'Мои приложения':$profile->first_name.': приложения';
$countlabel=($list==='my')?$userplabel:'Приложения';
$this->renderPartial('../profile/profile/_info',array('profile'=>$profile));
?>
<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
                            <?$this->renderPartial('//profile/profile/_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('//profile/profile/_menu',array('current'=>'5','id'=>$profile->user_id,'popupCurrent'=>'5'));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall" style="margin-left:-10px;">
		<tr>
			<td class="left">
			<div  id="appsContainer">
			<?$this->renderPartial('//profile/profile/_appMenu',array('all'=>$all,'id'=>$profile->user_id,'isMyList'=>$isMyList));?>
             <?=$app?>
             &nbsp;&nbsp;&nbsp;<?=$countlabel?> (<?=$total?>)<br /><br /><br />
<?$this->renderPartial('_appTable',array('apps'=>$apps,'user_apps_ids'=>$user_apps_ids));?>
</div>
<script language="javascript">
function showDesc(id)
{
	/*var hiding=document.getElementById("appImg"+id);*/
	var showing=document.getElementById("appDesc"+id);
	/*hiding.style.display="none";*/
	showing.style.display="block";
}
function hideDesc(id)
{
	var hiding=document.getElementById("appDesc"+id);
	/*var showing=document.getElementById("appImg"+id);*/
	hiding.style.display="none";
	/*showing.style.display="block";*/
}
</script>
<center>
<?if(count($apps)<$total):
$offset=Yii::app()->params->maxAppsPerRequest;?>
<input type="hidden" name="maxAps" id="maxAps" value="<?=$total?>" />
<div id="jqdata" style="display:none" lastOffset="<?=$offset?>" maxAps="<?=$total?>" list="<?=$list?>"></div>
<input type="button" class="moreApps" value="Показать еще приложения" onclick="loadMoreApps(this, <?= $profile->user_id ?>)" />
<?endif;?>
</center><br />
			</td>
			<? $this->renderPartial('//profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
<input type="hidden" name="wallOwner" value="<?= $profile->user_id ?>" />