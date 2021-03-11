<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if ($type=='graphweek') {

	$date_m = date("m");
	$date_y = date("Y");
	$months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
	$months_detail = array(
		"01"=>"ม.ค.",
		"02"=>"ก.พ.",
		"03"=>"มี.ค.",
		"04"=>"เม.ษ.",
		"05"=>"พ.ค.",
		"06"=>"มิ.ย.",
		"07"=>"ก.ค.",
		"08"=>"ส.ค.",
		"09"=>"ก.ย.",
		"10"=>"ต.ค.",
		"11"=>"พ.ย.",
		"12"=>"ธ.ค."
	);
	// foreach ($months as $value) {
	$data = array();
	// $query = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_SESSION['user_id']."' AND log_date LIKE '".$date_y."-".$value."-%'")->queryOne();
	foreach ($months as $value) {
		$query = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_GET['id']."' AND log_date LIKE '".$date_y."-".$value."-%'")->queryOne();
		$data[] = array(
			"log_date" => $months_detail[$value],
			"sum"=>(int)$query['sum']
		);


	 }

}

if ($type=='countusers') {

	$date_d = date("Y-m-d");
	$date_m = date("m");
	$date_y = date("Y");
	$data = array();

		$useAll = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_GET['id']."'")->queryScalar();

		$useday = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_GET['id']."' AND create_date = '".$date_d."'")->queryScalar();
		$usemonths = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_GET['id']."' AND create_date LIKE '".$date_y."-".$date_m."-%'")->queryScalar();
		$useyear = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_GET['id']."' AND create_date LIKE '".$date_y."%'")->queryScalar();

		$per_useday = ($useday/$useAll) * 100;
		$per_usemonths = ($usemonths/$useAll) * 100;
		$per_useyear = ($useyear/$useAll) * 100;

		$data['useAll'] = $useAll;
		$data['useday'] = $useday;	
		$data['usemonths'] = $usemonths;
		$data['useyear'] = $useyear;
		$data['per_useday'] = number_format($per_useday, 2, '.', '').'%';
		$data['per_usemonths'] = number_format($per_usemonths, 2, '.', '').'%';
		$data['per_useyear'] = number_format($per_useyear, 2, '.', '').'%';
	
}

if ($type=='countmonths') {

	$date_m = date("m");
	$date_y = date("Y");
	$months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
	$months_detail = array(
		"01"=>"ม.ค.",
		"02"=>"ก.พ.",
		"03"=>"มี.ค.",
		"04"=>"เม.ษ.",
		"05"=>"พ.ค.",
		"06"=>"มิ.ย.",
		"07"=>"ก.ค.",
		"08"=>"ส.ค.",
		"09"=>"ก.ย.",
		"10"=>"ต.ค.",
		"11"=>"พ.ย.",
		"12"=>"ธ.ค."
	);
	$data = array();

	foreach ($months as $value) {
		$query = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE log_date LIKE '".$date_y."-".$value."-%'")->queryOne();
		$data[] = array(
			"months" => $months_detail[$value],
			"sum"=>(int)$query['sum']
		);

	}

}


$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($data);
}



?>


