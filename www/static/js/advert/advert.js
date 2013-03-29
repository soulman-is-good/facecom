//навсюстраницурастягивалка
function setSizerSize()
{
	$('#sizer').height(10);	$('#sizer').height($(document).height()-403);
}

function focusToInput(event)
{
	$(event.data.field).focus();
	//alert(event.data.field);
}


//вызов по загрузке
function docReady(){	$(window).resize(setSizerSize);
	setSizerSize();
	//для строгого поля ввода, передать фокус
	$('#fromdiv').on('click',null,{field: "#fromval"},focusToInput);
	$('#todiv').on('click',null,{field: "#toval"},focusToInput);
}

//собственно евент
$(document).ready(docReady);