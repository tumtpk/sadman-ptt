<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$userid = $_GET['user_id'];
$size = $_GET['size'];
$sql = "UPDATE `users` SET `font_size` = '".$size."' WHERE id = '".$userid."'";
$query = Yii::$app->db->createCommand($sql);
if ($query->execute()) {
	$output['status'] = 1;
}else{
	$output['status'] = 0;
}
echo json_encode($size);


?>