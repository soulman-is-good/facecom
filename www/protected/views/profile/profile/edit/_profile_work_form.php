<? $i = 0;
    $country_id = 0;
    if(is_null($model->city)){
        $country_id = 1894;
        $city = City::model()->find('city_id=1913')->name;
    }else{
        $country_id = $model->city->country_id;
        $city = $model->city->name;
    }
foreach ($works as $work): ?>
        <div class="form education work">
            <div class="field">
                <?php echo CHtml::label('Страна', 'country_id'); ?>
                <?php echo CHtml::dropDownList('country_id', ($work->city_id>0?$work->city->country_id:$country_id),$countries,array('class'=>'country_id','for'=>"[name='UserWork[$i][city]']",'fcselect'=>true)); ?>
            </div>    
            <div class="field">
                <?php echo $form->labelEx($work, 'city_id'); ?>
                <?php echo CHtml::textField("UserWork[$i][city]", ($work->city_id>0?$work->city->name:$city),array('class'=>'city_id','size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($work, 'city_id'); ?>
            </div>            
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'work'); ?>
                <?php echo CHtml::hiddenField("UserWork[$i][id]", $work->id) ?>
            <?php echo CHtml::activeTextField($work, 'work', array('name' => "UserWork[$i][work]")) ?>
                <?php echo $form->error($work, 'work'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'state'); ?>
                <?php echo CHtml::activeTextField($work, 'state', array('name' => "UserWork[$i][state]")) ?>
                <?php echo $form->error($work, 'state'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'year_from'); ?>
    <?php echo CHtml::dropDownList("UserWork[$i][year_from]", $work->year_from,$years,array('fcselect'=>true)) ?>
                <?php echo $form->error($work, 'year_from'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'year_till'); ?>
    <?php echo CHtml::dropDownList("UserWork[$i][year_till]", $work->year_till,$years,array('fcselect'=>true)) ?>
        <?php echo $form->error($work, 'year_till'); ?>
            </div>
<?if(!$work->isNewRecord):?>
            <div class="field delete">
                <?php echo CHtml::label('Удалить',"UserWork_{$i}_delete") ?>
                <?php echo CHtml::checkBox("UserWork[$i][delete]", false,array('id'=>"UserWork_{$i}_delete",'style'=>'margin-top:7px')) ?>
            </div>            
<?endif;?>
        </div>
        <div class="hr">&nbsp;</div>
        <?
        $i++;
    endforeach;
    $work = new UserWork();
    ?>
    <div class="form education work newwork" id="new_work">
            <div class="field isnewwork">
                <?php echo CHtml::label('Страна', 'country_id'); ?>
                <?php echo CHtml::dropDownList('country_id', $country_id,$countries,array('class'=>'country_id','for'=>"[name='UserWork[$i][city]']",'fcselect'=>true)); ?>
            </div>    
            <div class="field">
                <?php echo $form->labelEx($work, 'city_id'); ?>
                <?php echo CHtml::textField("UserWork[$i][city]", $city,array('class'=>'city_id','size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($work, 'city_id'); ?>
            </div>            
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'work'); ?>
                <?php echo CHtml::hiddenField("UserWork[$i][id]", $work->id) ?>
            <?php echo CHtml::activeTextField($work, 'work', array('name' => "UserWork[$i][work]")) ?>
                <?php echo $form->error($work, 'work'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'state'); ?>
                <?php echo CHtml::activeTextField($work, 'state', array('name' => "UserWork[$i][state]")) ?>
                <?php echo $form->error($work, 'state'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'year_from'); ?>
    <?php echo CHtml::dropDownList("UserWork[$i][year_from]", (($y=date('Y',$model->birth_date)+23)<date('Y')?$y:date('Y')),$years,array('fcselect'=>true)) ?>
                <?php echo $form->error($work, 'year_from'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($work, 'year_till'); ?>
    <?php echo CHtml::dropDownList("UserWork[$i][year_till]", date('Y'),$years,array('fcselect'=>true)) ?>
        <?php echo $form->error($work, 'year_till'); ?>
            </div>
</div>
    <div class="form addwork" style="display:none;padding-bottom:0px">
        <div facecom="keepvisible" class="hr">&nbsp;</div>
        <div class="field buttons">
            <a href="#add-work" id="add-work">Добавить место работы</a>
        </div>                
    </div>
<div class="form" facecom="keepvisible">
    <div class="field buttons">
<?php echo CHtml::submitButton(Yii::t('site', 'Сохранить'), array('class' => 'blue')); ?>
    </div>
</div>        