<?php
$this->renderPartial('_info',array('profile'=>$profile));
$myProfile = $profile->user_id==Yii::app()->user->id;
?>
<div class="content">
	<table cellpadding="0" cellspacing="0" width="100%" class="avatarAndMenu">
		<tr>
			<td width="200">
				<?$this->renderPartial('_avatar',array('profile'=>$profile));?>
			</td>
			<td align="center">
				<div>
					<?$this->renderPartial('_menu',array('current'=>'1','id'=>$profile->user_id));?>
				</div>
			</td>
		</tr>
	</table>
    
    <div style="clear: both"></div>
    <table cellspacing="0" cellpadding="0" class="userWall">
        <tr>
            <td class="left">
                <table cellpadding="0" cellspacing="0" width="100%" border="0" id="personalInfo">
                    <tr>
                        <th class="th1">
                            <?=Yii::t('site','О себе');?>
                        </th>
                        <th></th>
                        <td class="td3">
                            <?if($myProfile):?>
                            <a href="<?=$this->createUrl('/profile/profile/edit',array('id'=>Yii::app()->user->id,'#'=>'osnovnaya-informaciya'))?>" class="blue"><?=Yii::t('site','Редактировать');?></a>
                            <?endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('site','Семейное положение');?>:</td>
                        <td><?=$profile->getFamilyState();?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="last"><?=Yii::t('site','Языки');?>:</td>
                        <td class="last"><?=$profile->getSpokenLanguages()?></td>
                        <td class="last"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" width="100%" border="0" id="personalInfo">
                    <tr>
                        <th class="th1">
                            <?=Yii::t('site','Контактная информация');?>
                        </th>
                        <th></th>
                        <td class="td3">
                            <?if($myProfile):?>
                            <a href="<?=$this->createUrl('/profile/profile/edit',array('id'=>Yii::app()->user->id,'#'=>'kontakty'))?>" class="blue"><?=Yii::t('site','Редактировать');?></a>
                            <?endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('site','Место проживание');?>:</td>
                        <td>
                            <a href="#" class="blue">
                                <?=$profile->getRegion();?>
                            </a>
                        </td>
                        <td></td>
                    </tr>
                    <?if(!empty($profile->phone)):?>
                    <tr>
                        <td><?=Yii::t('site','Телефон');?>:</td>
                        <td><?=$profile->phone?></td>
                        <td></td>
                    </tr>
                    <?endif;?>
                    <?if(!empty($profile->email)):?>
                    <tr>
                        <td class="last">E-mail:</td>
                        <td class="last"><?=$profile->email?></td>
                        <td class="last"></td>
                    </tr>
                    <?endif;?>
                </table>
