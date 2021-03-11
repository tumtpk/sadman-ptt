<?php
header("Content-Type: application/json; charset=UTF-8");


$data = array();
$query = Yii::$app->db->createCommand("SELECT COUNT(*) AS count,create_date FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND MONTH(create_date) = MONTH(CURRENT_DATE()) GROUP BY create_date")->queryAll();

foreach($query as $q){

	$data[] = array(
		"count" =>  (int)$q['count'],
		"log_date" => "".DateThai($q['create_date'])."",
	);
}
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($data);

}
?>


