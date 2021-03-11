<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

$key = isset($_GET['key']) ?  $_GET['key'] : (isset($_POST['key']) ? $_POST['key'] : '');

if ($type=='show') {
	$check = Yii::$app->db->createCommand("SELECT * FROM description_keywords WHERE name = '".$key."'")->queryOne();
	$detail = (!empty($check['detail'])) ? $check['detail'] : $key;
	$images = (!empty($check['images'])) ? $check['images'] : 'none.png';
	$output['detail'] = $detail;
	$output['images'] = $images;
	$output['id'] = $check['id'];
	echo json_encode($output);
}


?>