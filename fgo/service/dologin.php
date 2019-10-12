<?php
//登录验证
$username = $_POST['username'];
$pwd = $_POST['pwd'];

require_once $_SERVER['PATH_TRANSLATED'].'/lib/Db.php';
$db = new Db();
$user = $db->table('user_table')->where(array('username' => $username))->limit(1)->item();

if (!$user) {
	exit(json_encode(array('code'=>1,'msg'=>'The user does not exist!')));
}
if ($user['pwd'] != md5($pwd)) {
	exit(json_encode(array('code'=>2,'msg'=>'The password is incorrect!')));
}

session_start();
$_SESSION['user'] = $user;
exit(json_encode(array('code'=>0,'msg'=>'Login is successful!')));