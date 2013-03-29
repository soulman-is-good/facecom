/**
 * jQuery textarea autosize plugin. Fits textarea height to a content;
 * @usage jQuery('textarea').autosize();
 * @param callback function when textarea is resized
 * @param animate boolean default=true
 * @param class string default='autosizejs'
 * @param append string what to append... (wtf)
 */
(function(a){var j={className:"autosizejs",append:"",callback:!1},k="hidden",g="fontFamily fontSize fontWeight fontStyle letterSpacing textTransform wordSpacing textIndent".split(" "),f=a('<textarea tabindex="-1" style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden;"/>')[0];f.setAttribute("oninput","return"); a.isFunction(f.oninput)||"onpropertychange"in f?(a(f).css("lineHeight","99px"),"99px"===a(f).css("lineHeight")&&g.push("lineHeight"),a.fn.autosize=function(h){h=a.extend({},j,h||{});return this.each(function(){function d(){var a,d,g;l||(l=!0,e.value=b.value+h.append,e.style.overflowY=b.style.overflowY,g=parseInt(b.style.height,10),e.style.width=c.css("width"),e.scrollTop=0,e.scrollTop=9E4,a=e.scrollTop,d=k,a>i?(a=i,d="scroll"):a<f&&(a=f),a+=n,b.style.overflowY=d,g!==a&&(b.style.height=a+"px",q&&h.callback.call(b)), setTimeout(function(){l=!1},1))}var b=this,c=a(b),e,f=c.height(),i=parseInt(c.css("maxHeight"),10),l,m=g.length,p,n=0,j=b.value,q=a.isFunction(h.callback);if("border-box"===c.css("box-sizing")||"border-box"===c.css("-moz-box-sizing")||"border-box"===c.css("-webkit-box-sizing"))n=c.outerHeight()-c.height();if(!c.data("mirror")&&!c.data("ismirror")){e=a('<textarea tabindex="-1" style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden;"/>').data("ismirror", !0).addClass(h.className)[0];p="none"===c.css("resize")?"none":"horizontal";c.data("mirror",a(e)).css({overflow:k,overflowY:k,wordWrap:"break-word",resize:p});for(i=i&&0<i?i:9E4;m--;)e.style[g[m]]=c.css(g[m]);a("body").append(e);"onpropertychange"in b?"oninput"in b?b.oninput=b.onkeyup=d:b.onpropertychange=d:(b.oninput=d,b.value="",b.value=j);a(window).resize(d);c.bind("autosize",d);d()}})}):a.fn.autosize=function(){return this}})(jQuery);
/**
 * jQuery color animation plugin.
 * use $(div).animate({backgroundColor:'#ff0000'});
 */
(function(d){d.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(f,e){d.fx.step[e]=function(g){if(!g.colorInit){g.start=c(g.elem,e);g.end=b(g.end);g.colorInit=true}g.elem.style[e]="rgb("+[Math.max(Math.min(parseInt((g.pos*(g.end[0]-g.start[0]))+g.start[0]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[1]-g.start[1]))+g.start[1]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[2]-g.start[2]))+g.start[2]),255),0)].join(",")+")"}});function b(f){var e;if(f&&f.constructor==Array&&f.length==3){return f}if(e=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(f)){return[parseInt(e[1]),parseInt(e[2]),parseInt(e[3])]}if(e=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(f)){return[parseFloat(e[1])*2.55,parseFloat(e[2])*2.55,parseFloat(e[3])*2.55]}if(e=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(f)){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}if(e=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(f)){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}if(e=/rgba\(0, 0, 0, 0\)/.exec(f)){return a.transparent}return a[d.trim(f).toLowerCase()]}function c(g,e){var f;do{f=d.css(g,e);if(f!=""&&f!="transparent"||d.nodeName(g,"body")){break}e="backgroundColor"}while(g=g.parentNode);return b(f)}var a={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]}})(jQuery);
// i18n DUMMY
$.config = jQuery.extend( !0, {}, window.jQueryConfig && !window.jQueryConfig.nodeName ? window.jQueryConfig : undefined),
$.dependSettings = jQuery.extend({minify:!1,jsonp:!1,pluginRoot:'script'},$.config.depend);
$.dependHandle = {};
$.dependRegister = function( dependType, handle ){};
$.plugin = function(){};

