<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');
$userid = isset($_GET['userid']) ?  $_GET['userid'] : (isset($_POST['userid']) ? $_POST['userid'] : '');
$data = array();

if ($type=='checkdata') {
	$checkdata = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE data_json LIKE '%\"user_create_id\":\"".$_SESSION['user_id']."\"%' AND data_json LIKE '%\"request_information\":%' AND data_json LIKE '%\"approve\":\"\"%' ORDER BY date_time DESC")->queryAll();

	
	foreach($checkdata as $q){

		$data_type = Yii::$app->db->createCommand("SELECT * FROM `eform` WHERE id = '".$q['eform_id']."'")->queryOne();

		$data_edata = @json_decode($q['data_json'],TRUE);
		$val_eform = $data_edata[0];
		$n = count($val_eform['request_information']);
		$i = $n-1;

		$data[] = array(
			"id" =>  "".$q['id']."",
			"form_id" => "".$q['form_id']."",
			"data_type" => "".$data_type['detail']."",
			"eform_id" => "".$q['eform_id']."",
			"data_json" => "".$q['data_json']."",
			"date_time" => "".$q['date_time']."",
			"request_information" => "".$val_eform['request_information'][$i]['detail']."",
			"user_request" => "".$val_eform['request_information'][$i]['user_request']."",
			"unit_name" => "".$val_eform['request_information'][$i]['unit_name']."",
			"date_time_request" => "".DateThaiTime($val_eform['request_information'][$i]['date_time'])."",
		);

		$i++;
	}
}


$token = "asdasdqe2ewsdtRFDWRQKFLmf36ddasdasdasdas";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($data);

}
?>