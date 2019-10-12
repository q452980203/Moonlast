<?php

/**
* 
*/
class homeController
{
	
	public function indexAction(){
		require './application/home/view/fgo_index.php'; 	
	}

	public function loginAction(){
		$username = $_POST['username'];
		$pwd = $_POST['pwd'];

		$db = new homeModel();
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
	}

	public function logoutAction(){
		session_start();
		$_SESSION['user'] = null;
		exit(json_encode(array('code'=>0,'msg'=>'You have logged out!')));
	}

	public function publishAction(){
		$db = new homeModel();
		$res =  $db->table('a_class_table')->lists();
		exit(json_encode($res));
	}

	public function articleSaveAction(){
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

		$db = new homeModel();
		$id = $db->table('article_table')->insert($data);

		if (!$id) {
			exit(json_encode(array('code'=>1,'msg'=>'Save is failed!')));
		}
		exit(json_encode(array('code'=>0,'msg'=>'Save is successful!')));
	}

	public function uploadAction(){
		foreach ($_FILES as $value) {
			$files[] = $value;
		}
		if (count($files)>5) {
			exit(json_encode(array('errno'=>1,'data'=>[])));
		}

		foreach ($files as $value) {
			if ($value['error']>0) {
				echo json_encode(array('errno'=>2,'data'=>[]));
				continue;
			}
			$type = array('image/jpeg','image/png','image/gif');
			$size = 3*1024*1024;
			if (!in_array($value['type'], $type)) {
				echo json_encode(array('errno'=>3,'data'=>[]));
				continue;
			}
			if ($value['size'] > $size) {
				echo json_encode(array('errno'=>4,'data'=>[]));
				continue;
			}
			
			$moveFile = $_SERVER['PATH_TRANSLATED'] . '/application/home/upload/image/' . $value['name'];
			move_uploaded_file($value['tmp_name'], $moveFile);

			$data[] = '/application/home/upload/image/' . $value['name'];
			
		}

		exit(json_encode(array('errno'=>0,'data'=>$data)));

	}


}