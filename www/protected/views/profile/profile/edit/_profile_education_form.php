<ul style="margin-top:20px">
    <li><a class="edulink" href="#Shkoli"><?= Yii::t('site', 'Начальное образование'); ?></a></li>
    <li><a class="edulink" href="#VUZi"><?= Yii::t('site', 'Высшее образование'); ?></a></li>
</ul>
<div facecom="keepvisible" class="clear">&nbsp;</div>
<div id="VUZi">
    <? $i = 0;
    foreach ($universities as $univer): ?>
        <div class="form education univer">
            <div class="field">
                <?php echo CHtml::activeLabelEx($univer, 'title'); ?>
                <?php echo CHtml::hiddenField("UserUniversity[$i][id]", $univer->id) ?>
                <?php echo CHtml::activeTextField($univer, 'title', array('name' => "UserUniversity[$i][title]")) ?><br/>
                <?php echo $form->error($univer, 'title'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($univer, 'faculty'); ?>
                <?php echo CHtml::activeTextField($univer, 'faculty', array('name' => "UserUniversity[$i][faculty]")) ?>
    <?php echo $form->error($univer, 'faculty'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($univer, 'year_from'); ?>
                <?php echo CHtml::dropDownList("UserUniversity[$i][year_from]", $univer->year_from, $years,array('fcselect'=>true)) ?>
    <?php echo $form->error($univer, 'year_from'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($univer, 'year_till'); ?>
                <?php echo CHtml::dropDownList("UserUniversity[$i][year_till]", $univer->year_till,$years,array('fcselect'=>true)) ?>
    <?php echo $form->error($univer, 'year_till'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($univer, 'form'); ?>
                <?php echo CHtml::activeDropDownList($univer, 'form', $univer->getStudyForm(true), array('name' => "UserUniversity[$i][form]",'fcselect'=>true)) ?>
    <?php echo $form->error($univer, 'form'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($univer, 'state'); ?>
                <?php echo CHtml::activeDropDownList($univer, 'state', $univer->getState(true), array('name' => "UserUniversity[$i][state]",'fcselect'=>true)) ?>
    <?php echo $form->error($univer, 'state'); ?>
            </div>
<?if(!$univer->isNewRecord):?>
            <div class="field delete">
                <?php echo CHtml::label('Удалить',"UserUniversity_{$i}_delete") ?>
                <?php echo CHtml::checkBox("UserUniversity[$i][delete]", false,array('id'=>"UserUniversity_{$i}_delete",'style'=>'margin-top:7px')) ?>
            </div>
<?endif;?>
        </div>
        <div class="hr">&nbsp;</div>
        <?
        $i++;
    endforeach;
    $univer = new UserUniversity();
    ?>
    <div class="form education univer newuniver" id="new_univer">
        <div class="field">
            <?php echo CHtml::activeLabelEx($univer, 'title'); ?>
            <?php echo CHtml::activeTextField($univer, 'title', array('name' => "UserUniversity[$i][title]")) ?>
<?php echo $form->error($univer, 'title'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($univer, 'faculty'); ?>
            <?php echo CHtml::activeTextField($univer, 'faculty', array('name' => "UserUniversity[$i][faculty]")) ?>
<?php echo $form->error($univer, 'faculty'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($univer, 'year_from'); ?>
            <?php echo CHtml::dropDownList("UserUniversity[$i][year_from]", (($y=date('Y',$model->birth_date)+18)<date('Y')?$y:date('Y')),$years,array('fcselect'=>true)) ?>
<?php echo $form->error($univer, 'year_from'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($univer, 'year_till'); ?>
            <?php echo CHtml::dropDownList("UserUniversity[$i][year_till]", (($y=date('Y',$model->birth_date)+23)<date('Y')?$y:date('Y')),$years,array('fcselect'=>true)) ?>
<?php echo $form->error($univer, 'year_till'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($univer, 'form'); ?>
            <?php echo CHtml::activeDropDownList($univer, 'form', $univer->getStudyForm(true), array('name' => "UserUniversity[$i][form]",'fcselect'=>true)) ?>
<?php echo $form->error($univer, 'form'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($univer, 'state'); ?>
            <?php echo CHtml::activeDropDownList($univer, 'state', $univer->getState(true), array('name' => "UserUniversity[$i][state]",'fcselect'=>true)) ?>
<?php echo $form->error($univer, 'state'); ?>
        </div>
    </div>
    <div class="form adduniver" style="display:none;padding-bottom:0px">
        <div facecom="keepvisible" class="hr">&nbsp;</div>
        <div class="field buttons">
            <a href="#add-univer" id="add-univer">Добавить университет</a>
        </div>                
    </div>
</div>
<div id="Shkoli">
<? $i = 0;
foreach ($schools as $school): ?>
        <div class="form education school">
            <div class="field">
                <?php echo CHtml::activeLabelEx($school, 'title'); ?>
                <?php echo CHtml::hiddenField("UserSchool[$i][id]", $school->id) ?>
    <?php echo CHtml::activeTextField($school, 'title', array('name' => "UserSchool[$i][title]")) ?>
                <?php echo $form->error($school, 'title'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($school, 'year_from'); ?>
    <?php echo CHtml::dropDownList("UserSchool[$i][year_from]", $school->year_from,$years,array('fcselect'=>true)) ?>
                <?php echo $form->error($school, 'year_from'); ?>
            </div>
            <div class="field">
                <?php echo CHtml::activeLabelEx($school, 'year_till'); ?>
    <?php echo CHtml::dropDownList("UserSchool[$i][year_till]", $school->year_till,$years,array('fcselect'=>true)) ?>
        <?php echo $form->error($school, 'year_till'); ?>
            </div>
<?if(!$school->isNewRecord):?>            
            <div class="field delete">
                <?php echo CHtml::label('Удалить',"UserSchool_{$i}_delete") ?>
                <?php echo CHtml::checkBox("UserSchool[$i][delete]", false,array('id'=>"UserSchool_{$i}_delete",'style'=>'margin-top:7px')) ?>
            </div>            
<?endif;?>
        </div>
        <div class="hr">&nbsp;</div>
        <?
        $i++;
    endforeach;
    $school = new UserSchool();
    ?>
    <div class="form education school newschool" id="new_school">
        <div class="field">
            <?php echo CHtml::activeLabelEx($school, 'title'); ?>
<?php echo CHtml::activeTextField($school, 'title', array('name' => "UserSchool[$i][title]")) ?>
            <?php echo $form->error($school, 'title'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($school, 'year_from'); ?>
<?php echo CHtml::dropDownList("UserSchool[$i][year_from]", (($y=date('Y',$model->birth_date)+7)<date('Y')?$y:date('Y')),$years,array('fcselect'=>true)) ?>
            <?php echo $form->error($school, 'year_from'); ?>
        </div>
        <div class="field">
            <?php echo CHtml::activeLabelEx($school, 'year_till'); ?>
<?php echo CHtml::dropDownList("UserSchool[$i][year_till]", (($y=date('Y',$model->birth_date)+18)<date('Y')?$y:date('Y')),$years,array('fcselect'=>true)) ?>
<?php echo $form->error($school, 'year_till'); ?>
        </div>
    </div>
    <div class="form addschool" style="display:none;padding-bottom:0px">
        <div facecom="keepvisible" class="hr">&nbsp;</div>
        <div class="field buttons">
            <a href="#add-school" id="add-school">Добавить школу</a>
        </div>                
    </div>
</div>
<div class="form" facecom="keepvisible">
    <div class="field buttons">
<?php echo CHtml::submitButton(Yii::t('site', 'Сохранить'), array('class' => 'blue ajax')); ?>
    </div>
</div>