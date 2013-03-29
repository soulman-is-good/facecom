function loadMoreApps(obj, owner){
	var button = $(obj);
	var url = 'http://'+window.location.hostname+'/id'+owner+'/apps/loadMore';
	var offset=Number($('#jqdata').attr('lastOffset'));
	var list=$('#jqdata').attr('list');
	if (!$(button).hasClass('loadMoreBusy')) {
		$(button).addClass('loadMoreBusy');
		$.post(url, {lastOffset: offset,list:list}, function(data){
			if (data.status == 'ok') {
				$('#appsContainer').append(data.data);
				$('#postsContainer .appList:hidden').fadeIn(14000);
				$('#jqdata').attr('lastOffset',data.offset);
				var listLength=$('div.appItem').length;
				var total=Number($('#jqdata').attr('maxAps'));
				if(listLength>=total)
				{$(button).detach();}
			}
			else {
				alert(data.data);
			}

			$(button).removeClass('loadMoreBusy');
		}, 'json');
	}
}