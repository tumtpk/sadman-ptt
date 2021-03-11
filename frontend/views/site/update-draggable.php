<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');
$user_id = $_POST['user_id'];
$newgroup = $_POST['newgroup'];
$oldgroup = $_POST['oldgroup'];

$sql = "UPDATE `users` SET `user_group`= '".$newgroup."' WHERE id = '".$user_id ."'";
$query = Yii::$app->db->createCommand($sql);
if ($query->execute()) {
	$output['status'] = 1;
}else{
 	$output['status'] = 0;
}
echo json_encode($output);


?>