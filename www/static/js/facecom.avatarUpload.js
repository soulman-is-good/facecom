$(function(){
    /**
     * Browse photos and albums for an image
     */
    /**
     * Change background and avatar logic
     * @uses wnd.js by Rustem
     */
    $('[facecom="crop"]').click(function(){
        var href = $(this).attr('href');
        var aspect = $(this)[0].hasAttribute('aspect')?$(this).attr('aspect'):0;
        var fixed = $(this)[0].hasAttribute('fixedSize');
        var previewSize = $(this)[0].hasAttribute('preview')?[$(this).attr('preview'),$(this).attr('preview')*aspect]:[192,192];
        var title = $(this).attr('wtitle');
        var wbutton_label = $(this).attr('wbutton');
        var div = $('<div />').attr('id','profile_avatar');
        var menu = $('<div />').addClass('fc-avatar-menu');
        var imageSet = function(){
            $('#fc-avatar-computer').css('display','block');$('#fc-avatar-gallery').css('display','none');
            menu.parent().remove();
            var img = $(this);
            var width = 0, height = 0, x = 0, y = 0, src_image = $(this).attr('src');
            $('#fc-avatar-computer form').remove();
            $('#fc-avatar-computer .loader').css('display','none');
            //INSTALL PHOTO
            $('#fc-avatar-install').bind('click',function(){
                $(this).attr('disabled',true);
                $('#fc-avatar-computer').find('.loader').css('display','block');
                $.post(href,{
                    width:width,
                    height:height,
                    left:x,
                    top:y,
                    image:src_image
                },function(m){
                    if(m==null) return false;
                    if(m.status == 'OK'){
                        location.reload();
                    }else if(m.status == 'ERROR'){
                        $(this).attr('disabled',false);
                        $('#fc-avatar-computer .loader').css('display','none');
                        $.alert(m.message,'Ошибка!');
                    }
                },'json')
            });
            if(previewSize[1] > 0) {
                var previewBar = $('<div />').css({
                    'float':'right',
                    'height':'528px'
                });
                //big preview
                $('<div style="padding:0 5px 5px"><div style="overflow:hidden;width:'+previewSize[1]+'px;height:'+previewSize[0]+'px;"><img src="'+src_image+'" id="preview" /></div></div>')
                .appendTo(previewBar).css({
                    'background':'#fff',
                    'width' : previewSize[1] + 'px',
                    'height' : previewSize[0] + 'px'
                });
                //middle preview
                $('<div style="padding:5px"><div style="overflow:hidden;width:80px;height:80px;"><img src="'+src_image+'" id="preview1" /></div></div>')
                .appendTo(previewBar).css({
                    'float':'left',
                    'background':'#fff',
                    'width' : '80px',
                    'height' : '80px'
                });
                //small preview
                $('<div style="padding:5px"><div style="overflow:hidden;width:48px;height:48px;"><img src="'+src_image+'" id="preview2" /></div></div>')
                .appendTo(previewBar).css({
                    'float':'left',
                    'background':'#fff',
                    'width' : '48px',
                    'height' : '48px'
                });
                //tiny preview
                $('<div style="padding:5px"><div style="overflow:hidden;width:32px;height:32px;"><img src="'+src_image+'" id="preview3" /></div></div>')
                .appendTo(previewBar).css({
                    'float':'left',
                    'background':'#fff',
                    'width' : '32px',
                    'height' : '32px'
                });
                previewBar.appendTo($('#fc-avatar-computer'));
            }
            $(this).appendTo($('#fc-avatar-computer')).attr({
                width:$(this).width(),
                height:$(this).height()
                });
            width = $(this).width();
            height = $(this).height();
            $(this).Jcrop({cornerHandles:true,
                onChange: function(coords){
                    if(previewSize[1] == 0) return false;
                    var rx = previewSize[0] / coords.w;
                    var ry = previewSize[1] / coords.h;
                    x = Math.round(rx * coords.x);
                    y = Math.round(ry * coords.y);
                    var rw = width = Math.round(rx * img.width());
                    var rh = height= Math.round(ry * img.height());
                    $('#preview').css({
                        width: width + 'px',
                        height: height + 'px',
                        marginLeft: '-' + x + 'px',
                        marginTop: '-' + y + 'px'
                    });
                    //preview1
                    rx = 80 / coords.w;rw = Math.round(rx * img.width());
                    ry = 80 / coords.h;rh = Math.round(ry * img.height());
                    $('#preview1').css({width: rw + 'px',height: rh + 'px',marginLeft: '-' + Math.round(rx * coords.x) + 'px',marginTop: '-' + Math.round(ry * coords.y) + 'px'});
                    //preview2
                    rx = 48 / coords.w;rw = Math.round(rx * img.width());
                    ry = 48 / coords.h;rh = Math.round(ry * img.height());
                    $('#preview2').css({width: rw + 'px',height: rh + 'px',marginLeft: '-' + Math.round(rx * coords.x) + 'px',marginTop: '-' + Math.round(ry * coords.y) + 'px'});
                    //preview3
                    rx = 32 / coords.w;rw = Math.round(rx * img.width());
                    ry = 32 / coords.h;rh = Math.round(ry * img.height());
                    $('#preview3').css({width: rw + 'px',height: rh + 'px',marginLeft: '-' + Math.round(rx * coords.x) + 'px',marginTop: '-' + Math.round(ry * coords.y) + 'px'});                    
                    if(width>0 && height>0 && width<190 && height<190)
                        $('#fc-avatar-install').attr('disabled',false);
                    else
                        $('#fc-avatar-install').attr('disabled',true);
                },
                onSelect: function(coords){
                    if(previewSize[1] == 0) return false;
                    var rx = x = previewSize[0] / coords.w;
                    var ry = y = previewSize[1] / coords.h;
                    x = Math.round(rx * coords.x);
                    y = Math.round(ry * coords.y);
                    var rw = width = Math.round(rx * img.width());
                    var rh = height= Math.round(ry * img.height());
                    $('#preview').css({
                        width: width + 'px',
                        height: height + 'px',
                        marginLeft: '-' + x + 'px',
                        marginTop: '-' + y + 'px'
                    });
                    //preview1
                    rx = 80 / coords.w;rw = Math.round(rx * img.width());
                    ry = 80 / coords.h;rh = Math.round(ry * img.height());
                    $('#preview1').css({width: rw + 'px',height: rh + 'px',marginLeft: '-' + Math.round(rx * coords.x) + 'px',marginTop: '-' + Math.round(ry * coords.y) + 'px'});
                    //preview2
                    rx = 48 / coords.w;rw = Math.round(rx * img.width());
                    ry = 48 / coords.h;rh = Math.round(ry * img.height());
                    $('#preview2').css({width: rw + 'px',height: rh + 'px',marginLeft: '-' + Math.round(rx * coords.x) + 'px',marginTop: '-' + Math.round(ry * coords.y) + 'px'});
                    //preview3
                    rx = 32 / coords.w;rw = Math.round(rx * img.width());
                    ry = 32 / coords.h;rh = Math.round(ry * img.height());
                    $('#preview3').css({width: rw + 'px',height: rh + 'px',marginLeft: '-' + Math.round(rx * coords.x) + 'px',marginTop: '-' + Math.round(ry * coords.y) + 'px'});
                    if(width>0 && height>0 && width<600 && height<600)
                        $('#fc-avatar-install').attr('disabled',false);
                    else
                        $('#fc-avatar-install').attr('disabled',true);                                    
                },
                aspectRatio:aspect,
                allowResize:fixed
            })

        }
        if(typeof href == 'undefined')
            return false;
        if(typeof title == 'undefined')
            title = 'Выберите фото';
        if(typeof wbutton_label == 'undefined')
            wbutton_label = 'Установить как фото профиля';
        menu.append($('<div />').append(
            $('<a href="#computer" />').addClass('active').html('С компьютера').click(function(){
                if($(this).hasClass('active')) return false;
                menu.find('.active').removeClass('active');
                $(this).addClass('active');
                $('#fc-avatar-gallery').css('display','none');
                $('#fc-avatar-computer').css('display','block');
                return false;
            })
            )
        );
        menu.append($('<div />').append(
            $('<a href="#gallery" />').html('Из моих фото').click(function(){
                if($(this).hasClass('active')) return false;
                menu.find('.active').removeClass('active');
                $(this).addClass('active');
                $('#fc-avatar-gallery').css('display','block');
                $('#fc-avatar-computer').css('display','none');
                return false;
            })
            )
        );
        var tabs = $('<div />');
        tabs.append(
            $('<div />').attr({
                'id':'fc-avatar-computer'
            }).css({
                'position':'relative',
                'height':'528px',
                'vertical-align':'center'
            })
            .append($('<div />').addClass('loader').css({
                'position':'absolute',
                'left':'0px',
                'top':'0',
                'width':'100%',
                'display':'none',
                'background':'url(/static/css/loader01.gif) no-repeat 50% 50% #FFF',
                'height':'528px',
                'z-index':'310',
                'opacity':'0.9'
            }))
            .append($('<form method="post" action="'+href+'?ajax" enctype="multipart/form-data" target="fc-avatar-upload" style="position:relative;top:50%;margin-top:-12px" />').append(
                $('<iframe name="fc-avatar-upload" id="fc-avatar-upload" style="position:absolute;left:-1000px;top:-1000px;visibility:hidden"></iframe>').load(function(){
                    var image = $(this).contents().find('body').html();
                    var json = undefined;
                    if(image != '')
                        json = eval('(' + image + ')');
                    if(typeof json  == 'object' && json.status == 'OK'){
                        image = json.message;
                        if(href.indexOf('editBackground')!==-1)
                            return userBackgroundHandle.call(self,'/images/cover/'+image,href);
                        var img = $('<img />');
                        img.load(imageSet).attr('src','/images/edit_avatar/'+image);
                    }
                    else{
                        $('#fc-avatar-computer').find('.loader').css('display','none');
                        //Error loading image.
                        if(typeof json != 'object' && image!=''){
                            $.alert('Загрузка не удалась, попробуйте позднее.</br>Приносим свои извенения за временные неудобства!','Ошибка сервера!')
                        }else if(typeof json == 'object'){
                            $.alert(json.message,'Ошибка при загрузке файла!')
                        }
                    }
                })
                )
            //FILE FIELD
            .append($('<input name="avatar" type="file" style="font-size:20px;position:relative;z-index:1;opacity:0;cursor:pointer" />').change(function(){
                $(this).siblings('[type="submit"]').click();
            }))
            //SUBMIT BUTTON
            .append($('<input />').attr({
                'type':'submit',
                'value':'Выберите файл на компьютере'
            })
            .css({
                'position':'absolute',
                'left':'50%',
                'margin-left':'-150px',
                'width':'300px',
                'top':'0',
                'z-index':'0'
            }).click(function(){
                $('#fc-avatar-computer').find('.loader').css('display','block');
            })))
            );
        tabs.append(
            $('<div />').attr({
                'id':'fc-avatar-gallery'
            }).css({
                'display':'none'
            }).append($.facecomGallery({multiselect:false,path:'/images/',thumbsName:'small',rememberSelection:false,
                check:function(item,ui){
                    if(href.indexOf('editBackground')===-1) return true;
                    var img = new Image();
                    /*$(img).load(function(){
                        ui.css('visibility','visible');
                        if(img.width<962 || img.height<250){
                            ui.append($('<div />').css({
                                'width':'155px',
                                'height':'87px',
                                'padding-top':'68px',
                                'background':'rgba(95,95,95,0.8)',
                                'position':'absolute',
                                'left':'0px',
                                'top':'0px',
                                'z-index':'10',
                                'font':'11px Tahoma, sans-serif',
                                'text-align':'center',
                                'color':'#fff'
                            }).html('меньше чем 962х250')).unbind('click').bind('click',function(){
                                $.alert('Не получится загрузить эту фотографию, она меньше чем 962х250 пикселей')
                            })
                        }
                    }).attr('src',this.getPath()+'cover/'+item.filename+'.'+item.file_ext);
                    ui.css('visibility','hidden');*/
                    return true;
                },
                select:function(item){
                        $.facecomGallery[0].loading();
                        if(href.indexOf('editBackground')!==-1){                            
                            userBackgroundHandle.call(this,'/images/cover/' + item.filename,href);
                        }else{                            
//                            $.post('/my/resize',{'image':'upload/photos/' + item.filename,'type':'avatar'},function(m){
//                                if(m!=null && m.status == 'OK'){
                                    $('<img />').load(imageSet).attr('src','/images/edit_avatar/' + item.filename);
                                    $.facecomGallery[0].destroy();
//                                }else{
//                                    $.facecomGallery[0].loading();
//                                    $.alert(m.message);
//                                }
//                            },'json').error(function(){
//                                    $.facecomGallery[0].loading();
//                                    $.alert('Ошибка загрузки фото.');
//                            })
                        }
                }}).content().css({'height':'518px','overflow':'auto','overflow-x':'hidden'}))
            );
        div.append(
            $('<table />').attr({
                'width':'100%',
                'cellspacing':'0',
                'cellpadding':'0'
            }).css({
                'height':'558px'
            }).append(
                $('<tr />')
                .append(
                    $('<td />').attr({
                        'width':'190',
                        'style':'vertical-align:top;padding:15px;border-right:1px solid #E1E1E1'
                    }).append(menu)
                    ).append(
                    $('<td />').attr({
                        'style':'padding:15px;text-align:center'
                    }).append(tabs)
                    )
                )
            );
        var buttons = $('<div />');
        var rwn = div.rusWindow({
            modal:true,
            title:title,
            width:895,
            height:690,
            'footer':buttons
        });
        buttons.append($('<input id="fc-avatar-install" type="button" value="'+wbutton_label+'" disabled="disabled" />'))
        .append($('<input type="button" value="Отменить" style="margin-left:15px" />').click(function(){
            rwn.close();
        }));
        $(rwn.object).find('.wnd_content').css('padding','0')
        return false;
    })
})

