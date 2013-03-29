$(document).ready(function(){
	// Манипуляции с формой для отправки комментариев
	var c_noHide = false;

	$('.comments .send').live('mouseover', function(){
		c_noHide = true;
	}).mouseout(function(){
		c_noHide = false;
	})

	$('.comments .addCommentArea').live('focus', function(){
		$(this).parents('.comments').find('.buttons').show();
		$(this).parents('.addCommentAreaContainer').css('height', '92px')
		$(this).css('color', '#000000')
	})

	$('.comments .addCommentArea').live('blur', function(){
		if (c_noHide == false) {
			$(this).parents('.comments').find('.buttons').hide();
			$(this).parents('.addCommentAreaContainer').css('height', '46px')
			$(this).css('color', '#7D7D7D')
		}
	})

	$('.comments .buttons .cancel').live('click', function(){
		$(this).parent().children('.whatsNewAreaContainer').css('height', '46px')
		$(this).parents('.comments').find('.addCommentAreaContainer').css('height', '46px')
		$(this).parent().hide();
	})

	// Вызов ф-ции добавления коммента
	$('.comments form').live('submit', function(){
		sendComment(this, false);
		return false;
	})

	// Вызов ф-ции добавления коммента через ctrl+enter
	$('.comments form').live('keypress', function(e){
		if ((e.ctrlKey) && ((e.keyCode == 0xA) || (e.keyCode == 0xD))) {
		    sendComment(this, true);
		}
	})

	// Показываем элементы управления при наведении
	$('.comments .item').live('mouseover', function(){
		$(this).find('.control').show();
	}).live('mouseout', function(){
		$(this).find('.control').hide();
	})
})

function sendComment(obj, ctrlEnter) {
	var thisForm = $(obj);
	var _lastCommentId = $(obj).parent().find('.commentsContainer').children('.item:last').attr('commentId'); // Получаем id последнего видимого комментария

	$.post($(obj).attr('action'), $(obj).serialize()+'&lastCommentId='+_lastCommentId, function(data){
		if (data.status == 'ok') {
			$(thisForm).parent().find('.commentsContainer').append(data.data);
			$(thisForm).parent().find('.commentsContainer').children('.item:hidden').fadeIn(400);

			if ($(thisForm).parents('.entry').find('.comments .count').attr('count') == 0) {
				$(thisForm).parents('.entry').find('.comments .count').remove(); // Удаляем надпись о количестве комментов, если их < 1
			}

			// Если отправили сообщение при помощи обычного клика по кнопке, то теряем фокус
			if (!ctrlEnter) {
				$(thisForm).find('.addCommentArea').val('Добавить комментарий').css('color', '#7D7D7D')
				$(thisForm).find('.buttons').hide();
				$(thisForm).children('.addCommentAreaContainer').css('height', '46px')
				$(thisForm).find('.addCommentArea').css('color', '#7D7D7D');
				c_noHide = false;
			}
			else { // Иначе просто чистим textarea
				$(thisForm).find('.addCommentArea').val('')
				c_noHide = true;
			}
		}
		else {
			alert(data.status);
		}
	}, 'json');
}

function showAllComments(obj, url, tbl, item_id) {
	targetObj = $(obj).parents('.comments').children('.commentsContainer');
	lastVisible = targetObj.children('.item:first').attr('commentId');

	$.post(url, { _tbl: tbl, _item_id: item_id, _lastVisible: lastVisible }, function(data){
		targetObj.prepend(data.data);
		targetObj.children('.item:hidden').fadeIn(400);
		$(obj).remove();
	}, 'json')
}

function deleteComment(obj, url, item_id) {
	targetObj = $(obj).parents('.item');

	$.post(url+'/'+item_id, function(data){
		if (data.status == 'ok') {
			targetObj.fadeOut(200, function(){
				targetObj.remove();
			});
		}
	}, 'json')
}

