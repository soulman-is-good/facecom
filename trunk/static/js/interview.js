/*function ivAnswer(formName)
{
	var addr=form.attr('action');
	alert('Ваши ответы учтены.\nСпасибо за участие!');
	$('#'+formName).slideUp();
	return false;
var qs={
	    'a':['да','нет']},
	2:{'q':'Какое подключение к Интернет используется у вас дома?',
	    'a':[
		'Оптоволокно',
		'ADSL',
		'WiMax',
		'3G',
		'GSM/GPRS/EDGE',
		'Dial-up',
		'я не подключен к сети Интернет']},
	3:{'q':'Имеете ли вы машину?',
	   'a':['да','нет']} ,
	4:{'q':'Смотрите ли вы сериалы?',
	    'a':[
		'да, каждый день',
		'иногда',
		'нет']}};
var cur=1;
function updateiv(){
	for (var key in qs[cur].a) {
    	inps+='<input name="a" class="hid" type="radio" value="'+key+'" id="iva'+key+'" /><label for="iva'+key+'" class="graytext"><span><span></span></span>'+qs[cur].a[key]+'</label><br />';
    }
	cur++;
	if(cur>4)cur=1;
}


$(function(){
	updateiv();
	$('.hid').live('click',updateiv);
	//alert(qs[1].q);
	//alert('iaiaia');