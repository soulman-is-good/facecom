<?php
$url = trim($_SERVER['REQUEST_URI'],'/');
$url = strtok($url, '/');
$strings = array(
    'news'=>'Новости',
    'profile'=>'Профиль',
    'business'=>'Бизнес',
    'office'=>'Офис',
    'advert'=>'Реклама',
);
if(preg_match("/^id[0-9]+/",$url)>0)
        $url = 'profile';
if(preg_match("/^office.*/",$url)>0)
        $url = 'office';
if(isset($strings[$url]))
    $strings[$url] = CHtml::tag('span', array(), $strings[$url]);
?>
<div class="leftMenu">
    <a href="/news/">
        <div class="item">
            <div class="img news<?=$url=='news'?' active':''?>">
                <img src="/static/css/leftMenuCornerActive.png" alt="" class="corner" />
            </div>
            <div class="title">
                <?=$strings['news']?>
            </div>
        </div>
    </a>
    <a href="<?= $this->createUrl('profile/profile', array('id' => Yii::app()->user->id)) ?>">
        <div class="item">
            <div class="img profile<?=$url=='profile'?' active':''?>">
                <img src="/static/css/leftMenuCornerActive.png" alt="" class="corner" />
            </div>
            <div class="title">
                <?=$strings['profile']?>
            </div>
        </div>
    </a>
    <a href="/business/">
        <div class="item">
            <div class="img business<?=$url=='business'?' active':''?>">
                <img src="/static/css/leftMenuCornerActive.png" alt="" class="corner" />
            </div>
            <div class="title">
                <?=$strings['business']?>
            </div>
        </div>
    </a>
    <a href="<?=$this->createUrl('//office')?>">
        <div class="item">
            <div class="img office<?=$url=='office'?' active':''?>">
                <img src="/static/css/leftMenuCornerActive.png" alt="" class="corner" />
            </div>
            <div class="title">
                <?=$strings['office']?>
            </div>
        </div>
    </a>
    <a href="/advert">
        <div class="item">
            <div class="img ads<?=$url=='advert'?' active':''?>">
                <img src="/static/css/leftMenuCornerActive.png" alt="" class="corner" />
            </div>
            <div class="title">
                <?=$strings['advert']?>
            </div>
        </div>
    </a>
</div>