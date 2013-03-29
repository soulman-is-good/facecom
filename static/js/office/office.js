$(function(){
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