function userBackgroundHandle(image,href){
    var ifile = image;
    image = ifile.split('/').pop();
    var img = $('<img />');
    var left = 0;
    var top = 0;
    var dx = 0, ddx = 0;
    var dy = 0, ddy = 0;
    var left_limit = 0; // limit image shifting
    var top_limit = 0; 
    var dragging = false;
    var updateImagePosition = function(x,y){
        img.css({
            'margin-left':-x+'px',
            'margin-top':-y+'px'
        })
    }
    img.css('cursor','pointer').load(function(){
        //hiding avatar. It is not nicelooking cutted half by background image overlayed
        $('.userBG .avatar').fadeOut();
        var min_scale = (1- 962/img[0].width)*100;
        var tmp = (1- 250/img[0].height)*100;
        if(tmp<min_scale) min_scale = tmp;
        var raw_height = img[0].height;
        var raw_width = img[0].width;
        var window_left = 0;
        var div = $('<div />');
        var dragarea = $('<div />')
        .css({
            'overflow':'hidden',
            'width':'962px',
            'height':'250px',
            'box-shadow':'0 0 15px 0px #000'
        })
        .append(img);
        var handle = $('<div />').addClass('handle').css({
            'position':'absolute',
            'top':'50%',
            'left':'50%',
            'margin-left':'-125px',
            'margin-top':'-12px',
            'background':'rgba(0,0,0,0.8)',
            'color':'#FFF',
            'font-weight':'bold',
            'width':'250px',
            'padding':'5px',
            'border-radius':'5px',
            'text-align':'center',
            'cursor':'pointer'
        }).append('Зажмите и перетащите');
        div.append(handle);
        var mousedown = function(e){
            if(!$(e.target).hasClass('handle') && e.target.tagName != 'IMG') return false;
            e.preventDefault();
            e.stopPropagation();
            dx = e.clientX;
            dy = e.clientY;
            dragging = true;
        }
        var mousemove = function(e){
            e.preventDefault();
            e.stopPropagation();
            ddx = e.clientX - dx - left;
            ddy = e.clientY - dy - top;
            if(ddx>0) ddx=0;
            if(ddy>0) ddy=0;
            if(ddx<left_limit) ddx=left_limit;
            if(ddy<top_limit) ddy=top_limit;
            if(dragging){
                if(handle.is(':visible')){
                    //scaler.fadeOut();//animate({'opacity':'0'})
                    handle.fadeOut();
                }
                updateImagePosition(-ddx,-ddy);
            }
        }
        var mouseup = function(e){
            if(dragging){   
                left = Math.abs(ddx);
                top = Math.abs(ddy);
                dx=ddx=0;
                dy=ddy=0;
                //scaler.fadeIn();//animate({'opacity':'0.9'});
                //handle.fadeIn();
            }
            dragging = false;
        };
        $(document).bind('mousedown',mousedown).bind('mousemove',mousemove).bind('mouseup',mouseup);
        var xhr = null;
        var ok_button = $('<button />').attr({'type':'button','class':'blue'}).html('Готово').css({'float':'right'}).fcbutton().click(function(){
            xhr = $.post(href,{
                left:left,
                top:top,
                width:img.width(),
                height:img.height(),
                image:ifile
            },function(m){
                if(m.status == 'OK'){
                    $('.userCover').css({
                        'background-image':'url(/images/cover/'+m.message+'?'+Math.random()*100+')',
                        'background-position':'-'+left+'px -'+top+'px'
                    });
                    rwnd.close();
                    $('.userBG .avatar').fadeIn();
                    $(document).unbind('mousedown',mousedown).unbind('mousemove',mousemove).unbind('mouseup',mouseup);
                }
            },'json')
        });
        //CLOSE EDIT WINDOW
        var cancel_button = $('<input />').attr({'type':'button','value':'Отмена'}).css({'float':'right','margin':'0 10px'}).click(function(){
            $('.userBG .avatar').fadeIn();
            $(document).unbind('mousedown',mousedown).unbind('mousemove',mousemove).unbind('mouseup',mouseup);
            if(xhr!=null)
                xhr.abort();
            rwnd.close();
        });
        var scaler = $('<div />').attr({'title':'Масштаб'}).css({
            'position':'absolute',
            'left':'20px',
            'top':'20px',
            'height':'5px',
            'width':'220px',
            'opacity':'0.9'
        }).slider({
            min:-min_scale,
            max:100,
            value:0,
            slide:function(e,ui){
                var r = ui.value/100;
                var w = raw_width, W;
                var h = raw_height,H;
                W = w + w*r;
                H = h + h*r;
                if(W>=962 && H>=250){   
                    var rx = left = W*left/img.width(), ry = top = H*top/img.height();
                    left_limit = 961 - W;
                    top_limit = 250 - H; 
                    if(W-rx<962) rx = W - 962;if(H-ry<250) ry = H - 250;
                    img.css({'margin-top':'-'+ry+'px','margin-left':'-'+rx+'px'})
                    img.width(W).height(H);
                }
            }
        });
        div.append(dragarea).append($('<div />').css({'position':'absolute','bottom':'-52px','padding':'10px 0','width':'100%','background':'rgba(0,0,0,0.5)'})
            .append(scaler).append(cancel_button).append(ok_button));
        //Create window
        var rwnd = new wnd(div,true,962,250,false);
        div.parent().css({'left':'50%','margin-left':'-481px','top':'128px'})
        left_limit = 961 - img.width();
        top_limit = 250 - img.height(); 
        window_left = div.parent().position().left;
        $.rusWindows['#profile_avatar'].close();
    }).attr('src',ifile);
}