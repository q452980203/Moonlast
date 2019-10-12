<?php
//退出登录
session_start();
$_SESSION['user'] = null;
exit(json_encode(array('code'=>0,'msg'=>'You have logged out!')));