/**
 * get dom element css in json
 */
$.fn.css2json = function(){

    function css(a){
        var sheets = document.styleSheets, o = {};
        for(var i in sheets) {
            var rules = sheets[i].rules || sheets[i].cssRules;
            for(var r in rules) {
                if(a.is(rules[r].selectorText)) {
                    o = $.extend(o, css2json(rules[r].style), css2json(a.attr('style')));
                }
            }
        }
        return o;
    }

    function css2json(css){
        var s = {};
        if(!css) return s;
        if(css instanceof CSSStyleDeclaration) {
            for(var i in css) {
                if((css[i]).toLowerCase) {
                    s[(css[i]).toLowerCase()] = (css[css[i]]);
                }
            }
        } else if(typeof css == "string") {
            css = css.split("; ");
            for (var i in css) {
                var l = css[i].split(": ");
                s[l[0].toLowerCase()] = (l[1]);
            };
        }
        return s;
    }

    return css($(this));
}
function floatFixedBlock(box, style1, style2) {
    $(function(){
        if(typeof box[0] == 'undefined') return false;
        var top = box.offset().top - parseFloat(box.css('marginTop').replace(/auto/, 0));

        $(window).scroll(function(){
            var windowpos = $(window).scrollTop();

            if (windowpos < top-20) {
                box.css(style1);
            } else {
                box.css(style2);
            }
        });
    });
}

// Лайк\унлайк
function _like(obj, url, tbl, item_id) {
    $.post(url, {
        _tbl: tbl,
        _item_id: item_id
    }, function(data){
        if (data.data == 'like') {
            _val = parseInt($(obj).parent().children('.likeCount').text(), 10);
            _val = _val + 1;
            $(obj).parent().children('.likeCount').text(_val)
        }
        else {
            _val = parseInt($(obj).parent().children('.likeCount').text(), 10);
            _val = _val - 1;
            $(obj).parent().children('.likeCount').text(_val)
        }
    }, 'json')
}

// Share - добавить себе
function _share(obj, url, _item_id) {
    $.post(url, {
        item_id: _item_id
    }, function(data){
        if (data.data == 'shared') {
            _val = parseInt($(obj).parent().children('.shareCount').text(), 10);
            _val = _val + 1;
            $(obj).parent().children('.shareCount').text(_val)
        }
        else {
            $.alert(data.data)
        }
    }, 'json')
}

// показать текст полностью
function showFull(obj) {
    $(obj).parent().children('.shortText').hide();
    $(obj).parent().children('.fullText').show();
    $(obj).remove();
}

$(window).load(function(){
    if($('.chatScroll').length>0)
        $('.chatScroll').jScrollPane();
})
var chatAbsolute = {
        'position': 'absolute',
        'top': '60px',
        'right': -250,
        'left': 'auto'
    };
var chatFixed = {
        'position': 'fixed',
        'top': '20px',
        'z-index':20
        };

