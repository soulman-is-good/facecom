function prepare_uploader(){
    /*ops = {
        'type':'photos'
    }*/
    countFiles=0;
    countUploaded=0;
    this.uploaded_files = new Array();
    var self = this;
    //ops = $.extend({},ops,options);

    $('.fileupload').fileupload({
        dataType: 'json',
        done: function (e,data) {
            countUploaded++;
            $.each(data.result, function (index, file) {
                $('#filestatus').html(countUploaded+' из '+countFiles);
                $('#uploading_file_'+countUploaded).html('<div class="uploaded_image"><textarea id="textarea_photo_description_'+file.id+'" name="photo_description['+file.id+']" style="display:none;"></textarea><div class="uploaded_image_controll"><a href="#" class="uploaded_image_add_description" rel="'+file.id+'">Добавить описание</a> <a href="#" class="uploaded_image_delete" rel="'+file.id+'"><img src="/static/css/drop_photo.png" alt="" /></a></div><img src="/upload/photos/small/'+file.name+'" alt="" /></div>');
                $('#uploading_file_'+countUploaded).children('.uploaded_image').animate({
                    'filter':'progid:DXImageTransform.Microsoft.Alpha(opacity=100)',
                    '-moz-opacity': '1',
                    '-khtml-opacity': '1',
                    'opacity': '1',
                    }
                    ,1000
                );
                $('#photo_ids').attr('value',$('#photo_ids').attr('value')+file.id+',');
                self.uploaded_files[file.id] = file.name;
            });
            if(countUploaded==countFiles){
                $('.uploadLinkWithButtonMore').css('display','block');
                $('.add_photo_submit').removeAttr('disabled');
            }
        }
    });
    $('.fileupload').change(function(){
        $('.add_photo_submit').attr('disabled','true');
        $('.upload_btn, .uploadLinkWithButton').css('display','none');
        $('.photos_loader_scroll').jScrollPane();
        if(!this.files){openedFiles = 1;}else{openedFiles = this.files.length;}
        for(i=countFiles+1;i<countFiles+openedFiles+1;i++){
            if(!this.files){filename = this.value.split(/(\\|\/)/g).pop();}else{filename = this.files[i-countFiles-1].name;}
            $('.photos_loader').append('<div class="current_uploading_files" id="uploading_file_'+i+'"><div class="uploading_file_name">'+filename+'</div><img src="/static/css/preload.gif" alt="" /><div class="current_uploading_files_loading">Загружается</div></div>');
        }
        countFiles=countFiles+openedFiles;
        $('#filestatus').html(countUploaded+' из '+countFiles);
    })
}
$(document).ready(function(){

    $('.uploaded_image').live('mouseover',function(){
        $(this).children('.uploaded_image_controll').fadeTo(0,1);
    });

    $('.uploaded_image').live('mouseout',function(){
        $(this).children('.uploaded_image_controll').fadeTo(0,0);
    });

    $('#add_photo_form').live('submit',function(){
        error=0;
        if($('#album_set').attr('value')=='1' && $('#album_create').attr('value')==''){
            error='Не выбран альбом';
        }
        if($('#photo_ids').attr('value')==''){
            error='Нет фото для загрузки';
        }
        if(error!=0){
            error_wnd=new wnd(null,true,300);
            error_wnd.setZindex(600);
            error_wnd.setRelativePosition('center');
            error_wnd.setContent('<div class="wnd_error" align="center">'+error+'</div>');
            error_wnd.closeTimeOut(1000);
            return false;
        }
    });

    
    $('.uploaded_image_delete').live('click',function(){
        obj=$(this).parents('.current_uploading_files');
        obj.fadeOut(500, function(){obj.remove()});
        val = $('#photo_ids').val();
        val = val.replace(','+$(this).attr('rel')+',', ',');
        $('#photo_ids').val(val);
        if(val == ',')  
            $('.add_photo_submit').attr('disabled','disabled')
        return false;
    });

    $('.uploaded_image_add_description').live('click',function(){
        upImWnd = new wnd(null,true);
        upImWnd.setRelativePosition('bottom',105,5,$(this));
        image_id=$(this).attr('rel');

        content = $('<div />');
        content.append('<img src="/static/css/wnd_arrow.png" class="wnd_arrow" alt="" />');
        inpSubmit = $('<input />').attr({'type':'submit', 'value':'Готово'}).click(function(){
            
            $('#textarea_photo_description_'+image_id).html($('#description_textarea_id').val());
            upImWnd.close();
        });
        inpCancel = $('<input />').attr({'type':'button', 'value':'Отмена', 'class':'closeMywnd'});
        description = $('<div />').addClass('UpImDescription').append($('<textarea />').attr({'id':'description_textarea_id', 'cols':'20', 'rows':'3','placeholder':'Описание фото', 'value':$('#textarea_photo_description_'+image_id).val()})).append('<br />').append(inpSubmit).append(inpCancel);
        content.append(description);

        upImWnd.setZindex(1000);
        upImWnd.setContent(content);
        return false;
    });

})