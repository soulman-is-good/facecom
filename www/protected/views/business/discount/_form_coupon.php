<div id="coupons">
<?if(($c = count($models))==0):?>
    <h5>нет купонов</h5>
<?endif;?>
    <script>
        var COUPON_CNT = <?=$c?>;
    </script>
<?php
$form = new CActiveForm();
foreach($models as $i=>$model):
    echo $form->errorSummary($model);
?>
<a href="#edit" class="flag">
    <div class="percent"><?=$model->percent?>%</div>
        <div class="info">
                <div class="vd"><?=$model->price?> VD</div>
                <div class="buy">Купить <?=$model->type==0?"скидку":"сертификат"?></div>
        </div>
    <div class="hidden-form">
        <div class="field">
            <?if(!$model->isNewRecord):?>
            <?php echo $form->hiddenField($model, "[$i]id"); ?>
            <?endif;?>
            <?php echo $form->hiddenField($model, "[$i]type"); ?>
            <?php echo $form->labelEx($model, "[$i]text"); ?>
            <?php echo $form->textArea($model, "[$i]text", array("rows"=>6, "cols"=>50,'class'=>'required')); ?>
            <?php echo $form->error($model, "[$i]text"); ?>
        </div>

        <div class="field">
            <?php echo $form->labelEx($model, "[$i]percent"); ?>
            <?php echo $form->textField($model, "[$i]percent", array("size" => 10, "maxlength" => 10,'class'=>'range(1,100)')); ?>
            <?php echo $form->error($model, "[$i]percent"); ?>
        </div>

        <div class="field">
            <?php echo $form->labelEx($model, "[$i]cost"); ?>
            <?php echo $form->textField($model, "[$i]cost", array("size" => 60, "maxlength" => 64)); ?>
            <?php echo $form->error($model, "[$i]cost"); ?>
        </div>

        <div class="field">
            <?php echo $form->labelEx($model, "[$i]price"); ?>
            <?php echo $form->textField($model, "[$i]price", array("size" => 9, "maxlength" => 9,'class'=>'number')); ?>
            <?php echo $form->error($model, "[$i]price"); ?>
        </div>

        <div class="field">
            <?php echo $form->labelEx($model, "[$i]limit"); ?>
            <?php echo CHtml::checkBox("unlim",true,array("id"=>"limit_trig","onclick"=>'$(this).siblings("input").toggle();',"style"=>"width:auto")) ?>Неограничено
            <?php echo $form->textField($model, "[$i]limit", array("size" => 10, "maxlength" => 10,"style"=>"display:none")); ?>
            <?php echo $form->error($model, "[$i]limit"); ?>
        </div>

        <div class="field">
            <?php echo $form->labelEx($model, "[$i]limit_per_user"); ?>
            <?php echo CHtml::checkBox("Coupon[$i][delete]",false,array("style"=>"visibility:hidden",'id'=>"delete_$i")) ?>
            <?php echo CHtml::checkBox("unlpu",true,array("id"=>"lpu_trig","onclick"=>'$(this).siblings("input").toggle();',"style"=>"width:auto")) ?>Неограничено
            <?php echo $form->textField($model, "[$i]limit_per_user", array("size" => 10, "maxlength" => 10,"style"=>"display:none")); ?>
            <?php echo $form->error($model, "[$i]limit_per_user"); ?>
        </div>
    </div>
</a>
<?endforeach;?>
</div>
<?
    $model = new Coupon();
?>
<script type="text/html" id="a-coupon" data-type="Купить скидку|Купить сертификат">
<a href="#edit" class="flag">
    <div class="percent">{{percent}}%</div>
        <div class="info">
                <div class="vd">{{price}} VD</div>
                <div class="buy">{{type}}</div>
        </div>
    <div class="hidden-form"></div>
</a>
</script>
<script type="text/html" id="coupon-form">
<div class="office-edit">
<div class="coupon-form form">
<? echo CHtml::form("#") ?>
    <div class="field">
        <?php echo $form->hiddenField($model, "[{{id}}]type"); ?>
        <?php echo $form->labelEx($model, "[{{id}}]text"); ?>
        <?php echo $form->textArea($model, "[{{id}}]text", array("rows"=>6, "cols"=>50,"class"=>"required")); ?>
        <?php echo $form->error($model, "[{{id}}]text"); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model, "[{{id}}]percent"); ?>
        <?php echo $form->textField($model, "[{{id}}]percent", array("size" => 10, "maxlength" => 10,"class"=>"required number")); ?>
        <?php echo $form->error($model, "[{{id}}]percent"); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model, "[{{id}}]cost"); ?>
        <?php echo $form->textField($model, "[{{id}}]cost", array("size" => 60, "maxlength" => 64)); ?>
        <?php echo $form->error($model, "[{{id}}]cost"); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model, "[{{id}}]price"); ?>
        <?php echo $form->textField($model, "[{{id}}]price", array("size" => 9, "maxlength" => 9,"class"=>"required number")); ?>
        <?php echo $form->error($model, "[{{id}}]price"); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model, "[{{id}}]limit"); ?>
        <?php echo CHtml::checkBox("unlim",true,array("id"=>"limit_trig","onclick"=>'$(this).siblings("input").toggle();',"style"=>"width:auto")) ?>Неограничено
        <?php echo $form->textField($model, "[{{id}}]limit", array("size" => 10, "maxlength" => 10,"style"=>"display:none")); ?>
        <?php echo $form->error($model, "[{{id}}]limit"); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model, "[{{id}}]limit_per_user"); ?>
        <?php echo CHtml::checkBox("Coupon[{{id}}][delete]",false,array("style"=>"visibility:hidden",'id'=>'delete_{{id}}')) ?>
        <?php echo CHtml::checkBox("unlpu",true,array("id"=>"lpu_trig","onclick"=>'$(this).siblings("input").toggle();',"style"=>"width:auto")) ?>Неограничено
        <?php echo $form->textField($model, "[{{id}}]limit_per_user", array("size" => 10, "maxlength" => 10,"style"=>"display:none")); ?>
        <?php echo $form->error($model, "[{{id}}]limit_per_user"); ?>
    </div>
    <? echo CHtml::endForm();?>
</div>
</div>
</script>