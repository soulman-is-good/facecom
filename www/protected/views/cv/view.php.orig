<?php
$this->renderPartial('../profile/profile/_info',array('profile'=>$profile));

$s_id = $cvview[0]['family'];
if($cvview[0]['gender'] == '0'){
	$status = array(
		'0' => 'холост',
		'1' => 'женат',
		'2' => 'есть подруга',
		'3' => 'в активном поиске',
	);
} else {
	$status = array(
		'0' => 'не замужем',
		'1' => 'замужем',
		'2' => 'есть друг',
		'3' => 'в активном поиске',
	);	
}

$l_ids = $cvview[0]['languages'];
$languages = UserCvs::model()->getLanguages($l_ids);

$r_id = $cvview[0]['city_id'];
$region = UserCvs::model()->getRegion($r_id);

?>

<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
                            <?$this->renderPartial('../profile/profile/_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('../profile/profile/_menu',array('current'=>'0','id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" class="userWall">
		<tr>
			<td class="left">
				<div id="postsContainer">
					<div class="c_container">
						<div class="c_container_left">Резюме</div>
						<div class="c_container_right">
							<a href="/id<?php echo Yii::app()->user->id; ?>/cv" class="cv_links">Вернуться к списку резюме</a>
						</div>
					</div>
					<br>

					<div class="avatar">
				        <img width="80" src="<?= Yii::app()->request->baseUrl ?><?= $profile->getAvatar('80x80') ?>" alt="">
				        <?if($profile->user_id == Yii::app()->user->id):?>
				        <div class="change_avatar" id="avatar">
				            <a href="<?=$this->createUrl('profile/profile/editAvatar',array('id'=>Yii::app()->user->id))?>" facecom="crop" wtitle="Выберите фото для профиля" wbutton="Установить как фото профиля" aspect="1" preview="192">сменить аватар</a>
				        </div>
				        <?endif;?>
				    </div>

				    <div class="name"> <? echo $cvview[0]['first_name'] . ' ' . $cvview[0]['second_name'];?> </div>
				    <div>Семейное положение: <? echo $status[$s_id] ?></div>
				    <div>Языки: <? echo $languages ?></div>
				    <div>Место проживания: <? echo $region ?></div>
				    <div>Телефон: <? echo $cvview[0]['phone'] ?></div>



					<?php
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					echo $cvview[0][''];
					
					echo $cvview[0]['desire_position'];
					
					echo CHtml::submitButton(Yii::t('site', 'Сохранить'), array('class' => 'blue'));
					
					?>


					<input type="text" value="<?php echo $cvview[0]['salary']; ?>" disabled></input>


				</div>
			</td>
			<? $this->renderPartial('../profile/profile/_rightPanel', array('profile'=>$profile)) ?>
		</tr>
	</table>
</div>
<input type="hidden" name="wallOwner" value="<?= $profile->user_id ?>" /> 