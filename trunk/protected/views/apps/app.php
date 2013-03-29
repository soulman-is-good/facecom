<?php
$cur=(isset($list) && $list==='my')?1:0;
//$appAction=
//$this->createUrl('/apps/my',array('id'=>$id))
$this->renderPartial('//profile/profile/_info',array('profile'=>$profile));
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
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tr>
			<td class="left">
			 <?$this->renderPartial('//profile/profile/_appMenu',array('current'=>-1,'id'=>$profile->user_id));?>
             <?=CHtml::encode($app->caption);?><br /><br /><br />
             <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
                       codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
                       width="622" height="500" id="gamefile" align="middle">
                                        <param name="movie" value="<?=Yii::app()->request->baseUrl?>/static/apps/<?=$app->address?>" />
                    <param name="quality" value="high" />
                    <param name="wmode" value="window" />
                    <param name="allowfullscreen" value="false" />
                    <param name="allowfullscreeninteractive" value="false" />
                    <embed src="<?=Yii::app()->request->baseUrl?>/static/apps/<?=$app->address?>" quality="high" width="622" height="500"
                         name="gamefile" align="middle" wmode="window" allowfullscreen="false" allowfullscreeninteractive="false"                         flashvars=""
                        type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
             </object>
<br />
			</td>
			<? $this->renderPartial('//profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
<input type="hidden" name="wallOwner" value="<?= $profile->user_id ?>" />