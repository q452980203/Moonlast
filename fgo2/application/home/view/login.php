<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/application/home/static/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script type="text/javascript" src="/application/home/static/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="/application/home/static/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/application/home/static/js/UI.js"></script>
	<style type="text/css">
		.form{margin-top:20px;}
		.form .input-group{margin:25px 0px;}
	</style>
</head>
<body>
	<div class="container">
		<div class="form">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Username</span>
				<input type="text" class="form-control" name="user">
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Password&nbsp;</span>
				<input type="password" class="form-control" id="pwd">
			</div>
		</div>
		<button type="button" class="btn btn-primary btn-sm btn-block" onclick="login()">Login</button>
	</div>
</body>
</html>
<script type="text/javascript">
	function login() {
		var username = $.trim($('input[name="user"]').val());
		var pwd = $.trim($('#pwd').val());
		if (username=='') {
			UI.alert({msg:'Username cannot be empty!'});
			return;
		}
		if (pwd=='') {
			UI.alert({msg:'Password cannot be empty!'});
			return;
		}
		$.post('/?a=login',{username:username,pwd:pwd},function(res){
			if (res.code>0) {
				UI.alert({msg:res.msg});
			}else{
				UI.alert({msg:res.msg});
				setTimeout(function(){parent.window.location.reload();},3000);
			}
		},'json');
	}
</script>