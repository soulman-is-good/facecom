<?php
/**
 * @var Discount $model
 * @var DiscountController $this
 */
$max = $model->maxCoupon();
?>
<div class="content discount-show">    
    <a class='flag'>
        <div class="percent"><?= $max->percent ?>%</div>
        <div class="info">
            <div class="vd"><?= $max->price ?> VD</div>
            <div class="buy"><?= $max->type ? Yii::t('site', 'Купить сертификат') : Yii::t('site', 'Купить скидку'); ?></div>
        </div>
    </a>
</div>