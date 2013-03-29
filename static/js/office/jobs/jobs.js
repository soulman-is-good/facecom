function jobs_manager(params){
	var ops = {
		'addr_create' : '/office'+glOfficeId+'/jobs/create/',
		'addr_edit' : '/office'+glOfficeId+'/jobs/edit/',
		'addr_view' : '/office'+glOfficeId+'/jobs/view/',
		'addr_delete' : '/office'+glOfficeId+'/jobs/delete/',
		'title_create' : 'Создание вакансии',
		'title_edit' : 'Редактирование вакансии',
		'title_view' : 'Просмотр вакансии',
		'action' : 'create',
		'id' : '0',
		'obj' : null
	}
	ops = $.extend({},ops,params);

	var self = this;
	var title;
	var addr;

	function init(){
		if(ops.action == 'create'){
			title = ops.title_create;
			addr = ops.addr_create;
		}
		if(ops.action == 'edit'){
			title = ops.title_edit;
			addr = ops.addr_edit;
		}

		if(ops.action == 'view'){
			title = ops.title_view;
			addr = ops.addr_view;
		}

		if(ops.action == 'delete'){
			title = ops.title_delete;
			addr = ops.addr_delete;
		}
	}

	this.draw = function(){
		init();
		createJobWnd = new wnd(null,true);
		createJobWnd.setRelativePosition('center');
		if(ops.action != 'delete'){createJobWnd.setTitle(title);}
		createJobWnd.ajaxLoad(addr+ops.id,'',function(data){
			if(ops.action == 'delete'){
				$(ops.obj).parents('.job').fadeOut('slow', function(){
					createJobWnd.close();
					$(ops.obj).parents('.job').remove();
				})
			}
		});
	}

	self.draw();
}

$(document).ready(function(){
	$('.addJob').click(function(){
		jobs_manager();
	});

	$('.editJob').click(function(){
		jobs_manager({'action':'edit', 'id':$(this).attr('rel')});
	});

	$('.viewJob').click(function(){
		jobs_manager({'action':'view', 'id':$(this).attr('rel')});
	});

	$('.deleteJob').click(function(){
		jobs_manager({'action':'delete', 'id':$(this).attr('rel'), 'obj': this});
	});

})