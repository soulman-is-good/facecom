<div class="content">
	<table cellspacing="0" cellpadding="0" class="advertContent">
		<tr>
			<td class="mainblock2">
              	<h1>Создание опроса<span id="h2" style="display:none;"> - Шаг 2 Целевая аудитория</span></h1>
<!--// Следующий блок содержит заготовки для быстрого добавления элементов /-->
<div style="display:none;" id="templates">
<div template="answer">
<table>
<?$this->renderPartial('/advert/_interview_answer',array('last'=>true,'qMark'=>'‡','aMark'=>'†'));?>
</table>
</div>
<div template="question">
<?$this->renderPartial('/advert/_interview_question',array('last'=>false,'qMark'=>'‡'));?>
</div>
</div>

              	<div class="stepMenu">
                	<a href="#step1" style="z-index:21;" class="active" facecom="tablink">Шаг №1</a><a href="#step2" style="z-index:20; left:-16px;" facecom="tablink">Шаг №2</a>
              	</div>
              	<form action="/advert/interview/run" method="post" name="interview" id="interviewForm" onSubmit="return validate();">
              	<div id="step1" facecom="tab" questions="2">
              	<a name="step1"></a>
              	<table border="0" cellspacing="7" cellpadding="0" class="defTable">
              		<tr>
              			<td align="right" valign="center" class="label">
              				<label for="name">Служебное название опроса</label>
              			</td>
              			<td align="left" valign="center" class="value">
              				<input name="name" id="name" type="text" placeholder="Введите название" class="wide" value="" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				<label for="title">Заголовок опроса</label>
              			</td>
              			<td align="left" valign="center" class="value">
              				<input name="title" id="title" type="text" placeholder="Введите заголовок" class="wide" value="" />
              			</td>
              		</tr>
              	</table>
              	<?for($i=1;$i<=2;$i++):?>
              	<?$this->renderPartial('/advert/_interview_question',array('last'=>false,'qMark'=>$i));?>
              	<?endfor;?>
              	<table border="0" cellspacing="7" cellpadding="0" class="defTable">
              	<tr>
              			<td align="right" valign="center" class="label">&nbsp;
              			</td>
              			<td align="left" valign="center" class="value">
              				<a href="#" onClick="addQuestion();">Добавить еще вопрос</a>
              			</td>
              		</tr>
              	</table>
              	</div>
              	<div id="step2" facecom="tab">
              	<a name="step2"></a>
              	<table border="0" cellspacing="7" cellpadding="0" class="defTable" width="100%">
              		<tr>
              			<td align="right" valign="center" class="label" width="133">&nbsp;
              			</td>
              			<td align="left" valign="center" class="info">
              				Целевая аудитория - <span class="respCount">0</span>
              			</td>
              		</tr>
              		<!--<tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				as:
              			</td>
              			<td align="left" valign="center" class="value">
              			</td>
              		</tr> -->
              		<tr>
              			<td align="right" valign="center" class="label">&nbsp;
              			</td>
              			<td align="left" valign="center" class="header">
              				География
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Страна:
              			</td>
<?
$cl=Country::model()->findAll(array('select'=>'country_id, name'));
$anyCountry=new Country;
$anyCountry->country_id=-1;
$anyCountry->name='любая страна';
$countrylist[0]=$anyCountry;
$countrylist=array_merge($countrylist,$cl);
$countries = CHtml::listData($countrylist, 'country_id', 'name');
$country_id = 9999999;
$city='любой город';
$city_data=array('-1'=>$city);
?>
              			<td align="left" valign="center" class="value">
<?php echo CHtml::dropDownList('country_id',$country_id,$countries,array('class'=>'country_id','for'=>'#city_id','fcselect'=>"width:'411px'")); ?>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Города:
              			</td>
              			<td align="left" valign="center" class="value">
