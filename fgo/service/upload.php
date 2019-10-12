<?php

//上传图片并处理

foreach ($_FILES as $value) {
	$files[] = $value;
}
if (count($files)>5) {
	exit(json_encode(array('errno'=>1,'data'=>[])));
}


foreach ($files as $value) {
	//echo '<pre>';print_r($value);
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

	$moveFile = $_SERVER['PATH_TRANSLATED'] . '/upload/image/' . $value['name'];
	move_uploaded_file($value['tmp_name'], $moveFile);

	$data[] = '/upload/image/' . $value['name'];
	
}

exit(json_encode(array('errno'=>0,'data'=>$data)));

