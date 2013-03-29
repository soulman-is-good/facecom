$(function(){
    var trig = true;
    if($('.content').hasClass('.discount-show'))
    $(document).scroll(function(){
        if(trig && $(this).scrollTop()>70){
            $('.main').addClass('fix');
            trig = false;
        }else if(!trig && $(this).scrollTop()<=70){
            $('.main').removeClass('fix');
            trig = true;
        }
    })
    
    $('.delete').live('click',function(){
        var s = $(this).parents('.discount');
        $.get($(this).attr('href'),function(){s.animate({'opacity':0},'fast','linear',function(){$(this).animate({'width':'0'},'fast',function(){$(this).remove()})})}).error(function(){});
        return false;
    });
    
    $('#more').click(function(){
        document.loadMoreDiscount();
        return false;
    })
    
    document.loadMoreDiscount();
})
document.loadMoreDiscount = function(){
    $.get('/business/discount/more',function(m){
        $('#sales').removeClass('loading');
        if(m.length>0){
            if(m[0].last)
                $('#more').remove();
            for(i in m){
                var h = $('#discount_tmpl').html();
                for(j in m[i]){
                    var r = new RegExp('{{'+j+'}}', 'g');
                    h = h.replace(r,m[i][j]);
                }
                h = $(h);
                $('#sales').append(h);
            }
            $('.discount.hidden').each(function(i){
                var a = this;
                setTimeout(function(){
                    $(a).removeClass('hidden');
                },i*100)
            })
        }else {
            $('#more').remove();
        }
    },'json')
    
}