<?php
/* @var $this OfficeController */
/* @var $model Office */
/* @var $form CActiveForm */
?>
<div class="content office-edit">
    <h1><?=Yii::t('site','Редактирование данных офиса');?></h1>
    <div style="clear: both"></div>
    <div id="facecom-tabs">
        <ul>
            <li><a class="button" href="#osnovnaya-informaciya"><?=Yii::t('site','Основное');?></a></li>
            <li><a class="button" href="#kontakty" onclick="updateMap();"><?=Yii::t('site','Контакты');?></a></li>
            <li style="padding:0"><div id="map"><img src="/static/css/preload.gif" /></div></li>
        </ul>
        <div facecom="keepvisible" class="clear">&nbsp;</div>

            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'office-form',
                    'htmlOptions'=>array(
                            'enctype'=>'multipart/form-data',
                        ),
                    'enableAjaxValidation'=>false,
            )); ?>
        <div id="osnovnaya-informaciya">
            <div class="form">

                    <?php //echo $form->errorSummary($model); ?>
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
                            <?php echo $form->textField($model,'website',array('size'=>120,'maxlength'=>255)); ?>
                            <?php echo $form->error($model,'website'); ?>
                    </div>

                    <div class="field">
                            <?php echo $form->labelEx($model,'avatar'); ?>
                            <?php echo $form->fileField($model,'avatar',array('size'=>120,'maxlength'=>255)); ?>
                            <?=CHtml::hiddenField('Office[avatar_src]',$model->avatar)?>
                            <?=CHtml::link($model->avatar,'/images/avatar/'.$model->avatar)?>
                            <?php echo $form->error($model,'avatar'); ?>
                    </div>
                
                    <div class="field">
                            <?php echo $form->labelEx($model,'background'); ?>
                            <?php echo $form->fileField($model,'background',array('size'=>120,'maxlength'=>255)); ?>
                            <?=CHtml::hiddenField('Office[background_src]',$model->background)?>
                            <?=CHtml::link($model->background,'/images/cover/'.$model->background)?>
                            <?php echo $form->error($model,'background'); ?>
                    </div>

                    <div class="row buttons">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
                    </div>
            </div><!-- form -->
        </div>
        <div id="kontakty" style="display:none">
            <div class="form">
                <div class="field">
                        <?php echo $form->labelEx($model,'address'); ?>
                        <?php echo $form->textArea($model,'address',array('rows'=>2,'cols'=>50,'maxlength'=>1024)); ?>
                        <?php echo $form->error($model,'address'); ?>
                </div>
                <div class="field">
                        <?php echo $form->labelEx($model,'contacts'); ?>
                        <?php echo $form->textField($model,'contacts',array('size'=>120));?>
                        <?php echo $form->error($model,'contacts'); ?>
                </div>
                <div class="field">
                    <?php echo $form->labelEx($model,'lat'); ?>
                    <?php echo $form->hiddenField($model,'lat'); ?>
                    <?php echo $form->hiddenField($model,'long'); ?>
                    <div id="map_holder"><img src="/static/css/preload.gif" /></div>
                </div>
                <div class="row buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script id="SEL" type="text/html">
    <?=CHtml::dropDownList('sel', null, Office::$contacts)?>
</script>