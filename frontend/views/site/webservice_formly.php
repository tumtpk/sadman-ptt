<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$id = isset($_GET['id']) ?  $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');


$sql = "SELECT form_element FROM `eform_template` WHERE id = '$id'";

webservice($sql);

function webservice($sql){
	$query = Yii::$app->db->createCommand($sql)->queryOne();
	if (isset($_GET['token'])) {
		$token = isset($_GET['token']) ?  $_GET['token'] : (isset($_POST['token']) ? $_POST['token'] : '');
		$strtotime = isset($_GET['strtotime']) ?  $_GET['strtotime'] : (isset($_POST['strtotime']) ? $_POST['strtotime'] : '');
		if ($token == 'KFC123115/2%hrsdf:LDFK:Q656') {
			echo $query['form_element'];
			// // var_dump($query);
			// $service = json_encode($query['form_element']);
			// echo $service;
		} else {
			echo '{"drivers":"false"}';
		}
	}
}




?>