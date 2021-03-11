<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$sql = Yii::$app->db->createCommand("SELECT DISTINCT user_id FROM user_online")->queryAll();
$count = 0;
$resultArray = array();

foreach ($sql as $row) {
	$count ++;
	$user = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$row['user_id']."'")->queryOne();

	$unit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$user['unit_id']."'")->queryOne();

	$user_group = Yii::$app->db->createCommand("SELECT * FROM user_group WHERE id = '".$user['user_group']."'")->queryOne();

	$unit_name = ($user['unit_id']=='000') ? 'Super Admin' : $unit['unit_name'];
	$user_group = (empty($user['user_group'])) ? '' : $user_group['name'];
	$resultArray[] = array(
		'user_id' => $row['user_id'],
		'name' => $user['name'],
		'unit_name' => $unit_name,
		'unit_group' => $user_group,
		'images' => $user['images'],
		'role' => $user['role'],
	);
}

if(isset($_SESSION['user_id'])){
	echo json_encode($resultArray);
}
?>