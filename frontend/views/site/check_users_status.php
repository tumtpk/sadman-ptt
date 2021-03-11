<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

if (isset($_POST['username'])) {
	$query = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `users` WHERE username = '".$_POST['username']."' AND password = '".md5($_POST['password'])."' AND status = '0'")->queryScalar();
	if ($query>0) {
		$data['output'] = 1;
	}else{
		$data['output'] = 0;
	}

	echo $someJSON = json_encode($data);
}

?>