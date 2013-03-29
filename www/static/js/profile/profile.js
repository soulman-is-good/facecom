$(document).ready(function(){
	// Манипуляции с формой для отправки сообщений
	var noHide = false;

	$('.whatsNew #send, .whatsNew .attach').mouseover(function(){
		noHide = true;
	}).mouseout(function(){
		noHide = false;
	})

	$('.whatsNew #whatsNewArea').focusin(function(){
		$('.whatsNew #cancel').show();
		$('.whatsNewAreaContainer').css('height', '92px')
		$(this).css('color', '#000000')
	})

	$('.whatsNew #whatsNewArea').focusout(function(){
		if (noHide == false) {
			$('.whatsNew #cancel').hide();
			$('.whatsNewAreaContainer').css('height', '46px')
			$(this).css('color', '#7D7D7D')
		}
	})

	$('.whatsNew #cancel').click(function(){
		$('.whatsNewAreaContainer').css('height', '46px')
		$(this).css('color', '#7D7D7D')
		$(this).hide();
	})

	// Вызов ф-ции добавления записи через ctrl+enter
	$('.whatsNew form').submit(function(){
		sendEntry(this, $('#postsContainer'), false);
		return false;
	})

	// Вызов ф-ции добавления записи через ctrl+enter
	$('.whatsNew form').live('keypress', function(e){
		if ((e.ctrlKey) && ((e.keyCode == 0xA) || (e.keyCode == 0xD))) {
		    sendEntry(this, $('#postsContainer'), true);
		}
	})

	$('.whatsNew').mouseover(function(){
		$('.whatsNew .attach').show()
	}).mouseout(function(){
		$('.whatsNew .attach').hide()
	})

	$('.attach .userWallAttachImage').click(function(){
		myWnd = new wnd(null, true, 895);
		myWnd.setRelativePosition('center');
		myWnd.setTitle('Прикрепить изображение');
		myWnd.ajaxLoad($(this).attr('url'),'',function(){
			uploader_inst = new prepare_uploader();
			$('#fc-avatar-gallery').append($.facecomGallery({
				'multiselect' : true,
				'url' : '/id'+glUserId+'/aphotos/get_json',
				'path' : '/images/',
				'thumbsName' : 'small',
				'rememberSelection' : false
			}).content());
			$('.posts_append_images').click(function(){
				if($('#fc-tab-selected').val()=='computer')
					post_append_images_from_pc(myWnd, uploader_inst.uploaded_files);
				else
					post_append_images_from_albums(myWnd, $.facecomGallery[0].getSelection());
				myWnd.close();
			})
		})
	})

	$('.posts_append_images_delete').live('click',function(){
		$(this).parent('div').fadeOut('slow', function(){$(this).remove();})
		return false;
	});

	// Загрузить следующие n записей (n указано в конфиге)
	$('.loadMore').live('click', function(){
		
	});

	$('.all_posts_files_item a').live('click',function(){
		mywnd=new wnd(null,true);
        mywnd.setRelativePosition('center');
        loadNavPostPhoto(mywnd,$(this).attr('href'));
        
        return false;
	});
})

function sendEntry(obj, entryContainer, ctrlEnter) { // Объект формы, объект контейнера с записями, при клике или при сочетании клавиш
	files = '';
	$.each($('.post_appending_preview_img'), function(){
		files = files + '&files[]['+$(this).attr('rel')+']='+$(this).attr('type');
	})
	$.post($(obj).attr('action'), $(obj).serialize()+files, function(data){
		if (data.status == 'ok') {
			$(entryContainer).prepend(data.data);
			$(entryContainer).children('.entry:hidden').fadeIn(400);
			$(obj).find('input[name=lastEntryId]').val($(entryContainer).children('.entry').attr('entry_id'))

			$('#post_appending_preview').html('');

			if (!ctrlEnter) {
				$(obj).find('textarea:first').val('Что нового').css('color', '#7D7D7D')
				$(obj).find('.overflowContainer').css('height', '46px')
			}
			else {
				$(obj).find('textarea:first').val('')
			}
		}
		else {
			alert(data.data);
		}
	}, 'json');
}

