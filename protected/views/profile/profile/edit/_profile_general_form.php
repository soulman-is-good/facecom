<?php
    $states = UserProfile::model()->getFamilyState(true);
    if(!is_array($model->languages)){
        if(empty($model->languages))
            $model->languages = array();
        else{
            $model->languages = explode(',',$model->languages);
            if(count($model->languages)==1 && $model->languages[0] == '')
                $model->languages = array();
            if(!empty($model->languages)){
                $langs = $model->languages;
                foreach($langs as $i=>$lang){$langs[$i] = trim($lang);}
                $model->languages = $langs;
            }

        }

    }
    $country_id = 0;
    if(is_null($model->city)){
        $country_id = 1894;
        $city = City::model()->find('city_id=1913')->name;
    }else{
        $country_id = $model->city->country_id;
        $city = $model->city->name;
    }
    $months = Yii::app()->getLocale()->getMonthNames();
    $days = range(1,31);
    $days = array_combine($days, $days);
?>
<div class="form">
    <div class="field">
        <?php echo CHtml::label('Страна', 'country_id'); ?>
        <?php echo CHtml::dropDownList('country_id', $country_id,$countries,array('class'=>'country_id','for'=>'#city_id','fcselect'=>true)); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'city_id'); ?>
        <?php echo CHtml::textField('city', $city,array('id'=>'city_id','size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'city_id'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'second_name'); ?>
        <?php echo $form->textField($model, 'second_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'second_name'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'third_name'); ?>
        <?php echo $form->textField($model, 'third_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'third_name'); ?>
    </div>
    <div class="field date">
        <?php echo $form->label($model, 'birth_date'); ?>
            <?php echo CHtml::dropDownList('birth_day', (int)date('d',$model->birth_date), $days,array('id'=>'birth_day','class'=>'day')); ?>
            <?php echo CHtml::dropDownList('birth_month', (int)date('m',$model->birth_date), $months,array('id'=>'birth_month','class'=>'month')); ?>
            <?php echo CHtml::dropDownList('birth_year', (int)date('Y',$model->birth_date), $years,array('id'=>'birth_year','class'=>'year')); ?>
        <?php echo $form->error($model, 'birth_date'); ?>
    </div>
    <div class="field">
        <?php echo $form->label($model, 'gender'); ?>
        <?php echo $form->dropDownList($model, 'gender', UserProfile::model()->getGenderInfo(2),array('fcselect'=>true)); ?>
        <?php echo $form->error($model, 'gender'); ?>
    </div>
    <div class="field">
        <?php echo $form->label($model, 'family'); ?>
        <?php echo $form->dropDownList($model, 'family', $states[$model->gender],array('fcselect'=>true)); ?>
        <?php echo $form->error($model, 'family'); ?>
    </div>
    <div class="field">
        <?php echo $form->labelEx($model, 'languages'); ?>
        <?php echo $form->checkBoxList($model, 'languages', CHtml::listData(Language::model()->findAll(), 'id', 'title'), array('container' => 'span class="checkBoxList" fcselect')); ?>
        <?php echo $form->error($model, 'languages'); ?>
    </div>
    <div class="hr">&nbsp;</div>
    <div class="field buttons">
        <?php echo CHtml::submitButton(Yii::t('site', 'Сохранить'), array('class' => 'blue')); ?>
    </div>
</div>