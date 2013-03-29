<?php
$this->renderPartial('_info',array('profile'=>$profile));
?>
<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
				<?$this->renderPartial('_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('_menu',array('current'=>'0','id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tr>
			<td class="left">
<span class="title"><?=$iv->title?></span><br /><br />
        <form name="iv<?=$iv->id?>" action="advert/interviews/useranswer" method="post" onSubmit="return ivAnswer('iv<?=$iv->id?>');">
        <?
        $cq=1;
        $questions=json_decode($iv->questions,true);
        foreach($questions as $q){?>
        	<span class="text"><?=$q['question']?></span><br />
        	<?
        	foreach($q['answs'] as $ca=>$a){
        		?><input name="q[<?=$cq?>]" type="radio" value="<?=$ca?>" id="a<?=$cq.$ca?>" /><label for="a<?=$cq.$ca?>" class="graytext"><span><span></span></span><?=$a?></label><br /><?
        	}
        	$cq++;
        }
        ?>
        <center><input type="submit" value="отправить"></center>
        </form>
			</td>
			<? $this->renderPartial('_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
