/* 
 * Handles profile/edit page
 */
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
    $('#obrazovaniye').fctabs();
    $('#facecom-tabs').fctabs();
    
    //define templates
    var new_univer = '<div class="form education newuniver">'+$('#new_univer').removeAttr('id').html()+'</div>';
    var new_school = '<div class="form education newschool">'+$('#new_school').removeAttr('id').html()+'</div>';
    var new_work = false; // we will generate it later, so that dropdown list appear
    //show add buttons
    $('.addschool, .adduniver, .addwork').css('display','block');
    //bind actions
    var slen = $('.school').length;
    var ulen = $('.univer').length;
    var wlen = $('.work').length;
    $('#add-work').bind('click',function(){
        var ns = new_work;
        ns = ns.replace(/UserWork\[[^\]]+\]/gim,'UserWork['+(wlen++)+']');
        $('<div class="hr">&nbsp;</div>').insertBefore($('.addwork'));        
        ns = $(ns).css('display','none');
        ns.insertBefore($('.addwork')).slideDown(function(){
            $('#UserWork_'+(wlen-1)+'_year_from').fcselect();
            $('#UserWork_'+(wlen-1)+'_year_from').fcselect();
            var s = ns.find('select');
            s.each(function(){
                var o = $(this);
                if(o.data('fcselect') != null)
                    o.data('fcselect').destroy();
                o.fcselect();
            })
            
        });
        if($('.newwork').length>3) {
            $(this).unbind('click');
            $('.addwork').remove();
        }
        return false;
    })
    $('#add-school').bind('click',function(){
        var ns = new_school;
        ns = ns.replace(/UserSchool\[[^\]]+\]/gim,'UserSchool['+(slen++)+']');
        $('<div class="hr">&nbsp;</div>').insertBefore($('.addschool'));        
        var ns = $(ns).css('display','none');
        ns.insertBefore($('.addschool')).slideDown(function(){            
            ns.find('.select').remove();
            var s = ns.find('select');
            s.each(function(){
                var o = $(this);
                if(o.data('fcselect') != null)
                    o.data('fcselect').destroy();
                o.fcselect();
            })
        });
        if($('.newschool').length>3) {
            $(this).unbind('click');
            $('.addschool').remove();
        }
        return false;
    })
    $('#add-univer').bind('click',function(){
        var ns = new_univer;
        ns = ns.replace(/UserUniversity\[[^\]]+\]/gim,'UserUniversity['+(ulen++)+']');
        $('<div class="hr">&nbsp;</div>').insertBefore($('.adduniver'));
        var ns = $(ns).css('display','none');
        ns.insertBefore($('.adduniver')).slideDown(function(){
            ns.find('.select').remove();
            var s = ns.find('select');
            s.each(function(){
                var o = $(this);
                if(o.data('fcselect') != null)
                    o.data('fcselect').destroy();
                o.fcselect();
            })
        });
        if($('.newuniver').length>3) {
            $(this).unbind('click');
            $('.adduniver').remove();
        }
        return false;
    })
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
            if(new_work == false && self.parent().hasClass('isnewwork')){
                var c = $('#new_work').clone()
                c.find('.select').remove();
                new_work = '<div class="form education newwork">'+c.removeAttr('id').html()+'</div>'
            }
            /*if(cities.parent().hasClass('select')){
                var p = cities.parent();
                cities.insertAfter(p);
                p.remove();
            }*/
            if(cities.data('fcselect') == null)
                cities.fcselect();
            else{
                cities.data('fcselect').destroy();
                cities.fcselect();
            }
        },dataType:'json',cache:true})
    })
    cityInit();
    $('#birth_day').fcselect({'width':'58px'})
    $('#birth_month').fcselect({'width':'178px'})
    $('#birth_year').fcselect({'width':'118px'})
})
function cityInit(el){
    if(typeof el == 'undefined' || el == null){
        $('.country_id').each(function(i){
            var cit = $($(this).attr('for'));
            var val = cit.val();
            var id = cit.attr('id');
            cit.replaceWith($('<select />').attr({'class':'city_id','id':id,'name':cit.attr('name')}).data('city',val)).fcselect();
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
