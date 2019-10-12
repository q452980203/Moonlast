
<!DOCTYPE html>
<html>
<head>
	<title>Publish article</title>
	<link rel="stylesheet" type="text/css" href="/application/home/static/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script type="text/javascript" src="/application/home/static/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="/application/home/static/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/application/home/static/js/UI.js"></script>
	<script type="text/javascript" src="/application/home/static/plugins/wangEditor-3.1.1/release/wangEditor.min.js"></script>
	<style type="text/css">
		.form{margin-top:10px;}
		.form .input-group{margin:15px 0px;}
		.form .input-group span{width:70px;}
		.form .input-group input{width:618px;}
		.form .input-group select{width:618px;}
	</style>
</head>
<body>
	<div class="container">
		<div class="form">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Title</span>
				<input type="text" class="form-control" id="title">
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Classify</span>
				<select class="form-control" id="select1">
				</select>	
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Keyword</span>
				<input type="text" class="form-control" id="kwd">
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Describe</span>
				<input type="text" class="form-control" id="desc">
			</div>
			<div class="input-group input-group-sm">
				<div id="editor"></div>
			</div>
		</div>
		<button type="button" class="btn btn-primary" style="float: right;" onclick="save()">Save</button>
	</div>
</body>
</html>
<script type="text/javascript">
	function select(){
		var data = new Object;
		$.post('/?a=publish',data,function(res){
			var data =  JSON.parse(res);
			for(var i = 0; i < data.length; i++){
				$("#select1").append("<option value='" + data[i].cid + "'>" + data[i].c_name + "</option>");
			}
		});
	}
	select();

	function editor() {
		var E = window.wangEditor;
	    editor = new E('#editor');
	    editor.customConfig.zIndex = 10;
	    editor.customConfig.uploadImgServer = '/?a=upload';
	    editor.customConfig.customAlert = function (info) {
		    UI.alert({msg:info});
		}
	    editor.create();
	}
	editor();

	function save(){
		var data = new Object;
		data.title = $.trim($('#title').val());
		data.cid = $.trim($('#class').val());
		data.kwd = $.trim($('#kwd').val());
		data.desc = $.trim($('#desc').val());
		data.content = editor.txt.html();
		if (data.title == '') {
			UI.alert({msg:'Please enter the title.'});return false;
		}
		if (data.content == '<p><br></p>') {
			UI.alert({msg:'Please enter the content.'});return false;
		}
		$.post('/?a=articleSave',data,function(res){
			if (res.code>0) {
				UI.alert({msg:res.msg});
			}else{
				UI.alert({msg:res.msg});
				setTimeout(function(){parent.window.location.reload();},3000);
			}
		},'json');
	}

</script>