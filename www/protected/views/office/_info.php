<?php
if(Yii::app()->params['office']==null){
    $oid = Yii::app()->request->getQuery('oid');
    if($oid>0){
        $profile = Office::model()->findByPk($oid);
        Yii::app()->params['office'] = $profile;
    }
}else
    $profile = Yii::app()->params['office'];
    if($profile):
    $pos = explode(' ',$profile->bgposition);
    $pos = count($pos)==2?$pos:array(0,0);
    $cart = Yii::app()->user->getState('cart');
?>
<div class="avatarAndMenu">
    <div class="userName">
            <div class="cartStat">
                <?if(empty($cart)):?>
                <a href="#">Корзина пуста</a>
                <?else:?>
                <a href="#">В корзине <?=array_sum($cart);?> товаров</a>
                <?endif;?>
            </div>
        <h1><?=$profile->name?> 
            <a href="<?=$this->createUrl('office/main/edit',array('oid'=>$profile->id))?>"><?=Yii::t('site','изменить');?></a></h1>
    </div>
    <div class="userBG">
        <div class="userCover" style="background-position:-<?=$pos[0]?>px -<?=$pos[1]?>px;background-image:url(<?=$profile->getBackground()?>)">&nbsp;</div>
        <div class="avatar">
            <img src="<?= $profile->getAvatar('avatar') ?>" alt="" />
        </div>
    </div>
    <div class="menu">
        <? $this->renderPartial('//office/_menu', array('current' => 2)); ?>
    </div>
    <?if(isset($form)):?>
    <? $this->renderPartial($form); ?>
    <?endif;?>
</div>
<?endif;?>