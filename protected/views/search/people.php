<?
$states=array('Выберите статус','холост/не замужем','женат/замужем','есть подруга/друг','в активном поиске');
?>
<div class="searchPage">
<?	$this->beginWidget('CActiveForm', array(
     	'id' => 'searchform',
     	'method'=>'get',
       	'enableClientValidation' => true,
       	'enableAjaxValidation' => true,
       	'clientOptions'=>array('onsubmit' => 'return false;')
  	)
	);
$q=($query=='')?'Введите имя или слово для поиска':$query;
?>
	<div class="segmentation">
			<label for="query" class="searchLabel">Поиск</label>
 			<input type="text" name="query" class="msearch" value="<?=$query?>" placeholder="Введите имя или слово для поиска" onchange="sq=$(this).val()" />
 			<!--//<input type="submit" value="Поиск" class="searchSubmitBtn">//-->
		<div class="searchMenu">
		<a href="#"><div class="item active">Люди</div></a>
		<a href="#"><div class="item">Компании</div></a>
		<a href="#"><div class="item">Новости</div></a>
		<a href="#"><div class="item">Группы</div></a>
		<a href="#"><div class="item">Музыка</div></a>
		<a href="#"><div class="item">Видео</div></a>
		</div>
	</div>
	<div class="segmentation">
		<font class="found">Найдено людей: <span class="found_num"><?=$total?></span></span>
		<div class="sortMenu">
			Сортировать по: <a href="#" onclick="showorderdiv(); return false;" id="orderlabel">Рейтингу</a>&nbsp;&nbsp;<a href="#" id="ascdesc" onclick="ascdesc(); return false;">▼</a><br />
			<div class="orderdiv" style="display:none;" onMouseOver="showorderdiv2();" onMouseOut="hidediv2();" >
				<a href="#" onclick="changeorder(0); return false;">Рейтингу</a>
				<a href="#" onclick="changeorder(1); return false;">Дате регистрации</a>
		    </div>
		</div>
	</div>
	<div class="segmentation" style="border-bottom:none;">
 		<table border="0" cellspacing="0" cellpadding="0" width="100%">
 		<tr>
 		<td valign="top">
 		<div class="list_res">
            <?=$data?>
        </div>
 		</td>
 		<td width="260" valign="top">
 		<?
 			$this->renderPartial('_formRegionBlock',array());?>
 			<label for="school">Школа</label>
 			<input name="school" type="text" value="школа" onfocus="this.value=(this.value=='школа') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'школа' : this.value;">
 			<input name="class" type="text" value="класс" onfocus="this.value=(this.value=='класс') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'класс' : this.value;">
 			<?
 			$till = (int)date('Y');
		    $from = $till-100;
		    $years2 = range($from, $till);
		    $years2 = array_combine($years2, $years2);
		    $years=array('0'=>'Выберите год выпуска');
		    $years+=$years2;
		    $years3=array('0'=>'Выберите год рождения');
		    $years3+=$years2;
    		?>
 			<?php echo CHtml::dropDownList("schoolyear",9999,$years,array('fcselect'=>true)) ?>
 			<label for="uni">Колледж или университет</label>
 			<input name="uni" type="text" value="Выберите учебное заведение" onfocus="this.value=(this.value=='Выберите учебное заведение') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Выберите учебное заведение' : this.value;">
 			<input name="fac" type="text" value="Выберите факультет" onfocus="this.value=(this.value=='Выберите факультет') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Выберите факультет' : this.value;">
 			<?php echo CHtml::dropDownList("uniyear",9999,$years,array('fcselect'=>true)) ?>
 			<label for="age_from">Возраст</label>
 			<input name="age_from" type="text" size="5" maxlength="3" style="width:70px;" placeholder="От" /> - <input name="age_to" type="text" placeholder="До" size="5" maxlength="3" style="width:70px;" /><br />
 			<label for="gender">Пол</label>
 			<input name="gender" type="radio" value="1" id="g1" class="hid" /><label for="g1" class="graytext"><span><span></span></span>Мужской</label><br />
 			<input name="gender" type="radio" value="2" id="g2" class="hid" /><label for="g2" class="graytext"><span><span></span></span>Женский</label><br />
 			<input name="gender" type="radio" value="0" id="g0" class="hid" checked="checked" /><label for="g0" class="graytext"><span><span></span></span>Любой</label>
 			<label for="family_state">Семейное положение</label>
 			<?php echo CHtml::dropDownList('family_state',99,$states,array('fcselect'=>false)); ?>
 			<label for="family_state">Места <a href='#' id="control3">▼</a></label>
 			<div id='popup3'>
 				<div class="select">Казахстан</div>
 				<div class="select">Алматы</div>
 			</div>
 			<label for="workplace">Работа <a href='#' id="control2">▼</a></label>
 			<div id='popup2'>
 				<input name="workplace" type="text" value="Место" onfocus="this.value=(this.value=='Место') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Место' : this.value;">
 				<input name="workstate" type="text" value="Должность" onfocus="this.value=(this.value=='Должность') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Должность' : this.value;">
 			</div>
 			<label for="withPhoto">Дополнительно <a href='#' id="control1">▼</a></label>
 			<div id='popup1'>
 				<input name="withPhoto" class="hid" type="checkbox" value="1" id="wp"><label for="wp" class="graytext"><span><span></span></span>с фотографией</label><br />
 				<input name="onlyNames" class="hid" type="checkbox" value="1" checked="checked" id="onln"><label for="onln" class="graytext"><span><span></span></span>только в именах</label><br />
 				<?
 				echo CHtml::dropDownList("birthyear",9999,$years3,array('fcselect'=>true));
 				$months=array('Выберите месяц рождения','январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
 				echo CHtml::dropDownList("birthmonth",9999,$months,array('fcselect'=>true));
 				$days=array('Выберите день рождения');
 				for($i=1;$i<=31;$i++){
 					$days[]=$i;
 				}
 				echo CHtml::dropDownList("birthday",9999,$days,array('fcselect'=>true));
 				?>
 			</div>
 		</td>
 		</tr>
 		</table>
	</div>
<? $this->endWidget(); ?>
</div>