<table cellpadding="0" cellspacing="0" width="100%" border="0" id="personalInfo">
                    <tr>
                        <th class="th1">
                            <?=Yii::t('site','Личная информация');?>
                        </th>
                        <th></th>
                        <td class="td3">
                            <?if($myProfile):?>
                            <a href="<?=$this->createUrl('/profile/profile/edit',array('id'=>Yii::app()->user->id,'#'=>'lichnaya-informaciya'))?>" class="blue"><?=Yii::t('site','Редактировать');?></a>
                            <?endif;?>
                        </td>
                    </tr>
                    <?if(!empty($profile->activities)):?>
                    <tr>
                        <td><?=Yii::t('site','Деятельность');?>:</td>
                        <td class="with_comma">
                            <?$profile->renderActivities();?>
                        </td>
                        <td></td>
                    </tr>
                    <?endif;?>
                    <?if(!empty($profile->interests)):?>
                    <tr>
                        <td><?=Yii::t('site','Интересы');?>:</td>
                        <td class="with_comma">
                            <?$profile->renderInterests()?>
                        </td>
                        <td></td>
                    </tr>
                    <?endif;?>
                    <?if(!empty($profile->music)):?>
                    <tr>
                        <td><?=Yii::t('site','Любимая музыка');?>:</td>
                        <td class="with_comma">
                            <?$profile->renderMusic()?>
                        </td>
                        <td></td>
                    </tr>
                    <?endif;?>
                    <?if(!empty($profile->quotes)):?>
                    <tr>
                        <td><?=Yii::t('site','Любимые цитаты');?>:</td>
                        <td>
                            <?=$profile->quotes?>
                        </td>
                        <td></td>
                    </tr>
                    <?endif;?>
                    <?if(!empty($profile->about)):?>
                    <tr>
                        <td class="last"><?=Yii::t('site','О себе');?>:</td>
                        <td class="last"><?=nl2br($profile->about)?></td>
                        <td class="last"></td>
                    </tr>
                    <?endif;?>
                </table>                
                <?if($profile->universities != null && count($profile->universities)>0):?>
                <table cellpadding="0" cellspacing="0" width="100%" border="0" id="personalInfo">
                    <tr>
                        <th class="th1">
                            <?=Yii::t('site','Образование');?>
                        </th>
                        <th></th>
                        <td class="td3">
                            <?if($myProfile):?>
                            <a href="<?=$this->createUrl('/profile/profile/edit',array('id'=>Yii::app()->user->id,'#'=>'obrazovaniye'))?>" class="blue"><?=Yii::t('site','Редактировать');?></a>
                            <?endif;?>
                        </td>
                    </tr>
                    <?foreach ($profile->universities as $univer):?>
                    <tr>
                        <td><?=Yii::t('site','ВУЗ');?>:</td>
                        <td>
                            <a href="#" class="blue">
                                <?=$univer->title?>
                            </a>&nbsp;
                            <span><?=$univer->year_from?></span> - <span><?=$univer->year_till>date('Y')?'настоящее время':$univer->year_till?></span>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('site','Факультет');?>:</td>
                        <td><?=$univer->faculty?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('site','Форма обучения');?>:</td>
                        <td><?=$univer->getStudyForm()?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('site','Статус');?>:</td>
                        <td><?=$univer->getState()?></td>
                        <td></td>
                    </tr>
                    <?endforeach;?>
                    <?if(count($profile->schools)>0):?>
                    <?foreach($profile->schools as $school):?>
                    <tr>
                        <td class="last"><?=Yii::t('site','Школа');?>:</td>
                        <td class="last"><?=$school->title?> <span><?=$school->year_from?></span> - <span><?=$school->year_till>date('Y')?'настоящее время':$school->year_till?></span></td>
                        <td class="last"></td>
                    </tr>
                    <?endforeach;?>
                    <?endif;?>
                </table>
                <?endif;?>
                <?if(!empty($profile->works) && ($wc=count($profile->works))>0):?>
                <table cellpadding="0" cellspacing="0" width="100%" border="0" id="personalInfo">
                    <tr>
                        <th class="th1">
                            <?=Yii::t('site','Карьера');?>
                        </th>
                        <th></th>
                        <td class="td3">
                            <?if($myProfile):?>
                            <a href="<?=$this->createUrl('/profile/profile/edit',array('id'=>Yii::app()->user->id,'#'=>'kariera'))?>" class="blue"><?=Yii::t('site','Редактировать');?></a>
                            <?endif;?>
                        </td>
                    </tr>
                    <?$i=0;foreach($profile->works as $work):$last = $i==$wc-1;?>
                    <tr>
                        <td<?if($last) echo ' class="last"';?>><?=Yii::t('site','Место работы');?>:</td>
                        <td<?if($last) echo ' class="last"';?>>
                            <a href="#" class="blue"><?=$work->work?></a> <?=$work->city->name?>, <?=$work->year_from?>-<?=$work->year_till>date('Y')?'настоящее время':$work->year_till?> <a href="#" class="blue"><?=$work->state?></a>
                        </td>
                        <td<?if($last) echo ' class="last"';?>></td>
                    </tr>
                    <?$i++;endforeach;unset($i);?>
                </table>
                <?endif;?>
                <table cellpadding="0" cellspacing="0" width="100%" border="0" id="personalInfo">
                    <tr>
                        <th class="th1">
                            <?=Yii::t('site','Места');?>
                        </th>
                        <th></th>
                        <td class="td3">
                            <?if($myProfile):?>
                            <a id="marks" href="#edit<?//$this->createUrl('/profile/profile/placemarks',array('id'=>Yii::app()->user->id))?>" class="blue"><?=Yii::t('site','Редактировать');?></a>
                            <a id="save_marks" style="display:none" href="#save<?//$this->createUrl('/profile/profile/placemarks',array('id'=>Yii::app()->user->id))?>" class="button blue"><?=Yii::t('site','Сохранить');?></a>
                            <?endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div id="placemarks"></div>
                        </td>
                    </tr>
                </table>
            </td>
            <?$this->renderPartial('_rightPanel',array('profile'=>$profile));?>
        </tr>
    </table>
</div>