/*
 * Handles search page
 */
$(function(){
    //define templates
    var new_work = false; // we will generate it later, so that dropdown list appear
    //delete checkbox logic
    $('.field.delete').each(function(){
        var self = $(this);
        self.parent().prepend(self.css({'float':'right'}));//move to begin of a tree because float
        var label = self.children('label');
        var check = self.children('input').css({'display':'none'});
        var img = $('<a />').addClass('delete').attr({'title':label.text()}).css({'cursor':'pointer'}).html(label.text());
        img.click(function(){
            check.attr('checked',true);
            self.parent().fadeOut().next('.hr').remove();
            return false;
        })
        self.append(img);
        label.remove();
    })
    //city and country logic
    $('.country_id').live('change',function(){
        var self = $(this);
        var cid = self.val();
        var cities = $(self.attr('for'));
        if(cities.is(':disabled')) return false;
        cities.empty();
        var loading = $('<img />').attr({'src':'/static/css/loader01.gif','alt':'Загрузка...','title':'Загрузка'});
        loading.insertAfter(cities);
        cities.attr({'disabled':true});
        $.ajax({url:'/my/citiesWithAny',data:{cid:cid},success:function(m){
            for(i in m){
                cities.append(
                    $('<option />').html(m[i])
                );
            }
            cities.attr({'disabled':false});
            cities.children(':contains("'+cities.data('city')+'")').attr({'selected':true});
            loading.remove();
            if(new_work == false && self.parent().hasClass('isnewwork')){
                var c = $('#new_work').clone()
                c.find('.select').remove();
                new_work = '<div class="form education newwork">'+c.removeAttr('id').html()+'</div>'
            }
            if(cities.data('fcselect') == null)
                cities.fcselect();
            else{
                cities.data('fcselect').destroy();
                cities.fcselect();
            }
        },dataType:'json',cache:true})
    })
    cityInit();
    $("#searchform input, #searchform select").change(updateRes);
    $('#searchform').submit(function() {
    	return false;
    });
    //blocks animation
    $('#popup1').slideUp();
    $('#popup2').slideUp();
    $('#popup3').slideUp();
    $('#control1').click(function () {
      if ($("#popup1").is(":hidden")) {
        $("#popup1").show("slow");
        $('#control1').html('▲');
      } else {
        $("#popup1").slideUp();
        $('#control1').html('▼');
      }
      return false;
    });
    $('#control2').click(function () {
      if ($("#popup2").is(":hidden")) {
        $("#popup2").show("slow");
        $('#control2').html('▲');
      } else {
        $("#popup2").slideUp();
        $('#control2').html('▼');
      }
      return false;
    });
    $('#control3').click(function () {
      if ($("#popup3").is(":hidden")) {
        $("#popup3").show("slow");
        $('#control3').html('▲');
      } else {
        $("#popup3").slideUp();
        $('#control3').html('▼');
      }
      return false;
    });
})
function cityInit(el){
    if(typeof el == 'undefined' || el == null){
        $('.country_id').each(function(i){
            var cit = $($(this).attr('for'));
            var val = cit.val();
            var id = cit.attr('id');
            cit.replaceWith($('<select />').attr({'class':'city_id','id':id,'name':cit.attr('name')}).data('city',val))
            $(this).change();
        })
    }else{
        var cit = $(el.attr('for'));
        var val = cit.val();
        var id = cit.attr('id');
        cit.replaceWith($('<select />').attr({'class':'city_id','id':id,'name':cit.attr('name')}).data('city',val)).fcselect();
        el.change();
    }
}
//update search results by user criteria