function loadNavPostPhoto(objwnd,addr){
	objwnd.ajaxLoad(addr,'',function(data){

        $('.viewPhoto .navigation').click(function(){
            loadNavPostPhoto(objwnd,$(this).attr('href'));
            return false;
        });

/*        $('#photo_comments_form textarea[name="text"]').live('keydown',function(e){
            if (e.ctrlKey && e.keyCode == 13) {
                $('#photo_comments_form').submit();
            }
        })*/

        $('#photo_comments_form').live('submit',function(){
            $(this).find('textarea[name="text"]').val('');
            $(this).find('textarea[name="text"]').focus();
            $("#commentsScroll").data('jsp').scrollToY($('#commentsScroll .commentsContainer').height());
        });
    });
}

function loadMorePosts(obj, _post_type, _owner_type, _owner_id){
	var button = $(obj);
	var url = '/posts/loadMore';

	if (!$(button).hasClass('loadMoreBusy')) {
		$(button).addClass('loadMoreBusy');
		$.post(url, { lastEntryId: $('#postsContainer .entry:last').attr('entry_id'), post_type: _post_type, owner_type: _owner_type, owner_id: _owner_id }, function(data){
			if (data.status == 'ok') {
				$('#postsContainer').append(data.data);
				$('#postsContainer .entry:hidden').fadeIn(400);
			}
			else {
				alert(data.data);
			}

			$(button).removeClass('loadMoreBusy');
		}, 'json');
	}
}

function deleteWallPost(obj, url, _item_id) {
	targetObj = $(obj).parents('.entry');

	$.post(url, { item_id: _item_id }, function(data){
		if (data.status == 'ok') {
			$(targetObj).fadeOut(400, function(){
				$(this).remove()
			})
		}
	}, 'json')
}

function addFriend(obj, url) {
	$.post(url, function(data){
		if (data.status == 'ok') {
			$(obj).parent().html(data.data)
		}
	}, 'json')
}

function deleteRequest(obj, url) {
	/*alert($(obj).html())*/
	$.post(url, function(data){
		if (data.status == 'ok') {
			$(obj).parent().html(data.data)
		}
	}, 'json')
}

function confirmRequest(obj, url) {
	/*alert($(obj).html())*/
	$.post(url, function(data){
		if (data.status == 'ok') {
			$(obj).parent().html(data.data)
		}
	}, 'json')
}

function rejectRequest(obj, url) {
	/*alert($(obj).html())*/
	$.post(url, function(data){
		if (data.status == 'ok') {
			$(obj).parent().html(data.data)
		}
	}, 'json')
}

function deleteFriendship(obj, url) {
	/*alert($(obj).html())*/
	$.post(url, function(data){
		if (data.status == 'ok') {
			$(obj).parent().html(data.data)
		}
	}, 'json')
}

function change_upload_tab(obj, show_id, hdn_value) {
	$(obj).parents('.fc-avatar-menu').find('a').removeClass('active');
	$('#upload_tabs .upload_tab').css('display','none');
	$(obj).addClass('active');
	$('#'+show_id).css('display','block');
	$('#fc-tab-selected').val(hdn_value);
}
function post_append_images_from_pc(wnd, uploaded_files) {
	for(var i in uploaded_files){
		$('#post_appending_preview').append('<div><img rel="'+i+'" class="post_appending_preview_img" type="uploaded" src="/upload/photos/80x80/'+uploaded_files[i]+'" /><a href="#" class="posts_append_images_delete"><img src="/static/css/audioDelete.png" alt="" /></a></div>')
	}
}
function post_append_images_from_albums(wnd, selection) {
	for(var i in selection){
		$('#post_appending_preview').append('<div><img rel="'+selection[i].filename+'" class="post_appending_preview_img" type="album" src="/upload/photos/80x80/'+selection[i].filename+'.'+selection[i].file_ext+'" /><a href="#" class="posts_append_images_delete"><img src="/static/css/audioDelete.png" alt="" /></a></div>')
	}
}