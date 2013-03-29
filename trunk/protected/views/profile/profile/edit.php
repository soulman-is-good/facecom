<?php
//$this->renderPartial('_info', array('profile' => $model));
?>
<div class="content profile-edit">
    <? //$this->renderPartial('_menu', array('current' => '1', 'id' => $model->user_id)); ?>
    <h1><?=Yii::t('site','Редактирование профиля');?></h1>
    
    <div style="clear: both"></div>
    <?php
    $form = new CActiveForm();
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'userprofile-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
            ), array(
        'enctype' => 'multipart/form-data'
            )
    );
    //generate years array
    $till = (int)date('Y');
    $from = $till-100;
    $years = range($from, $till);
    $years = array_combine($years, $years);
    //prepare cities and countries
    $countries = CHtml::listData(Country::model()->findAll(array('select'=>'country_id, name')), 'country_id', 'name');
    ?>
    <div id="facecom-tabs">
        <ul>
            <li><a class="button" href="#osnovnaya-informaciya"><?=Yii::t('site','Основное');?></a></li>
            <li><a class="button" href="#lichnaya-informaciya"><?=Yii::t('site','Личное');?></a></li>            
            <li><a class="button" href="#kontakty"><?=Yii::t('site','Контакты');?></a></li>
            <li><a class="button" href="#obrazovaniye"><?=Yii::t('site','Образование');?></a></li>
            <li><a class="button" href="#kariera"><?=Yii::t('site','Карьера');?></a></li>
        </ul>
        <div facecom="keepvisible" class="clear">&nbsp;</div>
        <div id="osnovnaya-informaciya">
        <?=$this->renderPartial('//profile/profile/edit/_profile_general_form',array('model'=>$model,'form'=>$form,'years'=>$years,'countries'=>$countries));?>
        </div>            
        <div id="lichnaya-informaciya">
        <?=$this->renderPartial('//profile/profile/edit/_profile_private_form',array('model'=>$model,'form'=>$form));?>
        </div>
        <div id="kontakty">
        <?=$this->renderPartial('//profile/profile/edit/_profile_contacts_form',array('model'=>$model,'form'=>$form));?>
        </div>
        <div id="obrazovaniye">
        <?=$this->renderPartial('//profile/profile/edit/_profile_education_form',array('model'=>$model,'form'=>$form,'schools'=>$schools,'universities'=>$universities,'years'=>$years));?>
        </div>
        <div id="kariera">
        <?=$this->renderPartial('//profile/profile/edit/_profile_work_form',array('model'=>$model,'form'=>$form,'works'=>$works,'years'=>$years,'countries'=>$countries));?>
        </div>
    </div>
    <? $this->endWidget(); ?>    
</div>
