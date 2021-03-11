<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$unitid = isset($_GET['unitid']) ?  $_GET['unitid'] : (isset($_POST['unitid']) ? $_POST['unitid'] : '');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if ($type=='usersgroup' && $unitid!='') {

	$where_user = '';
	$where_group = '';
	if ($unitid!='000') {
		$where_user = "WHERE unit_id = '".$unitid."'";
		$where_group = "AND users.unit_id = '".$unitid."'";
	}
	$data = array();
	$userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users $where_user")->queryScalar();


	$user_group = Yii::$app->db->createCommand("SELECT user_group.id AS id, user_group.name AS name, COUNT(*) AS sum, user_group.description AS detail, users.unit_id AS unit_id FROM `users`,`user_group` WHERE users.user_group = user_group.id $where_group GROUP BY users.user_group ORDER BY user_group.name ASC")->queryAll();
	$i=1;
	foreach ($user_group as $ug) {

		$where_show_user = '';
		if ($unitid!='000') {
			$where_show_user = "AND users.unit_id = '".$ug['unit_id']."'";
		}

		$user = Yii::$app->db->createCommand("SELECT users.id AS id_user, users.name AS name, users.email AS email, users.status AS user_status FROM `users`,`user_group` WHERE users.user_group = user_group.id $where_show_user AND user_group.id = '".$ug['id']."'")->queryAll();

		$percent = ($ug['sum']/$userAll) * 100;

		$data[] = array(
			"sum" =>  (int)$ug['sum'],
			"percent" =>  (int)$percent,
			"name_group" => "".$ug['name']."",
			"detail_group" => "".$ug['detail']."",
			"show_user" => $user,
		);
	}

}

if ($type=='clse_user') {
	if (isset($_POST['iduser'])) {
		$query = Yii::$app->db->createCommand("UPDATE users SET status = '".$_POST['user_status']."' WHERE id = '".$_POST['iduser']."'");
		if ($query->execute()) {
			$data['output'] = 1;
		}else{
			$data['output'] = 0;
		}
	}
}


$token = "qw37176dbf9WAQSAD3a82aqweQSGTadc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($data);
}

?>