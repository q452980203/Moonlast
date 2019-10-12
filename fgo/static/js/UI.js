var UI = {
	//加载模态框
	alert:function(obj){
		var title = (obj == undefined || obj.title == undefined) ? 'Prompts' : obj.title;
		var msg = (obj == undefined || obj.msg == undefined) ? 'Error' : obj.msg;
		//var icon = (obj == undefined || obj.icon == undefined) ? '' : obj.icon;
		var html = '<div class="modal fade" tabindex="-1" role="dialog" id="login_hint">\
					  <div class="modal-dialog modal-sm" role="document">\
					    <div class="modal-content">\
					      <div class="modal-header">\
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
					        <h4 class="modal-title">'+title+'</h4>\
					      </div>\
					      <div class="modal-body">\
					        <p>'+msg+'</p>\
					      </div>\
					      <div class="modal-footer">\
					        <button type="button" class="btn btn-primary" onclick="$(\'#login_hint\').modal(\'hide\');">Close</button>\
					      </div>\
					    </div>\
					  </div>\
					</div>';
		$('body').append(html);
		$('#login_hint').modal({backdrop:'static'});
		$('#login_hint').modal('show');
		$('#login_hint').on('hidden.bs.modal', function (e) {
			$('#login_hint').remove();
		})
	},

	//加载页面
	open:function(obj){
		var title = (obj == undefined || obj.title == undefined) ? 'Login' : obj.title;
		var url = (obj == undefined || obj.url == undefined) ? '/login.php' : obj.url;
		var width = (obj == undefined || obj.width == undefined) ? 350 : obj.width;
		var height = (obj == undefined || obj.height == undefined) ? 240 : obj.height;

		var html = '<div class="modal fade" tabindex="-1" role="dialog" id="login_open">\
					  <div class="modal-dialog" role="document">\
					    <div class="modal-content">\
					      <div class="modal-header">\
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
					        <h4 class="modal-title">'+title+'</h4>\
					      </div>\
					      <div class="modal-body">\
					        <iframe src="'+url+'" style="width:100%;height:100%;" frameborder="0"></iframe>\
					      </div>\
					    </div>\
					  </div>\
					</div>';
		$('body').append(html);
		$('#login_open .modal-dialog').css('width',width);
		$('#login_open .modal-body').css('height',height);
		$('#login_open').modal({backdrop:'static'});
		$('#login_open').modal('show');
		$('#login_open').on('hidden.bs.modal', function (e) {
			$('#login_open').remove();
		})
	},

}