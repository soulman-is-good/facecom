<table border="0" cellspacing="7" cellpadding="0" class="defTable" id="q<?=$qMark?>" answers="2">
<tr>
<td align="right" valign="center" class="label"><label for="q[<?=$qMark?>]">Вопрос <?=$qMark?>:</label></td>
<td align="left" valign="center" class="value"><textarea name="q[<?=$qMark?>]" id="q[<?=$qMark?>]" placeholder="Введите вопрос №<?=$qMark?>"></textarea></td>
</tr>
<?$this->renderPartial('/advert/_interview_answer',array('last'=>false,'qMark'=>$qMark,'aMark'=>'1'));?>
<?$this->renderPartial('/advert/_interview_answer',array('last'=>true, 'qMark'=>$qMark,'aMark'=>'2'));?>
<tr>
<td align="right" valign="center" class="label">&nbsp;</td>
<td align="left" valign="center" class="value"><a href="#" onClick="addAnswer(<?=$qMark?>);return false;">Добавить еще ответ</a></td>
</tr><tr><td colspan="2"><hr /></td></tr>
</table>