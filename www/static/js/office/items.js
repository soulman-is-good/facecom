$(function(){
    $('.cart').each(function(){
        $(this).click(function(){
            var add = $('<div />');
            var inp = $('<input />').attr({
                'type':'text',
                'value':'1'
            });
            add.append($(this).data('title'));
            add.append($('<p />').append(inp).append('шт.'));
            var id = $(this).data('id');
            $.dialog(add,'Добавить в корзину',function(){
                $.get('/my/cart',{'item_id':id,'type':'image','count':inp.val()},function(){
                    //TODO: update cart
                })
            },'Добавить');
            inp.spinner({
                change:function(e,ui){
                    if ( ui.value < 0 ) {
                        $( this ).spinner( "value", 0 );
                        return false;
                    }
                },
                spin: function( event, ui ) {
                    if ( ui.value < 0 ) {
                        $( this ).spinner( "value", 0 );
                        return false;
                    }
                }
            });
        })
    })
})