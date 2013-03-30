<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
    $months = array_merge(array(0=>'Месяц:'),Yii::app()->getLocale()->getMonthNames());
    $days = range(0,31);
    $days = array_combine($days, $days);
    $days[0] = 'День:';
    //generate years array
    $till = (int)date('Y')-14; //allowed age?
    $from = $till-80;
    $years = array_reverse(range($from, $till));
    $years = array_merge(array(0=>'Год:'),array_combine($years, $years));
    $uerr = $user->getErrors();
    $perr = $profile->getErrors();
?>

            <?= $this->renderPartial('//layouts/pieces/header_login',array('model'=>$model)) ?>
            <div class="loginContainer">
                <div class="message">
                    Facecom помогает вам быстро развить ваш бизнес, при этом всегда оставаясь на связи со своими друзьями.
                </div>
                <div class="main">
                    <h1>Регистрация</h1>
                    <h2>Это бесплатно и всегда будет бесплатно</h2>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'register-form',
                            'enableClientValidation'=>true,
                            'clientOptions'=>array(
                                    'validateOnSubmit'=>false,
                            ),
                    )); ?>
                    <div class="field">
                        <div style="position: relative;display: inline-block" class="<?=isset($perr['first_name'])?' error':''?>">
                            <?=$form->textField($profile,'first_name',array('placeholder'=>'Имя','class'=>'half'))?> 
                            <div class="error-msg"><?=$form->error($profile,'first_name')?></div>
                        </div>
                        <div style="position: relative;display: inline-block;" class="<?=isset($perr['second_name'])?' error':''?>">
                            <?=$form->textField($profile,'second_name',array('placeholder'=>'Фамилия','class'=>'half','style'=>'margin-left:13px'))?>
                            <div class="error-msg" style="left:13px;"><?=$form->error($profile,'second_name')?></div>
                        </div>
                    </div>
                    <div class="field<?=isset($perr['first_name'])?' error':''?>">
                        <?=$form->textField($user,'email',array('placeholder'=>'Электронная почта'))?>
                        <div class="error-msg"><?=$form->error($profile,'email')?></div>
                    </div>
                    <div class="field">
                        <?=$form->passwordField($user,'password',array('placeholder'=>'Пароль'))?>
                    </div>
                    <div class="field">
                        <?=CHtml::passwordField('password_repeat', isset($_POST['password_repeat'])?$_POST['password_repeat']:'', array('placeholder'=>'Повторите пароль'))?>
                    </div>
                    <div class="h2" style="margin-bottom:20px;">День рождения</div>
                    <div class="field">
                        <?=$form->dropDownList($profile, 'birth_date[]', $days,array('fcselect'=>"width:'78px'"))?>
                        <?=$form->dropDownList($profile, 'birth_date[]', $months,array('fcselect'=>"width:'90px'"))?>
                        <?=$form->dropDownList($profile, 'birth_date[]', $years,array('fcselect'=>"width:'78px'"))?>
                        <a class="why" href="/whatthe!">Для чего необходимо указывать дату рождения?</a>
                    </div>
                    <div class="field">
                        <?=$form->radioButtonList($profile,'gender',$profile->getGenderInfo(2),array('separator'=>' '))?>
                    </div>
                    <div class="reg-info">
                        Нажимая кнопку "Регистрация", вы соглашаетесь с нашими <a href="/">Условиями использования</a>
                        и подтверждаете, что ознакомились с нашей <a href="/">Политикой использования данных</a>,
                        включая <a href="/">Использование файлов cookie</a>.
                    </div>
                    <div class="field">
                        <button class="blue bitbtn">Регистрация</button>
                    </div>
                    <?php $this->endWidget();?>
                </div>
                <div class="clear">&nbsp;</div>
            </div>