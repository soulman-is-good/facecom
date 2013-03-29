<?
$menus = array(
    'Фотографии'=>$this->createUrl('id'.$id.'/bookmarks'),
    'Видео'=>$this->createUrl('id'.$id.'/bookmarks/video'),
    'Записи'=>$this->createUrl('id'.$id.'/photos'),
    'Люди'=>$this->createUrl('profile/profile',array('id'=>$id)),
    'Компании'=>$this->createUrl('profile/profile',array('id'=>$id)),
    'Товары'=>$this->createUrl('profile/profile',array('id'=>$id)),
);
?>
<div class="bookmarkMenu">
    <?$i=0;foreach ($menus as $label=>$link):?>
    <a href="<?=$link?>"><div class="item<?=$i==$current?' active':''?>"<?=($i>0?' style="border-left: none;"':'')?>><?=$label?></div></a>
    <?$i++;endforeach;?>
</div>