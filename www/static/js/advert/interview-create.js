//step tabs logic
var current = location.hash;
function changeStep() {	$(document).find('div[facecom="tab"]').hide();
	$(document).find('a.active').removeClass('active');
	if(current=='')current="#step1";	$(current).show();
	$('a[href="'+current+'"]').addClass('active');
	if(current=='#step1'){		$('#h2').hide();
		$('#run').hide();
		$('#to2').show();
	}else{		$('#h2').show();
		$('#run').show();
		$('#to2').hide();
	}}

$(window).bind('hashchange', function() {
	var active = location.hash;
	if (active!=current){
		current=active;
		changeStep();
	}
});

$(function(){	changeStep();
	$("#interviewForm input, #interviewForm select, #interviewForm textarea").change(updateRes);
	//city and country logic
	$('.country_id').live('change',function(){		var self = $(this);
        var cid = self.val();
        var cities = self.attr('for');
        $(cities+' input:not(:checked), '+cities+' input:not(:checked) + label').remove();
        $.ajax({url:'/my/citiesWithAnyInCountry',data:{cid:cid},success:function(m){
            for(i in m){
                $(cities).append('<input value="'+i+'" id="city_'+i+'" type="checkbox" name="city[]" /> <label for="city_'+i+'">'+m[i]+'</label>\n');
            }
            var ops = {};
            ops.multiselect=true;
            ops.width='411px';
            $(cities).next('.select.multi').remove();
            $(cities).fcselect(ops);
        },dataType:'json',cache:true});

	});
});

//add question and answer feature
function addAnswer(q_no){	var answer_tmpl=$('#templates div[template="answer"] tr[facecom="last"]').parent().html();	var last=$('#q'+q_no+' tr[facecom="last"]');
	var current_answer=$('#q'+q_no).attr('answers');
	current_answer++;
	var answer=answer_tmpl.replace(new RegExp("†",'g'),current_answer).replace(new RegExp("‡",'g'),q_no);
	last.after(answer);
	last.removeAttr("facecom");
	$('#q'+q_no).attr('answers',current_answer);}

function addQuestion(){	var q_tmpl=$('#templates div[template="question"]').html();	var total=$('#step1').attr('questions');
	var last=$('#q'+total);
	//alert($('#step1').attr('questions'));
	total++;
	var question=q_tmpl.replace(new RegExp("‡",'g'),total);
	last.after(question);
	$('#step1').attr('questions',total);
}

// Join array elements with a string
function implode(glue, pieces) {
	return ((pieces instanceof Array)?pieces.join(glue):pieces);
}

//validate form before send
function validate()
{
	var valid=true;
	var warning_stack=new Array();
	$("#step1 input").each(function(){		var cont=$(this).val().trim();
		if(empty(cont)){			var lid=$(this).attr('id');			var label=$('label[for="'+lid+'"]').html();			warning_stack.push('Поле "'+label+'" не заполнено');
			valid=false;		}	});
	$("#step1 textarea").each(function(){
		var cont=$(this).html().trim();
		if(empty(cont)){
			var lid=$(this).attr('id');
			var label=$('label[for="'+lid+'"]').html();
			warning_stack.push('Поле "'+label+'" не заполнено');
			valid=false;
		}
	});
	var age_from=$('form[name="interview"] input[name="age_from"]').val();
	var age_to=$('form[name="interview"] input[name="age_to"]').val();
	if(isNaN(age_from))age_from=0;
	if(age_from<0)age_from=0;
	if(isNaN(age_to))age_to=age_from;
	if(age_to<age_from)age_to=age_from;
	if(age_to==0)
	{
		$('form[name="interview"] input[name="age_from"]').val('');
		$('form[name="interview"] input[name="age_to"]').val('');
	}
	else
	{
		$('form[name="interview"] input[name="age_from"]').val(age_from);
		$('form[name="interview"] input[name="age_to"]').val(age_to);
	}
	var cost=0;
	cost=$('form[name="interview"] input[name="cost"]').val();
	cost=1*cost;
	if(isNaN(cost)){cost=0;}
	if(cost<0){cost=Math.abs(cost);}
	$('form[name="interview"] input[name="cost"]').val(cost);
	if(cost<=0){		warning_stack.push('Цена вопроса должна быть больше 0');
		valid=false;
	}
	var limit=0;
	limit=$('form[name="interview"] input[name="limit"]').val();
	limit=1*limit;
	if(isNaN(limit)){limit=0;}
	if(limit<0){limit=Math.abs(limit);}
	$('form[name="interview"] input[name="limit"]').val(limit);
	if(valid){return true;}
	else{alert(implode('\n',warning_stack));}
	return valid;}

//update search results by user criteria
function updateRes()
{
    var age_from=$('form[name="interview"] input[name="age_from"]').val();
	var age_to=$('form[name="interview"] input[name="age_to"]').val();
	if(isNaN(age_from))age_from=0;
	if(age_from<0)age_from=0;
	if(isNaN(age_to))age_to=age_from;
	if(age_to<age_from)age_to=age_from;
	if(age_to==0)
	{
		$('form[name="interview"] input[name="age_from"]').val('');
		$('form[name="interview"] input[name="age_to"]').val('');
	}
	else
	{
		$('form[name="interview"] input[name="age_from"]').val(age_from);
		$('form[name="interview"] input[name="age_to"]').val(age_to);
	}
	//var
	var cost=0;
	cost=$('form[name="interview"] input[name="cost"]').val();
	cost=1*cost;
	if(isNaN(cost)){cost=0;}
	if(cost<0){cost=Math.abs(cost);}
	$('form[name="interview"] input[name="cost"]').val(cost);
	$.get('/search/interviewCount',
		$('form[name="interview"]').serialize(),
		function(data){
	//alert('**'+data.total);
			if(data.status=='ok'){
			 	var resps=data.total;
			 	var qc=$('#step1').attr('questions');
			 	qc=1*qc;
			 	var p1=qc*cost;
			 	var p2=p1*resps;
			 	resps+='';
			 	qc+='';
			 	p1+='';
			 	p2+='';
			 	$(".respCount").text(resps.triadDigits());
			 	$(".qc").text(qc.triadDigits());
			 	$(".p1").text(p1.triadDigits());
			 	$(".p2").text(p2.triadDigits());
			 }
			else
			{alert(data.data);}
		},
		'json'
	);
}