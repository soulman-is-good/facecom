<div class="form">
    <div class="field">
        <?php echo $form->labelEx($model, 'address'); ?>
        <?php echo $form->textArea($model, 'address', array('rows' => 2, 'cols' => 80, 'style' => 'width:209px')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone'); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->emailField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>                
    <div class="hr">&nbsp;</div>
    <div class="field buttons">
        <?php echo CHtml::submitButton(Yii::t('site', 'Сохранить'), array('class' => 'blue')); ?>
    </div>        
</div>