<?php echo CHtml::checkBoxList('city','',$city_data, array('container' => 'span class="checkBoxList" id="city_id"  fcselect="width:\'411px\'"',)); ?>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				&nbsp;
              			</td>
              			<td align="left" valign="center" class="hint">
                            Вы можете выбрать несколько городов
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              			</td>
              			<td align="left" valign="center" class="header">
              				Демография
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Пол:
              			</td>
              			<td align="left" valign="center" class="value">
              				<select size="1" name="gender" fcselect="width:'411px'">
              					<option value="-1">любой</option>
              					<option value="0">мужской</option>
              					<option value="1">женский</option>
              				</select>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Семейное положение
              			</td>
              			<td align="left" valign="center" class="value">
              				<span class="checkBoxList" id="fs" fcselect="width:'411px'">
              					<input value="0" id="fs0" name="fs[]" type="checkbox"> <label for="fs0">холост/не замужем</label>
              					<input value="1" id="fs1" name="fs[]" type="checkbox"> <label for="fs1">женат/замужем</label>
              					<input value="2" id="fs2" name="fs[]" type="checkbox"> <label for="fs2">есть друг/пожруга</label>
              					<input value="3" id="fs3" name="fs[]" type="checkbox"> <label for="fs3">в активном поиске</label>
              				</span>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				&nbsp;
              			</td>
              			<td align="left" valign="center" class="hint">
                            Вы можете выбрать несколько пунктов
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Возраст:
              			</td>
              			<td align="left" valign="center" class="value">
              				<input name="age_from" type="text" size="5" maxlength="3" style="width:70px;" placeholder="От" /> - <input name="age_to" type="text" placeholder="До" size="5" maxlength="3" style="width:70px;" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              			</td>
              			<td align="left" valign="center" class="header">
              				Образование
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Школа:
              			</td>
              			<td align="left" valign="center" class="value">
                  			<input name="school" type="text" placeholder="выберите школу" class="wide" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Класс:
              			</td>
              			<td align="left" valign="center" class="value">
                  			<input name="class" type="text" placeholder="выберите класс" class="wide" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Год выпуска:
              			</td>
              			<td align="left" valign="center" class="value">
              				<?
 							$till = (int)date('Y');
		    				$from = $till-100;
		    				$years2 = range($from, $till);
		    				$years2 = array_combine($years2, $years2);
		    				$years=array('0'=>'любой');
		    				$years+=$years2;
		    				echo CHtml::dropDownList("schoolyear",9999,$years,array('fcselect'=>"width:'411px'"));
		                    ?>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Колледж или университет:
              			</td>
              			<td align="left" valign="center" class="value">
                  			<input name="uni" type="text" placeholder="выберите учебное заведение" class="wide" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Факультет:
              			</td>
              			<td align="left" valign="center" class="value">
                  			<input name="fac" type="text" placeholder="выберите факультет" class="wide" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Год выпуска:
              			</td>
              			<td align="left" valign="center" class="value">
              				<?
 							$till = (int)date('Y');
		    				$from = $till-100;
		    				$years2 = range($from, $till);
		    				$years2 = array_combine($years2, $years2);
		    				$years=array('0'=>'любой');
		    				$years+=$years2;
		    				echo CHtml::dropDownList("uniyear",9999,$years,array('fcselect'=>"width:'411px'"));
		                    ?>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              			</td>
              			<td align="left" valign="center" class="header">
              				Работа
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Место:
              			</td>
              			<td align="left" valign="center" class="value">
                  			<input name="workplace" type="text" placeholder="выберите место работы" class="wide" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Должность:
              			</td>
              			<td align="left" valign="center" class="value">
                  			<input name="workstate" type="text" placeholder="укажите должность" class="wide" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              			</td>
              			<td align="left" valign="center" class="header">
              				Бюджет
              			</td>
              		</tr>

              		<tr>
              			<td align="right" valign="center" class="label">
              				Цена одного вопроса (VD):
              			</td>
              			<td align="left" valign="center" class="value">
              				<input name="cost" type="text" placeholder="Введите стоимость" class="wide" value="" />
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Итого:
              			</td>
              			<td align="left" valign="center" class="hint" style="color:#000;">
              				<span class="qc">0</span> вопросов - <span class="p1">0</span> VD<br />
              				<span class="p1">0</span> VD x <span class="respCount">0</span> чел. = <b><span class="p2">0</span> VD</b><br />
              				(макс. стоимость)
              			</td>
              		</tr><tr>
              			<td align="right" valign="center" class="label">
              				Лимит:
              			</td>
              			<td align="left" valign="center" class="value">
              				<input name="limit" type="text" placeholder="не задан" class="wide" value="" />
              			</td>
              		</tr>
              	</table>
              	</div>
              	<a href="#" class="blueBtn" style="margin-left:146px;">Сохранить в черновик</a>
              	<a href="#step2" class="blueBtn" style="float:right" id="to2">Далее</a>
              	<input type="submit" value="запустить" class="blueBtn" id="run" />
              	</form>
			</td>
			<td class="rightblock">
			<?$this->renderPartial('//advert/_right_table',array());?>
			</td>
		</tr>
	</table>
</div>