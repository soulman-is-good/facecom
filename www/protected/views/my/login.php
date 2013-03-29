<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
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
                        <?=$form->textField($profile,'first_name',array('placeholder'=>'Имя','class'=>'half'))?> <?=$form->textField($profile,'second_name',array('placeholder'=>'Фамилия','class'=>'half','style'=>'margin-left:13px'))?>
                    </div>
                    <div class="field">
                        <?=$form->textField($user,'email',array('placeholder'=>'Электронная почта'))?>
                    </div>
                    <div class="field">
                        <?=$form->textField($user,'password',array('placeholder'=>'Пароль'))?>
                    </div>
                    <div class="field">
                        <?=CHtml::textField('password_repeat', isset($_POST['password_repeat'])?$_POST['password_repeat']:'', array('placeholder'=>'Повторите пароль'))?>
                    </div>
                    <div class="h2" style="margin-bottom:20px;">День рождения</div>
                    <div class="field">
                        <?=$form->dropDownList($profile, 'birth_date[]', array('День:','1'=>'1','2'=>'2','3'=>'3','4'=>'4'),array('fcselect'=>"width:'78px'"))?>
                        <?=$form->dropDownList($profile, 'birth_date[]', array('Месяц:','1'=>'Январь','2'=>'Февраль','3'=>'Март','4'=>'Апрель'),array('fcselect'=>"width:'90px'"))?>
                        <?=$form->dropDownList($profile, 'birth_date[]', array('Год:','1997'=>'1997','1996'=>'1996','1995'=>'1995'),array('fcselect'=>"width:'78px'"))?>
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