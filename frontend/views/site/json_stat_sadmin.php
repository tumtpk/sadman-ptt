<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if ($type=='graphweek') {

	$data = array();
	$query = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum,create_date AS date_time FROM `user_log_usaged` WHERE DATEDIFF('".date("Y-m-d")."', create_date)<7 GROUP BY create_date")->queryAll();

	foreach($query as $q){

		$data[] = array(
			"sum" =>  (int)$q['sum'],
			"log_date" => "".DateThai($q['date_time'])."",
		);

	}

}

if ($type=='countusers') {

	$data = array();
	$userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role IN ('1','2','3')")->queryScalar();

	$sadmin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '1'")->queryScalar();
	$admin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '2'")->queryScalar();
	$users = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '3'")->queryScalar();

	$per_sadmin = ($sadmin/$userAll) * 100;
	$per_admin = ($admin/$userAll) * 100;
	$per_users = ($users/$userAll) * 100;

	$data['userall'] = $userAll;
	$data['sadmin'] = $sadmin;
	$data['admin'] = $admin;
	$data['users'] = $users;
	$data['per_sadmin'] = number_format($per_sadmin, 2, '.', '').'%';
	$data['per_admin'] = number_format($per_admin, 2, '.', '').'%';
	$data['per_users'] = number_format($per_users, 2, '.', '').'%';

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


