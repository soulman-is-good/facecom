var sel_tmpl = '<span>{{val}}<a href="#remove"><img alt="X" src="/static/css/cross.png"></a></span>';
var pup_tmpl = '<div class="select multi" style="width:425px"><div class="selected"><em>Ничего не выбрано</em></div></div>';
function createCoupon(type,el){
    var form = $($('#coupon-form').html().replace(/\{\{id\}\}/g,COUPON_CNT++));
    var types = $('#a-coupon').data('type').split('|');
    form.find('[id$="_type"]').val(type>0?1:0);
    form.find('form').validate({
        showErrors:function(e,a){
            for(i in e){
                $('[name="'+i+'"]').attr('title',e[i]);
                e[i] = '';
            }
            for(i in a)
                a[i].message = '';
            this.defaultShowErrors();
            return a.length>0?false:true;
        }
    });
    var d = $.dialog(form,$(el).text(),function(){
        var form = this.getContent().find('form');
        if(!form.valid()){
            return false;
        }
        var coup = $('#a-coupon').html();
        var type = form.find('[id$="_type"]').val()>0?1:0;
        coup = coup.replace(/\{\{type\}\}/g,types[type]);
        coup = coup.replace(/\{\{price\}\}/g,form.find('[id$="_price"]').val());
        coup = coup.replace(/\{\{percent\}\}/g,form.find('[id$="_percent"]').val());
        coup = $(coup)
        coup.find('.hidden-form').append(form.children());
        $('#coupons h5').css('display','none');
        $('#coupons').append(coup);
        return true;
    },types[type]);
    d.setSize(700,460);
    d.getContent().parent().css({'height':'auto','padding-bottom':'35px','background':'#FFF'})
    d.move();
}

function editCoupon(el){
    var form = $('<div class="office-edit"></div>').append($('<div class="coupon-form form"></div>').append($('<form />').append($(el).find('.hidden-form').children())));
    var self = el;
    var types = $('#a-coupon').data('type').split('|');
    form.find('form').validate({
        showErrors:function(e,a){
            for(i in e){
                $('[name="'+i+'"]').attr('title',e[i]);
                e[i] = '';
            }
            for(i in a)
                a[i].message = '';
            this.defaultShowErrors();
            return a.length>0?false:true;
        }
    });
    var d = $.dialog(form,'Редактирование',function(){
        var form = this.getContent().find('form');
        if(!form.valid()){
            return false;
        }
        var coup = $('#a-coupon').html();
        var type = form.find('[id$="_type"]').val()>0?1:0;
        coup = coup.replace(/\{\{type\}\}/g,types[type]);
        coup = coup.replace(/\{\{price\}\}/g,form.find('[id$="_price"]').val());
        coup = coup.replace(/\{\{percent\}\}/g,form.find('[id$="_percent"]').val());
        coup = $(coup)
        coup.find('.hidden-form').append(form.children());
        coup.insertAfter(self);
        $(self).remove();
        return true;
    },'Сохранить');
    d.setSize(700,460);
    d.getContent().parent().css({'height':'auto','padding-bottom':'35px','background':'#FFF'})
    d.move();
}

$(function(){
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $('.datetime').datetimepicker({
	timeFormat: 'HH:mm',
	stepHour: 1,
	stepMinute: 5,
	timeOnlyTitle: 'Выберите время',
	timeText: 'Время',
	hourText: 'Часы',
	minuteText: 'Минуты',
	secondText: 'Секунды',
	currentText: 'Сейчас',
	closeText: 'Закрыть'
    });
    $('.flag').click(function(){
        editCoupon(this);
        return false;
    })
    
    $('.popup-select').each(function(){
        var T = this;
        var pup = $(pup_tmpl);
        pup.insertAfter(this);
        pup.data({'vals':pup.find('.selected')});
        $(this).data('pup',pup);
        var vals = $(this).val().split(',');
        var assoc = $(this).data('assoc');
        if(vals.length==0){
            
        }else{
            pup.data('vals').html('');
            for(i in vals){
                vals[i] = parseInt(vals[i].replace(/\s+/,''));
                if(isNaN(vals[i]))
                    vals.splice(i, 1);
                if(vals.length == 0) continue;
                var x = $(sel_tmpl.replace(/\{\{val\}\}/g,assoc[vals[i]]));
                x.find('a').data('id',vals[i]).click(function(){
                    if(!T.removeEntityId($(this).data('id'))){
                        pup.data('vals').append('<em>Ничего не выбрано</em>');
                    }
                    $(this).parent().fadeOut('fast',function(){$(this).remove();})
                    return false;
                })
                pup.data('vals').append(x);
            }
            if(vals.length == 0)
                pup.data('vals').append('<em>Ничего не выбрано</em>');
            
            
            pup.on('click',function(){
                $.selector({
                    'title':$(T).data('dtitle'),
                    'url':$(T).data('load'),
                    'data':$(T).val().split(',').map(function(val,i){return val = val.replace(/\s/g,'');}),
                    'callback':function(data){
                        if(data.ids.length == 0)
                            return false;
                        $(T).val(data.ids.join(','));
                        pup.data('vals').html('')
                        for(i in data.names){
                            var s = $(sel_tmpl.replace(/\{\{val\}\}/g,data.names[i]))
                            s.find('a').data('id',i).click(function(){
                                if(!T.removeEntityId($(this).data('id'))){
                                    pup.data('vals').append('<em>Ничего не выбрано</em>');
                                }
                                $(this).parent().fadeOut('fast',function(){$(this).remove();})
                                return false;
                            })
                            pup.data('vals').append(s);
                        }
                    }
                })
            })
        }
        this.removeEntityId = function(id){
            var vals = $(this).val().split(',');
            id = parseInt(id);
            for(i in vals){
                vals[i] = parseInt(vals[i].replace(/\s+/,''));
                if(isNaN(vals[i]) || vals[i] == id)
                    vals.splice(i, 1);
                if(vals.length == 0) continue;
            }
            $(this).val(vals.join(','));
            return vals.length > 0;
        }
    })
})

$.selector = function(ops){
    var self = this;
    var content = $('<div />').append('<img src="/static/css/loader01.gif" />');
    var data = {'ids':[],'names':{}};
    $.dialog(content, ops.title,function(){
        ops.callback.call(content,data);
    });
    content.parents('.mywnd').css({'height':'auto','background':'#FFF','padding-bottom':'50px'})
    function formContent(url,callback) {
        $.get(url,function(m){
            if(m!=null && !m.hasOwnProperty('length')){
                content.html('');
                for(i in m)
                    content.append($('<a />').attr('href','#').css({'float':'left','margin-right':'10px'}).html(m[i]).data('id',i).click(function(){
                        var a = this;
                        var i = $(a).data('id')
                        formContent(ops.url+'?cid='+i,function(){
                            $(a).css('background','#acacac');
                            var id = $(a).data('id');
                            data.ids.push(id);
                            data.names[id] = $(a).text();
                        });
                        return false;
                    }));
            }else if(typeof callback == 'function')
                callback.call(this);
        },'json').error(function(){
            callback.call(this);
            content.html('<em>Ошибка при получении данных.</em>')
        })
    }
    formContent(ops.url,function(){});
}