<?php
$menus = array(
    'Товары и услуги'=>'office/items/index',
    'Записи'=>'office/posts/index',
    'О компании'=>'office/main/about',
    'Вакансии'=>'office/jobs/index',
    'Контакты'=>'office/main/contacts',
);
$oid = Yii::app()->request->getQuery('oid');
$url = Yii::app()->request->url;
if(strpos($url,'products')) {
    $current = 0;
}
elseif(strpos($url,'wall'))
    $current = 1;
elseif(strpos($url,'about'))
    $current = 2;
elseif(strpos($url,'jobs'))
    $current = 3;
elseif(strpos($url,'contacts'))
    $current = 4;
?>
<div class="userMenu">
    <?$i=0;foreach ($menus as $label=>$link):?>
    <a href="<?=$this->createUrl($link,array('oid'=>$oid))?>"><div class="item<?=$i==$current?' active':''?>"<?=($i>0?' style="border-left: none;"':'')?>><?=$label?></div></a>
    <?$i++;endforeach;?>
    <br clear="both" />
</div>
