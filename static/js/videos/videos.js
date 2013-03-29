function video_save_description(obj,id){
    $.post('/id'+glUserId+'/avideos/save_description/'+id, $(obj).parents('form').serialize(), function(){
        $(obj).parents('.description').html($(obj).parent('form').children('textarea').val());
    });    
}

function addToMyVideos(obj, id){
    $(obj).html('Пожалуйста подождите...')
    $.post($(obj).attr('href'), '', function(){
        $(obj).html('Добавлено');
    });   
    return false;
}

function loadNavVideo(objwnd,addr){
    objwnd.ajaxLoad(addr,'',function(data){

        $('.viewPhoto .navigation').click(function(){
            loadNavVideo(objwnd,$(this).attr('href'));
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

        $('.edit_video_link').click(function(){
            /*EdPhWnd=new wnd(null,true);
            EdPhWnd.setRelativePosition('center');
            EdPhWnd.setTitle('Описание видео');
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
            });*/
            description = $(this).parents('.container').children('.description').text();
            rel = $(this).attr('rel');
            $(this).parents('.container').children('.description').html('<form action="#" method="post"><textarea name="description" placeholder="Описание" style="width:100%;height:40px;margin-bottom:10px;border:1px solid #ccc;color:#666;">'+description+'</textarea><br /><input type="button" onclick="video_save_description(this,'+rel+')" value="Сохранить" /></form>');

        });

        $('.delete_video_link').click(function(){
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
                    link.parents('.video_controll').html('Видео удалено');

                    if(data.count == 0)
                        location.href = '/id'+glUserId+'/video';
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

        $('#commentsScroll').jScrollPane({'autoReinitialise':'true','stickToBottom':'true','animate':'true'});

    });
}

//для закладок
function loadMoreBookmarkVideos(obj){
    button = $(obj);
    if(button.hasClass('loadMoreBusy'))
        return;
    button.addClass('loadMoreBusy');
    offset = $('#loadMoreOffset').val();
    $.post('/id'+glUserId+'/bookmarks/morevideo/', 'offset='+offset, function(data){
        $('.pv_list_fl').append(data.data);
        $('#loadMoreOffset').val(parseInt(offset)+data.videos_count);
        if(data.videos_count < 20)
            button.remove();
        else
            button.removeClass('loadMoreBusy');
    }, 'json');
}

$(document).ready(function(){
	$('#addVideoBtn').click(function(){
		mywnd=new wnd(null,true,837);
        mywnd.setTitle('Загружайте видео и делитесь ими');
        mywnd.setRelativePosition('center');
        mywnd.ajaxLoad('/id'+glUserId+'/avideos/add/','',function(data){
            prepare_uploader();
        });
	})
	$('.pw_list_item_open_link').live('click',function(){
        mywnd=new wnd(null,true);
        mywnd.setRelativePosition('center');
        loadNavVideo(mywnd,$(this).attr('href'));

        return false;
    });
})