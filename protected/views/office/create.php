<?php
/* @var $this OfficeController */
/* @var $model Office */
/* @var $form CActiveForm */
?>
<div class="content office-edit">
    <h1><?=Yii::t('site','Создание нового офиса');?></h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'office-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
        <?=$model->isNewRecord ?'':$form->hiddenField($model,'id')?>

	<div class="field">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'title'=>strip_tags($form->error($model,'name')))); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'about'); ?>
		<?php echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'about'); ?>
	</div>
        <div class="field">
            <?php echo CHtml::label('Страна', 'country_id'); ?>
            <?php echo CHtml::dropDownList('country_id', $country_id,$countries,array('class'=>'country_id','for'=>'#city_id','fcselect'=>"width:'423px'")); ?>
        </div> 
        <div class="field">
            <?php echo $form->labelEx($model, 'city_id'); ?>
            <?php echo CHtml::textField('city', $city,array('id'=>'city_id','size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'city_id'); ?>
        </div>  

	<div class="field">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>