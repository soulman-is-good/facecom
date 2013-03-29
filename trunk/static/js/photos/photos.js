var geocoder = null;
var map = null;
function loadMorePhotos(obj, album_id){
    button = $(obj);
    if(button.hasClass('loadMoreBusy'))
        return;
    button.addClass('loadMoreBusy');
    offset = $('#loadMoreOffset').val();
    $.post('/id'+glUserId+'/aphotos/more/', 'offset='+offset+'&album_id='+album_id, function(data){
        $('.pv_list_fl').append(data.data);
        $('#loadMoreOffset').val(parseInt(offset)+data.photos_count);
        if(data.photos_count < 20)
            button.remove();
        else
            button.removeClass('loadMoreBusy');
    }, 'json');
}
//для закладок
function loadMoreBookmarkPhotos(obj){
    button = $(obj);
    if(button.hasClass('loadMoreBusy'))
        return;
    button.addClass('loadMoreBusy');
    offset = $('#loadMoreOffset').val();
    $.post('/id'+glUserId+'/bookmarks/more/', 'offset='+offset, function(data){
        $('.pv_list_fl').append(data.data);
        $('#loadMoreOffset').val(parseInt(offset)+data.photos_count);
        if(data.photos_count < 20)
            button.remove();
        else
            button.removeClass('loadMoreBusy');
    }, 'json');
}

function loadNavPhoto(objwnd,addr){
    objwnd.ajaxLoad(addr,'',function(data){

        $('.viewPhoto .navigation').click(function(){
            loadNavPhoto(objwnd,$(this).attr('href'));
            return false;
        });

        $('#photo_comments_form textarea[name="text"]').live('keydown',function(e){
            if (e.ctrlKey && e.keyCode == 13) {
                $('#photo_comments_form').submit();
            }
        })

        $('#photo_comments_form').live('submit',function(){
            $(this).find('textarea[name="text"]').val('');
            $(this).find('textarea[name="text"]').focus();
            $("#commentsScroll").data('jsp').scrollToY($('#commentsScroll .commentsContainer').height());
        })

        $('.edit_photo_link').click(function(){
            EdPhWnd=new wnd(null,true);
            EdPhWnd.setRelativePosition('center');
            EdPhWnd.setTitle('Описание фото');
            EdPhWnd.setZindex(700);
            photo_id = $(this).attr('rel');
            EdPhWnd.ajaxLoad($(this).attr('href'),'',function(ed_data){
                $('#form_edit_photo_'+photo_id).submit(function(){
                    $.post($(this).attr('action'), $(this).serialize(), function (data){
                        if(data.status=='ok')
                            $('.viewPhoto .description').html(data.data);
                        EdPhWnd.close();
                    }, 'json');
                    return false;
                })
            });

        });

        $('.set_poster_photo_link').click(function(){
            SetPosetrWnd=new wnd(null,true);
            SetPosetrWnd.setRelativePosition('center');
            SetPosetrWnd.setZindex(700);
            photo_id=$(this).attr('rel');
            SetPosetrWnd.ajaxLoad($(this).attr('href'),'',function(data){
                data = JSON.parse(data);
                $('.photo_controll_links').css('display','none');
                $('.photo_controll').append('<div class="photo_controll_status">Готово</div>');
                setTimeout(function(){
                    $('.photo_controll_status').remove();
                    $('.photo_controll_links').css('display','block');
                },1500);
                SetPosetrWnd.close();
            }, true)
            return false;
        });

        $('.delete_photo_link').click(function(){
            SetDeleteWnd=new wnd(null,true);
            SetDeleteWnd.setRelativePosition('center');
            SetDeleteWnd.setZindex(700);
            link = $(this);
            SetDeleteWnd.ajaxLoad($(this).attr('href'),'',function(data){
                data = JSON.parse(data);

                if(data.status == 'ok')
                {
                    $('#pw_list_item_open_'+link.attr('rel')).remove();
                    SetDeleteWnd.close();
                    link.parents('.photo_controll').html('Фото удалено');

                    if(data.count == 0)
                        location.href = '/id'+glUserId+'/photos';
                    /*else
                        loadNavPhoto(objwnd, link.attr('next'));
                    */
                }
                else
                {
                    SetDeleteWnd.setContent('<div class="wnd_error">Ошибка</div>');
                }
            }, true);
            return false;
        });

        $('.delete_bookmark_link').click(function(){

        	if($(this).attr('stat')=='1'){
        		$.post(
            		$('.delete_bookmark_link').attr('href'),
            		{mid:$('.delete_bookmark_link').attr('rel'),ajax:'ajax'},
            		function(data)
            		{
            			if(data.status=='ok'){
            				$('.delete_bookmark_link').html('вернуть в закладки');
            				$('.delete_bookmark_link').attr('stat','2');
            			}
            		},
            		'json'
            	);
            }else{
        		$.post(
            		$('.delete_bookmark_link').attr('adhr'),
            		{mid:$('.delete_bookmark_link').attr('rel'),ajax:'ajax'},
            		function(data)
            		{
            			if(data.status=='ok'){
            				$('.delete_bookmark_link').html('убрать из закладок');
            				$('.delete_bookmark_link').attr('stat','1');
            			}
            		},
            		'json'
            	);
            }
            return false;
        });
        $('#commentsScroll').jScrollPane({'autoReinitialise':'true','stickToBottom':'true','animate':'true'});
        if(typeof $('.photo_controll_links').data('lat') != 'undefined'){
            var latlng = new google.maps.LatLng($('.photo_controll_links').data('lat'),$('.photo_controll_links').data('long'));
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  if (results[1]) {
                      $('.photo_controll_links .map-pos').html(results[1].formatted_address)
                  }
                }
            })
        }
    });
}

