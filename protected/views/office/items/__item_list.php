<?php
$url = $this->createUrl('office/items/show',array('oid'=>$_GET['oid'],'name'=>$model->name.'-'.$model->id));
?>
<table border="0" cellspacing="0" cellpadding="0" class="psItem">
    <tr>
        <td rowspan="2" width="125">
            <a href="<?=$url?>"><img src="/images/productico/<?=$model->image?>" alt="" class="tn" /></a>
        </td>
        <td class="title">
            <a href="<?=$url?>"><?=$model->title?></a>
        </td>
        <td width="195" class="info">
            <?=$model->status?'В наличии':'Нет в наличии'?>
        </td>
    </tr>
    <tr>
        <td class="description">
            <a href="/office/show">
                <?=nl2br(mb_substr($model->description,0,255,'UTF-8'))?>
            </a>
        </td>
        <td class="price">
            <?=$model->price*15?> тг. (<?=$model->price?> VD)<br />
            <a href="#" class="blue bitbtn cart" style="display:inline-block;margin-top:5px;" data-title="<?=addslashes($model->title)?>" data-id="<?=$model->id?>" data-price="<?=$model->price?>">Добавить в корзину</a><br/>
            <a href="<?=$this->createUrl('office/items/create',array('id'=>$model->id,'oid'=>$_GET['oid']))?>" class="blue bitbtn" style="display:inline-block;margin-top:5px;">Правка</a>
        </td>
    </tr>
</table>