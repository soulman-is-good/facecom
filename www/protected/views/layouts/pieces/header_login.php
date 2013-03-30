<div class="headerLogin">
	<div class="header-login">
		<a class="logo" href="<?=(Yii::app()->user->isGuest?'/':$this->createUrl('profile/profile',array('id'=>Yii::app()->user->id)))?>">
			<img src="/static/css/logo.png" alt="logo" />
		</a>
		<div class="login-form">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'login-form',
                            'enableClientValidation' => true,
                            'enableClientValidation'=>true,
                    )); ?>
                    <div class="login-block">
                        <div class="login-labels"><label><?=$form->labelEx($model,'login')?></label></div>
                        <div class="login-input"><?=$form->textField($model,'login',array('tabindex'=>"1"))?></div>
                        <div class="login-opts"><?=$form->checkBox($model,'rememberMe',array('style'=>'position:relative;top:2px;','tabindex'=>'-1'));?><?=$form->labelEx($model,'rememberMe')?></div>
                    </div>
                    <div class="login-block">
                        <div class="login-labels"><label><?=$form->labelEx($model,'password')?></label></div>
                        <div class="login-input"><?=$form->passwordField($model,'password',array('tabindex'=>"2"));?></div>
                        <div class="login-opts"><a tabindex="4" href="<?=$this->createUrl('my/restore')?>">Забыли пароль</a></div>
                    </div>
                    <div class="login-block">
                        <div class="login-labels">&nbsp;</div>
                        <div class="login-input"><?=CHtml::submitButton('Войти',array('class'=>'blue',"tabindex"=>"3"))?></div>
                        <div class="login-opts"></div>
                    </div>
		    <?php $this->endWidget()?>
		</div>
                <div class="clear">&nbsp;</div>
	</div>
</div>
<script>
    $(function(){
        $('#LoginForm_login').focus()
    })
</script>