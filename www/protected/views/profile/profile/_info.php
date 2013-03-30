<?php
$partname = CHtml::encode($profile->first_name) . " " . CHtml::encode($profile->second_name);
?>
<?php
/* проверка на взаимосвязь дружбы */
$u_id = Yii::app()->user->id;
$c_u_id = $_GET['id'];
$are_friends = UserFriends::model()->areFriends($u_id, $c_u_id);
$pos = explode(' ',$profile->bgposition);
$pos = count($pos)==2?$pos:array(0,0);
?>
<div class="userName">
    <h1><?=$partname?> 
        <?if($profile->user_id == Yii::app()->user->id):?>
            <a href="<?=$this->createUrl('profile/profile/edit',array('id'=>$profile->user_id))?>"><?=Yii::t('site','изменить');?></a>

        <?elseif($are_friends == 'friends'):?>
            <span><a onclick="deleteFriendship(this,'<?=$this->createUrl('profile/profile/DeleteFriendship',array('id'=>$u_id, 'f_id'=>$c_u_id))?>')" href="#" class="blue"><?=Yii::t('site','Удалить из друзей');?></a></span>

        <?elseif($are_friends == 'myrequest'):?>
            <span><font class="grey">Вы отправили заявку,</font>
                    <a onclick="deleteRequest(this,'<?=$this->createUrl('profile/profile/DeleteRequest',array('id'=>$u_id, 'f_id'=>$c_u_id))?>')" href="#" class="blue"><?=Yii::t('site','Удалить вашу заявку?');?><a></span>

        <?elseif($are_friends == 'request'):?>
            <span><a onclick="confirmRequest(this,'<?=$this->createUrl('profile/profile/ConfirmRequest',array('id'=>$u_id, 'f_id'=>$c_u_id))?>')" href="#"  class="blue"><?=Yii::t('site','Принять заявку');?></a>
                  <a onclick="rejectRequest(this,'<?=$this->createUrl('profile/profile/RejectRequest',array('id'=>$u_id, 'f_id'=>$c_u_id))?>')" href="#" class="blue"><?=Yii::t('site','Удалить заявку');?><a></span>
        
        <?elseif($are_friends == 'false'):?>
            <span><a onclick="addFriend(this,'<?=$this->createUrl('profile/profile/AddFriend',array('id'=>$u_id, 'f_id'=>$c_u_id))?>')" href="#" class="blue"><?=Yii::t('site','Добавить в друзья');?></a></span>
        <?endif;?>
    </h1>
</div>
<div class="userBG">
    <div class="userCover" style="background-image:url(<?=$profile->getBackground()?>);background-position:-<?=$pos[0]?>px -<?=$pos[1]?>px">
        &nbsp;
        <?if($profile->user_id == Yii::app()->user->id):?>
        <div class="change_bg"><a callback="userBackgroundHandle" facecom="crop" href="<?=$this->createUrl('profile/profile/editBackground',array('id'=>Yii::app()->user->id))?>">сменить подложку</a></div>
        <?endif;?>        
    </div>
    <div class="avatar">
        <div style="position: relative;overflow: hidden;width:190px;height:191px;">
            <img src="<?= $profile->getAvatar() ?>" title="<?=$profile->fullName?>" />
        </div>
        <?if($profile->user_id == Yii::app()->user->id):?>
        <div class="change_avatar" id="avatar">
            <a href="<?=$this->createUrl('profile/profile/editAvatar',array('id'=>Yii::app()->user->id))?>" facecom="crop" wtitle="Выберите фото для профиля" wbutton="Установить как фото профиля" aspect="1" preview="192">сменить аватар</a>
        </div>
        <?endif;?>
    </div>
</div>