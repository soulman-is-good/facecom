<div class="content office-edit">
    <h1><a href="<?=$this->createUrl('office/items/index',array('oid'=>$_GET['oid']))?>">Товары</a> &gt; <?=Yii::t('site','Создание товара');?></h1>
<div class="form">
    <?if(Yii::app()->user->getFlash('ItemSaved')>0):?>
    <div class="success">
        Сохранено!
    </div>
    <?endif;?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'office-form',
        'htmlOptions'=>array(
            'enctype'=>'multipart/form-data',
        ),
	'enableAjaxValidation'=>false,
)); 
$icats = array();
if(!$model->isNewRecord) {
    $dbs = ItemsCategory::model()->findAllByAttributes(array('item_id'=>$model->id));
    $icats = array_map(create_function('$item', 'return $item->category_id;'),$dbs);
}
$cats = Category::model()->findAll();
?>
	<?php echo $form->errorSummary($model); ?>
        <?=$model->isNewRecord ?'':$form->hiddenField($model,'id')?>
        <div class="field">
                <?php echo $form->labelEx($model,'image'); ?>
                <?php echo $form->fileField($model,'image',array('size'=>120,'maxlength'=>255)); ?>
                <?=CHtml::hiddenField('Items[image_src]',$model->image)?>
            <?if(null!=Files::model()->findByPk($model->image)):?><br/><label></label>
                <?=CHtml::link(CHtml::image('/images/80x80/'.$model->image),'/images/full/'.$model->image)?>
            <?endif;?>
                <?php echo $form->error($model,'image'); ?>
        </div>
    
        <div class="field">
            <?php echo CHtml::label('Категории','categories') ?>
            <div id="cats" fcselect="width:'423px'">
                <?foreach($cats as $cat):?>
                <label for="cat_<?=$cat->id?>"><?=$cat->title?></label><input type="checkbox" value="<?=$cat->id?>" name="categories[]" id="cat_<?=$cat->id?>" <?=in_array($cat->id,$icats)?'checked="checked"':''?> />
                <?endforeach;?>
            </div>
        </div>
    
	<div class="field">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255,'title'=>strip_tags($form->error($model,'title')))); ?>
	</div>
    
	<div class="field">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>255,'title'=>strip_tags($form->error($model,'price')))); ?>
	</div>
    
	<div class="field">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
    
        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        </div>

<?php $this->endWidget();?>
</div>
</div>