var order=0;
var sq=$('#searchform input[name="query"]').val();
function updateRes()
{
	//intialize fields

	//$('#searchform input[name="query"]').val('дим');
	var country=$('#searchform select[name="country_id"]').val();
	var city=$('#searchform select[name="city"]').val();
	var gender=$('#searchform input:radio:checked[name="gender"]').val();
	var age_from=$('#searchform input[name="age_from"]').val();
	var age_to=$('#searchform input[name="age_to"]').val();
	var withPhoto=$('#searchform input:checkbox:checked[name="withPhoto"]').val();
	var onlyNames=$('#searchform input:checkbox:checked[name="onlyNames"]').val();
	var family_state=$('#searchform select[name="family_state"]').val();
	var school=$('#searchform input[name="school"]').val();
	var clas=$('#searchform input[name="class"]').val();
	var schoolyear=$('#searchform select[name="schoolyear"]').val();
	var uni=$('#searchform input[name="uni"]').val();
	var fac=$('#searchform input[name="fac"]').val();
	var uniyear=$('#searchform select[name="uniyear"]').val();
	var workplace=$('#searchform input[name="workplace"]').val();
	var workstate=$('#searchform input[name="workstate"]').val();
	var birthyear=$('#searchform select[name="birthyear"]').val();
	var birthmonth=$('#searchform select[name="birthmonth"]').val();
	var birthday=$('#searchform select[name="birthday"]').val();
	//check fields
	if(sq=='Введите имя или слово для поиска')sq='';
	if(city=='любой город')city='';
	if(school=='школа')school='';
	if(clas=='класс')clas='';
	if(uni=='Выберите учебное заведение')uni='';
	if(fac=='Выберите факультет')fac='';
	if(workplace=='Место')workplace='';
	if(workstate=='Должность')workstate='';
	if(withPhoto!=1)withPhoto=0;
	if(onlyNames!=1)onlyNames=0;
	if(isNaN(age_from))age_from=0;
	if(age_from<0)age_from=0;
	if(isNaN(age_to))age_to=age_from;
	if(age_to<age_from)age_to=age_from;
	if(age_to==0)
	{
		$('#searchform input[name="age_from"]').val('');
		$('#searchform input[name="age_to"]').val('');
	}
	else
	{
		$('#searchform input[name="age_from"]').val(age_from);
		$('#searchform input[name="age_to"]').val(age_to);
	}
	//update address bar
	var getQuery='?query='+encodeURIComponent(sq)+'&country='+encodeURIComponent(country)+'&city='+encodeURIComponent(city);
	getQuery+='&age_from='+encodeURIComponent(age_from)+'&age_to='+encodeURIComponent(age_to)+'&withPhoto='+encodeURIComponent(withPhoto);
	getQuery+='&onlyNames='+encodeURIComponent(onlyNames)+'&gender='+encodeURIComponent(gender)+'&family_state='+encodeURIComponent(family_state);
	getQuery+='&school='+encodeURIComponent(school)+'&uni='+encodeURIComponent(uni)+'&fac='+encodeURIComponent(fac);
	getQuery+='&uniyear='+encodeURIComponent(uniyear)+'&workplace='+encodeURIComponent(workplace)+'&workstate='+encodeURIComponent(workstate);
	getQuery+='&birthyear='+encodeURIComponent(birthyear)+'&birthmonth='+encodeURIComponent(birthmonth)+'&birthday='+encodeURIComponent(birthday);
	//history.
	//send request
	$.get('/search/peopleUpdate',
		{   ajax:'ajax',
			query:sq,
			country:country,
			city:city,
			age_from:age_from,
			age_to:age_to,
			withPhoto:withPhoto,
			onlyNames:onlyNames,
			gender:gender,
			family_state:family_state,
			school:school,
			clas:clas,
			schoolyear:schoolyear,
			uni:uni,
			fac:fac,
			uniyear:uniyear,
			workplace:workplace,
			workstate:workstate,
			birthyear:birthyear,
			birthmonth:birthmonth,
			birthday:birthday
		},
		//handling result
		function(data)
		{
			if(data.status=='ok'){
				//insert result
				//alert(data.data);
				$('.list_res').html(data.data);
			 	$('.found_num').html(data.total);
			 }
			else
			{alert(data.data);}
		},
		'json'
	);
	//alert('ajax'+':'+'ajax'+',query:'+sq+',country:'+country+',city:'+city+',age_from:'+age_from+',age_to:'+age_to+',withPhoto:'+withPhoto+',onlyNames:'+onlyNames+',gender:'+gender+',family_state:'+family_state+',school:'+school+',clas:'+clas+',schoolyear:'+schoolyear+',uni:'+uni+',fac:'+fac+',uniyear:'+uniyear+',workplace:'+workplace+',workstate:'+workstate+',birthyear:'+birthyear+',birthmonth:'+birthmonth+',birthday:'+birthday);
}

//order menu preview
function showorderdiv()
{
	if ($(".orderdiv").is(":hidden")) {
		$(".orderdiv").show("fast",binder);
	}
}

function binder()
{
	$('body').bind('click', hideorderdiv);
}

function hideorderdiv()
{
	$(".orderdiv").slideUp();
	$('body').unbind('click', hideorderdiv);
	jj=false;
}
//order menu logic
function changeorder(ord)
{
	order=ord;
	if(ord==0){$("#orderlabel").text("Рейтингу");}
	else $("#orderlabel").text("Дате регистрации");
}