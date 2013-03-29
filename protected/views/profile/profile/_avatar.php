<div style="position: relative;">
    <div class="avatar">
        <img src="<?= Yii::app()->request->baseUrl ?>/upload/UserProfile/<?= $profile->avatar ?>" alt="">
        <?if($profile->user_id == Yii::app()->user->id):?>
        <div class="change_avatar" id="avatar">
            <a href="<?=$this->createUrl('profile/profile/editAvatar',array('id'=>Yii::app()->user->id))?>" facecom="crop" wtitle="Выберите фото для профиля" wbutton="Установить как фото профиля" aspect="1" preview="192">сменить аватар</a>
        </div>
        <?endif;?>
    </div>
</div>
