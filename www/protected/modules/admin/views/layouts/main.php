<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title><?=$this->pageTitle?></title>
        <link rel="stylesheet" href="/css/admin/normalize.css" />
        <link rel="stylesheet" href="/css/admin/style.css" />
        <script>
            $(function(){
                $('.row.status').each(function(){
                    var input = $(this).find('input');
                    var p = input.parent();
                    var name = input.attr('name');
                    var val = input.val();
                    var radio = $('<input />').attr({'type':'radio','name':name});
                    var states = $(this).attr('states');
                    if(states == null)
                        states = 'Вкл.|Выкл.';
                    states = states.split('|');
                    var div = $('<div />').attr('id',input.attr('id'));
                    for(i in states){
                        var tmp = radio.clone();
                        tmp.attr({'id':name+i,'value':i});
                        if(i == val)
                            tmp.attr('checked',true);
                        div.append(tmp);
                        div.append('<label for="'+name+i+'">'+states[i]+'</label>')
                    }
                    input.replaceWith(div);                    
                    div.buttonset();
                })
                $('.row.buttons input').button();
            })
        </script>
    </head>
    <body>
        <div class="fc-body">
            <?=$this->renderPartial('admin.views.layouts.menu')?>
            <div class="fc-content">
                <table><tr>
                <td>
                    <div class="fc-sidebar">
                        <?=$this->renderPartial('admin.views.layouts.menu_side')?>
                    </div>
                </td>
                <td style="padding-left:20px">
                    <div>
                    <?=$content?>
                    </div>
                </td>
                </tr></table>
            </div>
            <div class="fc-footer"><h2>facecom</h2></div>
        </div>
    </body>
</html>