$(document).ready(function(){
    $('.uploadLinkWithButton').live('mousedown',function(){
        if (navigator.userAgent.indexOf('MSIE')!= -1)
        {
            $(this).children('input[type="file"]').click();
        }
    })

    $('#addPhotoBtn').click(function(){
        mywnd=new wnd(null,true,837);
        mywnd.setTitle('Загружайте фотографии и делитесь ими');
        mywnd.setRelativePosition('center');
        mywnd.ajaxLoad('/id'+glUserId+'/aphotos/add/'+$(this).attr('album'),'',function(data){
            prepare_uploader();
        });
    });

    $('.pw_list_item_open a').live('click',function(){
        mywnd=new wnd(null,true);
        mywnd.setRelativePosition('center');
        loadNavPhoto(mywnd,$(this).attr('href'));

        return false;
    });



    $('.edit_album_link').click(function(){
        edAlWnd = new wnd(null,true);
        edAlWnd.setRelativePosition('center');
        edAlWnd.setTitle('Название альбома');
        edAlWnd.ajaxLoad($(this).attr('href'));
        return false;
    })

    $('.delete_album_link').click(function(){
        delAlWnd = new wnd(null,true);
        delAlWnd.setRelativePosition('center');
        link = $(this);
        delAlWnd.ajaxLoad(link.attr('href'),'',function(){
            link.parents('.pw_list_item').remove();
            delAlWnd.setContent('<div class="wnd_done" align="center">Удалено</div>');
            delAlWnd.closeTimeOut(500);
        }, true);
        return false;
    })

    $('.change_album_set a').live('click',function(){
        if($(this).parents('.album_name').children('.album_set').attr('value')==0){
            $(this).parents('.album_name').children('.album_set').attr('value',1);
            $(this).parents('.album_name').children('.album_select').children('.can_create_album').css('display','block');
            $(this).parents('.album_name').children('.album_select').children('.can_select_album').css('display','none');
            $(this).parents('.change_album_set').children('.album_create_set').css('display','none');
            $(this).parents('.change_album_set').children('.album_select_set').css('display','block');
        }else{
            $(this).parents('.album_name').children('.album_set').attr('value',0);
            $(this).parents('.album_name').children('.album_select').children('.can_create_album').css('display','none');
            $(this).parents('.album_name').children('.album_select').children('.can_select_album').css('display','block');
            $(this).parents('.change_album_set').children('.album_create_set').css('display','block');
            $(this).parents('.change_album_set').children('.album_select_set').css('display','none');
        }
        return false;
    });
    
    /////////////////////////////////////////
    //GOOGLE MAPS
    /////////////////////////////////////////
    $.getScript('//www.google.com/jsapi', function(G){
        google.load('maps','3',{other_params:'sensor=false','callback':function(){
                geocoder = new google.maps.Geocoder();
                var id = parseInt(location.hash.replace('#',''));
                if(!isNaN(id)){
                    $('a[href$="show/'+id+'"]').click();
                }
                $('.map-pos').live('click',function(){
                    var place = null;
                    var w = 2*$(window).width()/3;
                    var h = 4*$(window).height()/5;
                    var rus = null;
                    var aa = $(this);
                    var footer = $('<h1/>').append($('<button />').html('Сохранить').attr({'type':'button'}).click(function(){
                        var lat = place.getPosition().lat();
                        var lng = place.getPosition().lng();
                        aa.parent().data({'lat':lat,'long':lng});
                        $.get('/placemarks/save',{pid:aa.attr('rel'),lng:lng,lat:lat,zoom:map.getZoom()})
                        geocoder.geocode({'latLng': place.getPosition()}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                              if (results[1]) {
                                  $('.photo_controll_links .map-pos').html(results[1].formatted_address)
                              }
                            }
                        })
                        place = null;
                        rus.close();
                    }))
                    rus = $('<div />').attr('id','map').width(w-40).height(h).rusWindow({title:'Выберите место на карте где было сделано фото',modal:true,width:w,height:h+20,footer:footer});
                    map = new google.maps.Map(rus.getContent().find('#map').get(0),{
                        zoom: 13,
                        center: new google.maps.LatLng(-34.397, 150.644),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    if(typeof aa.parent().data('lat') == 'undefined'){
                        $.getScript('//api-maps.yandex.ru/2.0-stable/?lang=ru-RU&coordorder=longlat&load=package.map',function(){
                            ymaps.ready(function(){
                                map.setCenter(new google.maps.LatLng(ymaps.geolocation.latitude, ymaps.geolocation.longitude),13);
                            })
                        })
                    }else{
                        var latLng = new google.maps.LatLng(aa.parent().data('lat'), aa.parent().data('long'));
                        map.setCenter(latLng,aa.parent().data('zoom'));
                        place = new google.maps.Marker({
                                position: latLng,
                                map: map
                            });
                    }
                    google.maps.event.addListener(map, 'click', function(e){
                        if(place!=null){
                            place.setPosition(e.latLng);
                        }else
                            place = new google.maps.Marker({
                                position: e.latLng,
                                map: map
                            });
                    })
                })
            }
        })
    })
    /////////////////////////////////////////
})
