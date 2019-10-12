<?php
//保存文章

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] :false;
if (!$user) {
	exit(json_encode(array('code'=>1,'msg'=>'Please login first!')));
}

$data['uid'] = $user['id'];
$data['title'] = trim($_POST['title']);
$data['cid'] = (int)$_POST['cid'];
$data['keywords'] = trim($_POST['kwd']);
$data['a_desc'] = trim($_POST['desc']);
$data['a_content'] = htmlspecialchars(trim($_POST['content']));
$data['add_time'] = time();



require_once $_SERVER['PATH_TRANSLATED'].'/lib/Db.php';
$db = new Db();

$id = $db->table('article_table')->insert($data);

if (!$id) {
	exit(json_encode(array('code'=>1,'msg'=>'Save is failed!')));
}
exit(json_encode(array('code'=>0,'msg'=>'Save is successful!')));