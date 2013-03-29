<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'salt'); ?>
		<?php echo $form->textField($model,'salt',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'salt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

<?if(!$model->isNewRecord):?>
	<div class="row">
		<?php echo $form->labelEx($model,'activation_key'); ?>
		<?php echo $form->textField($model,'activation_key',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'activation_key'); ?>
	</div>
<?endif;?>

	<div class="row status" states="Не активирован|Активирован|Удален">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
        
        <div class="row" style="background: #7b7b7b;margin:40px 0px">&nbsp;</div>
	<div class="row">
		<?php echo $form->labelEx($profile,'first_name'); ?>
		<?php echo $form->textField($profile,'first_name'); ?>
		<?php echo $form->error($profile,'first_name'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($profile,'second_name'); ?>
		<?php echo $form->textField($profile,'second_name'); ?>
		<?php echo $form->error($profile,'second_name'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($profile,'third_name'); ?>
		<?php echo $form->textField($profile,'third_name'); ?>
		<?php echo $form->error($profile,'third_name'); ?>
	</div>
        

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->