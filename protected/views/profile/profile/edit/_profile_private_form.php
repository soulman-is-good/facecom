<div class="form">
    <div class="field">
        <?php echo $form->labelEx($model, 'activities'); ?>
        <?php echo $form->textArea($model, 'activities', array('rows' => 2, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'activities'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'interests'); ?>
        <?php echo $form->textArea($model, 'interests', array('rows' => 2, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'interests'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'music'); ?>
        <?php echo $form->textArea($model, 'music', array('rows' => 2, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'music'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'quotes'); ?>
        <?php echo $form->textArea($model, 'quotes', array('rows' => 2, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'quotes'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'about'); ?>
        <?php echo $form->textArea($model, 'about', array('rows' => 3, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'about'); ?>
    </div>
    <div class="hr">&nbsp;</div>
    <div class="field buttons">
        <?php echo CHtml::submitButton(Yii::t('site', 'Сохранить'), array('class' => 'blue')); ?>
    </div>        
</div>