<?php
/* @var $this DiscountController */
/* @var $model Discount */
/* @var $form CActiveForm */
//$form = new CActiveForm();

$cats = CHtml::listData(Category::model()->findAll(), 'id', 'title');
$offices = CHtml::listData(Office::model()->findAll(), 'id', 'name');
$regions = $model->assocRegion();
$categories = $model->assocCategories();
$cats = array_keys($categories);
$range = array_keys($regions);
if($model->starts_at>0)
    $model->starts_at = date('d.m.Y H:i',$model->starts_at);
if($model->ends_at>0)
    $model->ends_at = date('d.m.Y H:i',$model->ends_at);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discount-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
            <label for="cats"><?=Yii::t('site','Категории');?></label>
            <input type="hidden" data-dtitle='Выберите категории' value="<?=implode(',',$cats);?>" name="Cats" id="cats" class="popup-select" data-load="/category/fetch" />
        </div>
	<div class="field">
            <label for="region"><?=Yii::t('site','Регион');?></label>
            <input type="hidden" data-dtitle='Выберите города' value="<?=implode(',',$range);?>" name="Region" id="region" class="popup-select" data-load="/my/citiesassoc" />
        </div>
	<div class="field">
		<?php echo $form->labelEx($model,'office_id'); ?>
                <?if(!$model->isNewRecord):?>
                    <?php echo $form->hiddenField($model,'id'); ?>
                <?endif;?>
		<?php echo $form->textField($model,'office_id',array('size'=>10,'maxlength'=>10,'fcselect'=>'width:"425px",data:"/office/names",value:"'.($model->office_id>0?addslashes(Office::model()->findByPk($model->office_id)->name):'').'"')); ?>
		<?php echo $form->error($model,'office_id'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'rules'); ?>
		<?php echo $form->textArea($model,'rules',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'rules'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'starts_at'); ?>
		<?php echo $form->textField($model,'starts_at',array('size'=>50,'maxlength'=>10,'class'=>'datetime')); ?>
		<?php echo $form->error($model,'starts_at'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'ends_at'); ?>
		<?php echo $form->textField($model,'ends_at',array('size'=>50,'maxlength'=>10,'class'=>'datetime')); ?>
		<?php echo $form->error($model,'ends_at'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'images'); ?>
		<?php echo $form->hiddenField($model,'images',array('size'=>60,'maxlength'=>1024)); ?>
                <div class="images">
                    <em class="gray">не прикреплено ни одного изображения</em>
                </div>
		<?php echo $form->error($model,'images'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
        
        <div class="hr" style="margin:15px;">&nbsp;</div>
        <h4>Купоны</h4>
        <a class="button" href="#" onclick="createCoupon(0,this);return false;">Добавить скидку</a> <em>::</em> <a href="#" onclick="createCoupon(1,this);return false;" class="button">Добавить сертификат</a>
        <?=$this->renderPartial('_form_coupon',array('models'=>$coupons))?>
	<div class="field buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать предложение' : 'Сохранить предложение'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $('#region').data('assoc',<?=json_encode($regions)?>);
    $('#cats').data('assoc',<?=json_encode($categories)?>);
</script>