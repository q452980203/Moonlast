<?php
//echo date('Y-m-d H:i:s', 1568976604);
require_once $_SERVER['PATH_TRANSLATED'].'/lib/Db.php';

$db = new Db();
//$res = $db->table('bg_test')->field('id,keyword')->order('id desc')->limit(4)->where('id>42')->lists();

//$data = ['cid'=>19,'articleTitle'=>'测试标题234','keyword'=>'关键字33','addTime'=>334455];
//$res = $db->table('bg_test')->insert($data);

//$res = $db->table('bg_test')->where('id=42')->delete();

//$data = ['addTime'=>334455];
//$res = $db->table('bg_test')->where('id=40')->updata($data);

//$res = $db->table('bg_test')->field('id,keyword')->where('id>40')->count();

$page = $_GET['page'];
$pageSize = 2 ;
$res = $db->table('bg_test')->field('id,keyword')->where('id>1')->pages($page,$pageSize);

//echo "<pre>";
//print_r($res);

?>
<!DOCTYPE html>
<html>
<head>
	<title>???</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="/static/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css">
</head>
<body>
	<div class="container" style="margin-top: 50px;">
		<table class="table table-bordered">
		  <thead>
		  	<tr>
		  	<th>id</th>
		  	<th>keyword</th>
		  	</tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($res['data'] as $value) {?>
		  	<tr>
		  		<td><?php echo $value['id']; ?></td>
		  		<td><?php echo $value['keyword']; ?></td>	
		  	</tr>
		  	<?php } ?>
		  </tbody>
		</table>
		<div><?php echo $res['html'];?></div>
	</div>
</body>
</html>