<div class="content">
	<table cellspacing="0" cellpadding="0" class="advertContent">
		<tr>
			<td class="mainblock2">
              	<h1>Мои объявления</h1>
              	<div class="myIntrvMenu">
              	<span class="grayBtn" style="border-left: solid 1px #e1e1e1;">Мои объявления</span><a href="#" class="grayBtn">Бюджет</a><a href="/advert/target/create" class="grayBtn">Создать объявление</a>
              	</div>
              	<form action="#" method="post">
              	<table border="0" cellspacing="7" cellpadding="0" class="defTable">
              		<tr>
              			<td align="right" valign="center" class="label">
              				Период статистики:
              			</td>
              			<td align="left" valign="center" class="value">
              				<div class="strictInput" id="fromdiv" style="float:left;">от<input name="from" id="fromval" type="text" value="" maxlength="10"></div>
              				<div class="strictInput" id="todiv">до<input name="from" id="toval" type="text" value="" maxlength="10"></div>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Показать:
              			</td>
              			<td align="left" valign="center" class="value">
              			    <select fcselect="" name="family_state" id="family_state">
              				<!--//<select size="1" name="show">//-->
              					<option value="1" selected="selected">Все объявления</option>
              					<option value="2">Не все объявления</option>
              					<option value="3">Почти все объявления</option>
              				</select>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Выделить:
              			</td>
              			<td align="left" valign="center" class="value">
              			<input id="ytUserProfile_languages" type="hidden" value="" name="selectFilter" /><span class="checkBoxList" fcselect="" id="UserProfile_languages"><input id="UserProfile_languages_0" value="1" checked="checked" type="checkbox" name="UserProfile[languages][]" /> <label for="UserProfile_languages_0">Все</label><br/>
<input id="UserProfile_languages_1" value="2" checked="checked" type="checkbox" name="UserProfile[languages][]" /> <label for="UserProfile_languages_1">Запущенные</label><br/>
<input id="UserProfile_languages_2" value="3" checked="checked" type="checkbox" name="UserProfile[languages][]" /> <label for="UserProfile_languages_2">Остановленные</label></span>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				&nbsp;
              			</td>
              			<td align="left" valign="center" class="value">
              			<a href="#" class="blueBtn">Запустить</a>
              			</td>
              		</tr>
              	</table>
              	</form>
               <table class="interviewList" border="0" cellspacing="0" cellpadding="0">
               <tr>
                <th>&nbsp;</th>
               	<th>Название</th>
               	<th>Статус</th>
               	<th>Цена</th>
               	<th>Лимит</th>
               	<th>Потрачено</th>
               	<th>Показы</th>
               </tr>
               <tr facecom="1">
               <td><input name="1" type="checkbox" value="1" /></td>
               <td><a href="#">example</a></td>
               <td><a href="#">запущен</a></td>
               <td>20 VD</td>
               <td><a href="#">Не задан</a></td>
               <td><a href="#">700</a></td>
               <td><a href="#">35</a></td>
               </tr>
               <tr facecom="1">
               <td><input name="1" type="checkbox" value="1" /></td>
               <td><a href="#">example 2</a></td>
               <td><a href="#">запущен</a></td>
               <td>1 VD</td>
               <td><a href="#">Не задан</a></td>
               <td><a href="#">72</a></td>
               <td><a href="#">72</a></td>
               </tr>
               </table>
			</td>
			<td class="rightblock">
			<?$this->renderPartial('//advert/_right_table',array());?>
			</td>
		</tr>
	</table>
</div>