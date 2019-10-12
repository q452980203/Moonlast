﻿<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] :false;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Fate/Grand Order</title>
	<link rel="stylesheet" type="text/css" href="./application/home/static/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./application/home/static/css/index_style.css">
	<script type="text/javascript" src="./application/home/static/js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="./application/home/static/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./application/home/static/js/UI.js"></script>
</head>
    <body>
		<div class="header">
			<div class="container">
				<span class="title">Fate/Grand Order</span>
				<div class="login-reg">
					<?php if ($user) { ?>
						<div class="btn-group">
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						  	<?php echo $user['username']?> <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu">
						    <li><a href="#">Administration</a></li>
						    <li><a href="#" onclick="publish()">Publish</a></li>
						    <li role="separator" class="divider"></li>
						    <li><a href="#" onclick="logout()">Logout</a></li>
						  </ul>
						</div>
					<?php }else{?>
						<button class="btn btn-default" type="button" onclick="login()">Login</button>	
					<?php }?>
				</div>
			</div>
		</div>

		<div class="main container">
	            <div class="imgshow">
	            	<img src="./application/home//static/images/img1.jpg">
	            </div>

				<div class="menu">
					<ul class="nav nav-tabs">
						<li role="presentation"><a href="#">Home</a></li>
						<li role="presentation"><a href="#">Article</a></li>
						<li role="presentation"><a href="#">Music</a></li>
						<li role="presentation"><a href="#">Animation</a></li>
						<li role="presentation"><a href="#">Game</a></li>
						<li role="presentation"><a href="#">Message</a></li>
						<div class="search">
					    <div class="input-group">
					      <input type="text" class="form-control" placeholder="Search for...">
					      <span class="input-group-btn">
					        <button class="btn btn-default" type="button">Search</button>
					      </span>
					    </div>
					</div>
					</ul>
				</div>
			<div class="col-lg-3 left-container">
				<p class="cates">Daily update</p>
				<div class="cates-list">
					<div class="cates-item"><a href="">some one</a></div>
					<div class="cates-item"><a href="">some one</a></div>
					<div class="cates-item"><a href="">some one</a></div>
					<div class="cates-item"><a href="">some one</a></div>
					<div class="cates-item"><a href="">some one</a></div>
					<div class="cates-item"><a href="">some one</a></div>
					<div class="cates-item"><a href="">some one</a></div>
				</div>
			</div>
			<div class="col-lg-9 right-container">
				<div class="content_body_center1_img"></div>
				<div class="content_body_center1_Article"></div>
			</div>
			<div class="content_body_right1"></div>	
		</div>

		<div class="footer container">

		</div>>
    </body>
</html>
<script type="text/javascript">
	//登录
	function login(){
		UI.open({url:'./application/home/view/login.php'});
	}
	//退出登录
	function logout(){
		if (!confirm('Are you sure you want to log out?')) {
			return;
		}
		$.post('/?a=logout',{},function(res){
			if (res.code>0) {
				UI.alert({msg:res.msg});
			}else{
				UI.alert({msg:res.msg});
				setTimeout(function(){parent.window.location.reload();},3000);
			}
		},'json');
	}
	//发表文章
	function publish(){
		UI.open({title:'Publish an article',url:'./application/home/view/publish.php',width:750,height:610});
	}
</script>