$(document).ready(function(){
    chatFixed.left = ($('.main').offset().left)+($('.main').width())+20;
    //alert(location.hash);
    if($('.chatScroll').length>0)
        $('.chatScroll').jScrollPane();

    var winWindth = $(window).width();


    $(window).resize(function(){
        winWindth = $(this).width();
    	/*if($(this).width()<1000){
            if(!chatFixed.hasOwnProperty('bottom')){
                window.tmpChatAbsolute = chatAbsolute;
                chatFixed.left = 'auto';
                chatFixed.top = 'auto';
                chatFixed.right = '10px';
                chatFixed.bottom = '10px';
                chatFixed['box-shadow'] = '0 0 5px #ccc';
                chatAbsolute = chatFixed;
                floatFixedBlock($('.chat'), chatAbsolute, chatFixed);
                $('.chat .usersListContainer').css({'position':'absolute','bottom':'39px','border-top':'none','border-bottom':'1px solid #FFFFFF','left':'-99999px','box-shadow':'0 -7px 5px #ccc'});
                $('.chat .usersListContainer').hover(function(){$('.chat .usersListContainer').css('left','0px')},function(){$('.chat .usersListContainer').css('left','-99999px')})
                $('.chat .title').hover(function(){$('.chat .usersListContainer').css('left','0px')},function(){$('.chat .usersListContainer').css('left','-99999px')})
            }
        }else {
            if(chatFixed.hasOwnProperty('bottom')){
                $('.chat').removeAttr('style');
                chatFixed.left = ($('.main').offset().left)+($('.main').width())+20;
                chatFixed.top = '20px';
                chatFixed.right = 'auto';
                chatFixed.bottom = 'auto';
                delete chatFixed.right;
                delete chatFixed.bottom;
                delete chatFixed['box-shadow'];
                if(typeof window.tmpChatAbsolute != 'undefined')
                    chatAbsolute = window.tmpChatAbsolute;
                $('.chat .title').unbind('mouseenter mouseleave');
                $('.chat .usersListContainer').unbind('mouseenter mouseleave');
                $('.chat .usersListContainer').removeAttr('style');
            }
            $('.chat').css('left',($('.main').offset().left)+($('.main').width())+20);
            //floatFixedBlock($('.chat'), chatAbsolute, chatFixed);
        }*/
    })
    $(window).resize();
    // Прилизанный чат
    floatFixedBlock($('.chat'), chatAbsolute, chatFixed);

    // Прилизанное левое меню
    floatFixedBlock($('.leftMenu'), {
        'position': 'absolute',
        'top': '60px',
        'left': -80
    }, {
        'position': 'fixed',
        'top': '20px',
        'left': ($('.main').offset().left)-80
        });

    // Показать видео в модальном окне
    $('.videoList .item').click(function(){
        $('.viewVideo').arcticmodal({
            beforeOpen: function(data, el) {
                $('.viewVideo').show();
            },
            afterOpen: function(){
                $('.commentsScroll').jScrollPane();
            },
            beforeClose: function(data, el) {
                $('.viewVideo').hide();
            }
        });
    })

    $('.viewVideo .close').click(function(){
        $('.viewVideo').arcticmodal('close');
    })

    // Показать окно загрузки видео
    $('#showAddVideo').click(function(){
        $('.addVideoModal').arcticmodal({
            beforeOpen: function(data, el) {
                $('.addVideoModal').show();
            },
            beforeClose: function(data, el) {
                $('.addVideoModal').hide();
            }
        });
    })

    // Переключение между типами загрузки видео (своё или с другого сайта)
    $('.addVideoContainer .buttons span').click(function(){
        var i = $(this).index();
        $('.addVideoContainer .buttons span').removeClass('active');
        $(this).addClass('active');
        $('.addVideoContainer .bottom .container').hide();
        $('.addVideoContainer .bottom .container:eq('+i+')').show();
    })

    // Показать список фоток в модальном окне
    $('.videoList .album').click(function(){
        $('.viewPhoto').arcticmodal({
            beforeOpen: function(data, el) {
                $('.viewPhoto').show();
            },
            afterOpen: function(){
                $('.commentsScroll').jScrollPane();
            },
            beforeClose: function(data, el) {
                $('.viewPhoto').hide();
            }
        });
    })

    // Переключение фоток альбома при просмотре

    $('.viewPhoto .photo .prev').click(function(){
        var len = $('.viewPhoto .photo img').length-1;
        var current = $('.viewPhoto .photo img:visible').index('.viewPhoto .photo img');
        $('.viewPhoto .photo img').hide();

        if (current == 0) {
            $('.viewPhoto .photo img:eq('+len+')').show();
        }
        else {
            $('.viewPhoto .photo img:eq('+(current-1)+')').show();
        }
    })

    $('.viewPhoto .photo .next').click(function(){
        var len = $('.viewPhoto .photo img').length-1;
        var current = $('.viewPhoto .photo img:visible').index('.viewPhoto .photo img');
        $('.viewPhoto .photo img').hide();

        if (current == len) {
            $('.viewPhoto .photo img:eq(0)').show();
        }
        else {
            $('.viewPhoto .photo img:eq('+(current+1)+')').show();
        }
    })

    // Показать окно загрузки фото
    $('#showAddPhoto').click(function(){
        $('.addPhotoModal').arcticmodal({
            beforeOpen: function(data, el) {
                $('.addPhotoModal').show();
            },
            beforeClose: function(data, el) {
                $('.addPhotoModal').hide();
            }
        });
    })

    // Элементы управления аудио
    $('.audioList .item').hover(function(){
        $(this).find('.controls').show()
    },function(){
        $(this).find('.controls').hide()
    });

    $('.select').live('click',function(e){
        if($(e.target).attr('class')=='option'){
            $(this).children('.options').css('display','none');
            $(this).children('input[type="hidden"]').attr('value',$(e.target).attr('val'));
            $(this).children('.selected').html($(e.target).html());
        }else{
            if($(this).children('.options').css('display')=='none'){
                $(this).children('.options').css('display','block');
            }else{
                $(this).children('.options').css('display','none');
            }
        }
    });

    /**
     * Buttons logic
     */
    $.fn.fcbutton = function(){
        var self = this;
        $(this).ajaxStart(function(){
            self.loading();
        })
        $(this).ajaxStop(function(){
            self.loading();
        })
        $(this).click(function(e){
            if(this.hasAttribute('disabled')){
                e.stopPropagation();
                return false;
            }
        })
        this.loading = function(img){
            if(!img)
                img = '/static/css/loader03.gif';
            if(!!$(this).data('loading')){
                $(this).data('loading',false);
                $(this).html($(this).data('html'));
                $(this).removeAttr('disabled');
            }else{
//                $(this).css('display','inline-block');
//                $(this).width($(this).width());
//                $(this).height($(this).height());
                $(this).data('loading',true);
                $(this).data('html',$(this).html());
                $(this).attr('disabled',true);
                var i = $('<img />').attr('src',img).css({'margin-top':'5px'});
                $(this).html(i);
            }
        }
        $(this).data('fcbutton', this);
        return this;
    }
    $('.button, button').each(function(){$(this).fcbutton();});
    /**
     * returns formatted jQuery Dom of an gallery
     */
    //TODO: i18n facecomGallery
    $.facecomGallery = function(options){
        var self = this;
        var content = $('<div />').addClass('facecom-gallery');
        var selection = [];
        var ops = {
            'url':'/id11/aphotos/get_json',
            'multiselect':false,
            'rememberSelection':true,
            'path':'/upload/',
            'thumbsName':'small',
            'load':function(data){return true;},
            'select':function(item){},
            'deselect':function(item){},
            'check':function(item,ui){return true;}
        }
        ops = $.extend({},ops,options);
        var deselect = function(item) {
            for(i in selection)
                if((typeof item.id !='undefined' && item.id === selection[i].id) || (item.filename === selection[i].filename)){
                    selection.splice(i, 1);
                    break;
                }
        }
        this.getPath = function(){
            return ops.path;
        }
        this.loading = function(){
            var loader = content.find('.fcg-loader');
            if(typeof loader[0] !== 'undefined'){
                loader.width(content.width()).height(content.height());
                loader.toggle();
            }
        }
        this.destroy = function(){
            content.remove();
            selection = [];
            $.facecomGallery[0] = null;
            return true;
        }
        this.getSelection = function(){
            if(ops.multiselect)
                return selection;
            else
                return selection[0] || false;
        }
        this.content = function(){
            return content;
        }
        this.load = function(data){
            if(!ops.load.call(self,data))
                return false;
            var it = this;
            var $elf = $(this);

            this.data = data;

            this.prepare = function(){
                var ldr = $elf.find('.fcg-loader');
                $elf.find('.fcg-breadcrumbs').remove();
                $elf.find('.facecom-gallery-album').remove();
                $elf.append();
            }

            this.updateBreadcrumbs = function(aid){
                var brd = $('<div />').addClass('fcg-breadcrumbs').css({
                    'margin':'10px 0'
                });
                if(typeof aid == 'undefined'){
                    if(typeof it.data[0].album_name != 'undefined')
                        brd.append('<span>Все альбомы</span>');
                    else
                        brd.append('<span>Все фото</span>');
                }else{
                    brd.append($('<a href="#" />').click(function(){
                        it.drawAlbums();
                        return false;
                    }).html('Все альбомы'));
                    brd.append('&nbsp;&gt;&nbsp;<span>'+it.data[aid].album_name+'</span>');
                }
                $elf.append(brd);
            }

            this.drawPhotos = function(aid) {
                it.prepare();
                it.updateBreadcrumbs(aid);
                var photos = [];
                if(typeof aid == 'undefined')
                    photos = it.data;
                else
                    photos = it.data[aid].photos;
                for(i in photos){
                    var cont = $('<div />').addClass('facecom-gallery-album').addClass('fcg-photo');
                    var a = $('<a href="#" />');
                    var thumbs = $('<div />');
                    thumbs.append($('<img />').attr({
                        'src':ops.path + ops.thumbsName + '/' + photos[i].filename + '.' + photos[i].file_ext,
                        'class':'fcg-first'
                    }));
                    for(o in selection)
                        if((typeof photos[i].id !='undefined' && photos[i].id === selection[o].id) || (photos[i].filename === selection[o].filename))
                            a.addClass('fcg-selected');
                    a.append(thumbs).data('photo',photos[i]).bind('click',function(e){
                        e.stopPropagation();
                        if(!ops.multiselect && !$(this).hasClass('fcg-selected')){
                            content.find('.fcg-selected').removeClass('fcg-selected')
                            selection = [];
                        }
                        if($(this).hasClass('fcg-selected')){
                            ops.deselect.call(self,$(this).data('photo'))
                            deselect($(this).data('photo'))
                        }else{
                            selection.push($(this).data('photo'));
                            ops.select.call(self,$(this).data('photo'))
                        }
                        $(this).toggleClass('fcg-selected');
                        return false;
                    });
                    a.append("<span>"+photos[i].description+"</span>")
                    if(ops.check.call(self,photos[i],a))
                        $elf.append(cont.append(a));
                }
            }

            this.drawAlbums = function(){
                it.prepare();
                it.updateBreadcrumbs();
                if(!ops.rememberSelection)
                    selection = [];
                if(it.data.length == 0)
                    $elf.append('Вы пока что не загрузили ни одной фотографии')
                else{
                    $elf.parents('td').css({
                        'vertical-align':'top',
                        'text-align':'left'
                    });
                    for(i in it.data){
                        if(it.data[i].photos.length == 0) continue;
                        var album = it.data[i];
                        var cont = $('<div />').addClass('facecom-gallery-album');
                        var a = $('<a href="#" />');
                        var thumbs = $('<div />');
                        if(album.photos.length == 1)
                            thumbs.append($('<img />').attr({
                                'src':ops.path + ops.thumbsName + '/' + album.photos[0].filename+'.'+album.photos[0].file_ext,
                                'class':'fcg-second'
                            }));
                        else
                            thumbs.append($('<img />').attr({
                                'src':ops.path + ops.thumbsName + '/' + album.photos[0].filename+'.'+album.photos[0].file_ext,
                                'class':'fcg-first'
                            }));
                        if(typeof album.photos[1] != 'undefined')
                            thumbs.append($('<img />').attr({
                                'src':ops.path + ops.thumbsName + '/' + album.photos[1].filename+'.'+album.photos[0].file_ext,
                                'class':'fcg-third'
                            }));
                        if(typeof album.photos[2] != 'undefined')
                            thumbs.append($('<img />').attr({
                                'src':ops.path + ops.thumbsName + '/' + album.photos[2].filename+'.'+album.photos[0].file_ext,
                                'class':'fcg-second'
                            }));
                        a.append(thumbs).data('aid',i).click(function(){
                            it.drawPhotos($(this).data('aid'));
                            return false;
                        });
                        a.append("<span>"+album.album_name+"</span>")
                        $elf.append(cont.append(a));
                    }
                }
            }

            if(typeof data[0].album_name == 'undefined')
                this.drawPhotos();
            else
                this.drawAlbums();
        }
        content.append('<div class="fcg-loader">&nbsp;</div>')
        self.loading();
        $.get(ops.url,function(data){
            self.load.call(content[0],data)
            self.loading();
        },'json')
        $.facecomGallery[0] = self;
        return self;
    }

})

// Determine whether a variable is empty
function empty( mixed_var ) {
	return (mixed_var===""||mixed_var===0||mixed_var==="0"||mixed_var===null||mixed_var===false||(is_array(mixed_var)&&mixed_var.length===0)||(mixed_var === undefined));
}


//расширения стандартного типа string
//если нет метода trim (добавлен в JavaScript 1.8.1 / ECMAScript 5)
if(!String.prototype.trim) {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g,'');
  };
}

///explodeToTriads
//находит цифры и разбивает их по триадам
//TODO исправить регулярку на корректное понимания десятичного разделителя
String.prototype.triadDigits=function(){
	return this.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
}


