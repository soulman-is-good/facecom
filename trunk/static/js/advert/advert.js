//�������������������������
function setSizerSize()
{
	$('#sizer').height(10);	$('#sizer').height($(document).height()-403);
}

function focusToInput(event)
{
	$(event.data.field).focus();
	//alert(event.data.field);
}


//����� �� ��������
function docReady(){	$(window).resize(setSizerSize);
	setSizerSize();
	//��� �������� ���� �����, �������� �����
	$('#fromdiv').on('click',null,{field: "#fromval"},focusToInput);
	$('#todiv').on('click',null,{field: "#toval"},focusToInput);
}

//���������� �����
$(document).ready(docReady);