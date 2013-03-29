<?php
$partname = CHtml::encode($profile->first_name) . " " . CHtml::encode($profile->second_name);
?>
<?php
/* проверка на взаимосвязь дружбы */
$u_id = Yii::app()->user->id;
$c_u_id = $_GET['id'];
$are_friends = UserFriends::model()->areFriends($u_id, $c_u_id);
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
	<img src="/upload/UserProfile/<?= $profile->background ?>" alt="" />
        <?if($profile->user_id == Yii::app()->user->id):?>
        <div class="change_avatar"><a callback="userBackgroundHandle" facecom="crop" href="<?=$this->createUrl('profile/profile/editBackground',array('id'=>Yii::app()->user->id))?>">сменить подложку</a></div>
        <?endif;?>        
</div>