<?php
header("Content-Type: application/json; charset=UTF-8");

$data = array();
$query = Yii::$app->db->createCommand("SELECT * FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."'")->queryAll();
$i=1;
foreach($query as $q){

	$data[] = array(
		"no" =>  "".$i."",
		"name" => "".$q['user']."",
		"unit" => "".$q['unit']."",
		"log_date" => "".DateThaiTime($q['log_date'])."",
		"create_date" => "".DateThai($q['create_date'])."",
		"ipaddress" => "".$q['ip_address']."",

	);

	$i++;
}
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($data);

}
?>


