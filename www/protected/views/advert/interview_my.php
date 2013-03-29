<div class="content">
	<table cellspacing="0" cellpadding="0" class="advertContent">
		<tr>
			<td class="mainblock2">
              	<h1>Мои опросы</h1>
              	<div class="myIntrvMenu">
              	<span class="grayBtn" style="border-left: solid 1px #e1e1e1;">Мои опросы</span><a href="#" class="grayBtn">Бюджет</a><a href="/advert/interview/create" class="grayBtn">Создать опрос</a>
              	</div>
              	<form action="#" method="post">
              	<table border="0" cellspacing="7" cellpadding="0" class="defTable">
              		<tr>
              			<td align="right" valign="center" class="label">
              				Период статистики:
              			</td>
              			<td align="left" valign="center" class="value">
              				<div class="strictInput" id="fromdiv" style="float:left;">от<input name="from" id="fromval" type="text" value="23/11/2012" maxlength="10"></div>
              				<div class="strictInput" id="todiv">до<input name="from" id="toval" type="text" value="23/11/2012" maxlength="10"></div>
              			</td>
              		</tr>
              		<tr>
              			<td align="right" valign="center" class="label">
              				Показать:
              			</td>
              			<td align="left" valign="center" class="value">
              			    <select fcselect="" name="family_state" id="family_state">
              				<!--//<select size="1" name="show">//-->
              					<option value="1" selected="selected">Все опросы</option>
              					<option value="2">Не все опросы</option>
              					<option value="3">Почти все опросы</option>
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
               	<th>Ответы</th>
               	<th>Показы</th>
               </tr>
               <?
               		foreach($ivs as $iv){
               			if(intVal($iv->status)===0)
						{$stat='отсановлен';}
						elseif(intVal($iv->status)===1)
						{$stat='запущен';}
						else
						{$stat='черновик';}
						echo "<tr facecom=\"".$iv->id."\">\n";
						echo "<td><input name=\"".$iv->id."\" type=\"checkbox\" value=\"1\" /></td>\n";
						echo "<td><a href=\"#\">".$iv->name."</a></td>\n";
						echo "<td><a href=\"#\">$stat</a></td>\n";
						echo "<td>".$iv->price." VD</td>\n";
						$lim=(intVal($iv->limit)>0)?$iv->limit:'Не задан';
						echo "<td><a href=\"#\">$lim</a></td>\n";
						echo "<td>".$iv->spent." VD</td>\n";
						echo "<td>".$iv->answerCount()."</td>\n";
						echo "<td>".$iv->shows."</td>\n";
						echo "</tr>\n";

               		}
               ?>
               </table>
			</td>
			<td class="rightblock">
			<?$this->renderPartial('//advert/_right_table',array());?>
			</td>
		</tr>
	</table>
</div>