<?php
if(!isset($popupCurrent)) $popupCurrent = null;
$menus = array(
    'Записи'=>$this->createUrl('profile/profile',array('id'=>$id)),
    'О себе'=>$this->createUrl('profile/profile/profile',array('id'=>$id)),
    'Фото'=>$this->createUrl('id'.$id.'/photos'),
    'Видео'=>$this->createUrl('id'.$id.'/video'),
    'Музыка'=>$this->createUrl('profile/profile',array('id'=>$id)),
    'Еще...'=>$this->createUrl('profile/profile',array('id'=>$id)),
);
$menusPopup = array(
    'Приложения'=>$this->createUrl('/apps/my',array('id'=>$id)),
    'Резюме'=>$this->createUrl('id'.$id.'/cv'),
    'Закладки'=>$this->createUrl('id'.$id.'/bookmarks'),
);
?>
<div class="userMenu">
    <?$i=0;foreach ($menus as $label=>$link):?>
    <a href="<?=$link?>"><div class="item<?=$i==$current?' active':''?>"<?=($i>0?' style="border-left: none;"':'')?><?=($i==5)?' onClick="popupHideShow(); return false;"':''?>><?=$label?></div></a>
    <?$i++;endforeach;?>
    <div id="popupBlock" style="display:none;" class="popupBlock">
    <?$i=5;foreach ($menusPopup as $label=>$link):?>
        <a href="<?=$link?>"><div class="item<?=$i==$popupCurrent?' active':''?>"<?=($i<7?' style="margin-bottom:10px;"':'')?>><?=$label?></div></a>
    <?$i++;endforeach;?>
    </div>
</div>
<script language="javascript">
var popupBlock=document.getElementById('popupBlock');
var popupBlockShowed=false;
function popupHideShow()
{
	popupBlock.style.display=popupBlockShowed?'none':'block';
	popupBlockShowed=!popupBlockShowed;
}
</script>
