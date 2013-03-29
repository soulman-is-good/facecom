<div style="margin-left:25px;">
    <table cellspacing="0" cellpadding="0" class="officeContent">
		<tr>
			<td class="leftblock">
			  <input name="Name" type="text" value="" class='qsearch' placeholder="Поиск товаров и услуг"><a href="#" class='qsearchIcon'>&nbsp;</a>
			</td>
			<td class="mainblock">
                            <?if(Yii::app()->params['office']->isMyOffice()):?>
                            <div style="float:right;margin:14px 23px 0 0"><a href="<?=$this->createUrl('office/items/add',array('oid'=>$_GET['oid']))?>" class="gray bitbtn"><i class="icon buttonicon icon-plus">&nbsp;</i><?=Yii::t('site','Добавить товар или услугу');?></a></div>
                            <?endif;?>
                            <div class="orderby_l">Сортировать по</div><div class="orderby_f">Рейтингу</div><div class="orderby_b">&nbsp;</div>
                        </td>
		</tr>
	</table>
</div>