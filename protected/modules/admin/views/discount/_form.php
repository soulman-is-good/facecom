<?php
/* @var $this DiscountController */
/* @var $model Discount */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discount-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'office_id'); ?>
		<?php echo $form->textField($model,'office_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'office_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textField($model,'text',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rules'); ?>
		<?php echo $form->textArea($model,'rules',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'rules'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'starts_at'); ?>
		<?php echo $form->textField($model,'starts_at',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'starts_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ends_at'); ?>
		<?php echo $form->textField($model,'ends_at',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'ends_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'images'); ?>
		<?php echo $form->textField($model,'images',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'images'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->