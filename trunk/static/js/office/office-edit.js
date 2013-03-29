/* 
 * Handles profile/edit page
 */
var map;
var marker;
function handleNoGeolocation(){
    //we'll use yandex then...
    $.getScript('//api-maps.yandex.ru/2.0-stable/?lang=ru-RU&coordorder=longlat&load=package.map',function(){
        ymaps.ready(function(){
            map.setCenter(new google.maps.LatLng(ymaps.geolocation.latitude, ymaps.geolocation.longitude),13);
        })
    })
}
function placeMarker(location) {
    if (!marker){
        marker = new google.maps.Marker({
            position: location,
            map: map
        });
    } else {
        marker.setPosition(location);
    }
    $('#Office_lat').val(location.lat());
    $('#Office_long').val(location.lng());
    return marker;
}
function updateMap(){
    setTimeout(function(){
        google.maps.event.trigger(map, 'resize'); 
        map.setCenter(map.getCenter());
    },100);
}

$(function(){
(function( $ ){
    $.fn.fctabs = function(){
        var $self = $(this);
        var active = location.hash;
        $(this).find('> div:not([facecom="keepvisible"])').css({'display':'none'});
        if(active != '' && $(this).find('> ul li a[href="'+active+'"]').length>0){
            $(this).find($(this).find('> ul li a[href="'+active+'"]').addClass('active').attr('href')).css({'display':'block'});
        }else{   
            $(this).find($(this).find('> ul li a:first').addClass('active').attr('href')).css({'display':'block'});
        }
        $(this).find('> ul li a').click(function(e){
            var $s = $(this);
            if($s.hasClass('active')) 
                return false;
            var active = $self.find('> ul li a.active');
            $(active.removeClass('active').attr('href')).css('display','none');
            var id = $s.addClass('active').attr('href');
            $(id).css('display','block');
            return false;
        });    
    }
    
})(jQuery);

    /////////////////////////////////////////////////
    //CONTACTS
    /////////////////////////////////////////////////
    var contacts = ($('#Office_contacts').val().replace(/,/g,';')).split(';');
    var _C_ = $('#Office_contacts').css({'opacity':'0','position':'absolute','width':0,'height':0,'left':'-9999px','top':'-9999px'});
    var DIV = $('<div />').css({'margin-left':'194px'}).sortable({'axis':'y','stop':function(){update_contacts();}});
    function update_contacts() {
        var cnts = [];
        DIV.children('div').each(function(){
            var c = $(this).children('select').val() + ':' + $(this).children('input').val();
            cnts.push(c);
        })
        _C_.val(cnts.join(';'));
    }
    DIV.insertAfter(_C_);
    for(i in contacts){
        var sel = $($('#SEL').html()).change(function(){update_contacts();});
        var opt = $('<input />').attr({'type':'text'}).css({'position':'relative','top':'-3px','width':'243px','margin-left':'5px'}).change(function(){update_contacts();})
        var a = contacts[i].split(':');
        var x = $('<a class="delete" title="Удалить" style="cursor: pointer;margin-left:10px ">Удалить</a>').click(function(){$(this).parent().remove();update_contacts();})
        sel.val(a[0]);
        opt.val(a[1]);
        DIV.append($('<div />').append(sel).append(opt).append(x));
        sel.fcselect({'width':'150px'})
    }
    var a = $('<a href="#add-contact" id="add-contact">Добавить контакт</a>').click(function(){
        var sel = $($('#SEL').html()).change(function(){update_contacts();});
        var opt = $('<input />').attr({'type':'text'}).css({'position':'relative','top':'-3px','width':'243px','margin-left':'5px'}).change(function(){update_contacts();})
        var x = $('<a class="delete" title="Удалить" style="cursor: pointer; margin-left:10px">Удалить</a>').click(function(){$(this).parent().remove();update_contacts();})
        DIV.append($('<div />').append(sel).append(opt).append(x));
        sel.fcselect({'width':'150px'})
        return false;
    })
    $('<div class="field buttons"></div>').append(a).insertAfter(DIV);
    /////////////////////////////////////////////////
    // DRAW A MAP
    /////////////////////////////////////////////////
    $('#map').height(427).width(427);
    $.getScript('//www.google.com/jsapi', function(G){
        google.load('maps','3',{other_params:'sensor=false','callback':function(){
                map = new google.maps.Map(document.getElementById("map"),{
                    zoom: 13,
                    center: new google.maps.LatLng(-34.397, 150.644),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                //$('#placemarks').css('display','none');
                var lat = $('#Office_lat').val();
                var lng = $('#Office_long').val();
                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng);
                  });
                if(!!lat && !!lng){
                    var loc = new google.maps.LatLng(lat, lng);
                    console.log(lat,lng)
                    map.setCenter(loc, 13);
                    placeMarker(loc)
                }else{
                    // Try W3C Geolocation (Preferred)
                    if(navigator.geolocation) {
                      navigator.geolocation.getCurrentPosition(function(position) {
                        map.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude),13);
                      }, function() {
                        handleNoGeolocation();
                      });
                    }
                    // Browser doesn't support Geolocation
                    else {
                      handleNoGeolocation();
                    }
                }
                $('#map_holder').html('').append($('#map'));
            }
        })
    }).error(function(){$('#map').html('<div class="error">Ошибка загрузки карты. Попробуйте позднее.</div>');$('#map_holder').html('').append($('#map'));});
    
    $('#facecom-tabs').fctabs();
    
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
        $.ajax({url:'/my/cities',data:{cid:cid},success:function(m){
            for(i in m){
                cities.append(
                    $('<option />').html(m[i])
                );
            }
            cities.attr({'disabled':false});
            cities.children(':contains("'+cities.data('city')+'")').attr({'selected':true});
            loading.remove();
            /*if(cities.parent().hasClass('select')){
                var p = cities.parent();
                cities.insertAfter(p);
                p.remove();
            }*/
            if(cities.data('fcselect') == null)
                cities.fcselect({width:424});
            else{
                cities.data('fcselect').destroy();
                cities.fcselect({width:424});
            }
        },dataType:'json',cache:true})
    })
    cityInit();
    
    $('input[type="text"]').each(function(){if(!!$(this).attr('title')) {$(this).tipTip();}})
})
function cityInit(el){
    if(typeof el == 'undefined' || el == null){
        $('.country_id').each(function(i){
            var cit = $($(this).attr('for'));
            var val = cit.val();
            var id = cit.attr('id');
            cit.replaceWith($('<select />').attr({'class':'city_id','id':id,'name':cit.attr('name')}).data('city',val)).fcselect({width:424});
            $(this).change();
        })
    }else{
        var cit = $(el.attr('for'));
        var val = cit.val();
        var id = cit.attr('id');
        cit.replaceWith($('<select />').attr({'class':'city_id','id':id,'name':cit.attr('name')}).data('city',val)).fcselect({width:424});
        el.change();
    }
}
