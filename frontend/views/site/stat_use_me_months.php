<?php
header("Content-Type: application/json; charset=UTF-8");


// $date_m = date("m");
// $date_y = date("Y");
// $months = array($date_m);
$monthlys = array();
// foreach ($months as $value) {
	

// $query = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum,log_date FROM `user_log_usaged` WHERE MONTH(log_date) = '" . $value . "' AND log_date LIKE '".$date_y."%' AND username ='".$_SESSION['user_id']."' ")->queryOne();
// 	$monthlys[] = array(
// 		"sum" =>  (int)$query['sum'],
// 		"log_date" => "".$query['log_date']."",
//    );

// }

$query = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum,create_date AS date_time FROM `user_log_usaged` WHERE  username ='".$_SESSION['user_id']."' GROUP BY create_date")->queryAll();

foreach($query as $q){

	$monthlys[] = array(
		 		"sum" =>  (int)$q['sum'],
		 		"log_date" => "".DateThai($q['date_time'])."",
		    );
	
}

	$token = "2ffa459adcc37176dbf93a82addf61dc";
	$auth = "Authenticator=>".$token."".date("Ymd");
	if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($monthlys);

	}
?>


