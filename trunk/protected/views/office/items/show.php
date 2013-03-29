<?php
$this->renderPartial('//office/_info');
?>
<div class="content">
	<table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="leftblock">
			  <?$this->renderPartial('//office/_leftblock',array());?>
			</td>
			<td class="mainblock" style="padding-right:7px;">
				<a class="fcimage" href="/images/big/<?=$model->image?>"><img src="/images/avatar/<?=$model->image?>" alt="" border="0" class="bigtn" /></a>
				<div class="pStat">
				<?=$model->status?'В наличии':'Нет в наличии'?>
				</div>
				<div class="title" style="margin-bottom:15px;"><?=$model->title?></div>
				<div class="description">
				<?=nl2br($model->description)?>
				</div>
				
                                    <div data-url="<?=$this->createAbsoluteUrl('office/items/show',array('oid'=>$_GET['oid'],'name'=>$model->name.'-'.$model->id))?>" class="share42init"
                                         data-title="<?=addslashes($model->title)?>"
                                         data-image="<?=Yii::app()->getBaseUrl(true)?>/images/avatar/<?=$model->image?>"
                                         data-description="<?=  addslashes(mb_substr($model->description,0,255,'UTF-8'))?>"
                                         ></div>
                                    <script type="text/javascript" src="<?=Yii::app()->baseUrl?>/static/js/share42.js"></script>
				
				<div class="price" style="margin-top:8px;">
				<?=$model->price * 15?> тг. (<?=$model->price?> VD)<br />
                                <a href="#" class="toCartBtn cart" data-title="<?=addslashes($model->title)?>" data-id="<?=$model->id?>" data-price="<?=$model->price?>" style="margin-top:8px;">Добавить в корзину</a>
				</div>
			</td>
		</tr>
	</table>
</div>
<script>
    $(function(){
        $('.fcimage').each(function(){
            $(this).click(function(e){
                var img = $('<img />');
                img.attr('src',$(this).attr('href'));
                var x = $.dialog(img);
                img.load(function(){
                    x.setSize(this.width+20,this.height+100);
                    x.setPositionXY($(window).width()/2-this.width/2, 0);
                });
                e.stopPropagation();
                return false;
            })
        })
    })
</script>