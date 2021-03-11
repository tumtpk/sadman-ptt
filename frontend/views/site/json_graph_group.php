<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/json; charset=utf-8");
// header("Access-Control-Max-Age: 1000");
// header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
// header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

$data = array();
$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` where id not in (12,13,14,15,16,17,18,19) order by detail")->queryAll();
$i=1;
foreach($query as $q){

	$sub = array();
	$query_sub = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE id = '".$q['id']."'")->queryOne();
	$data_main = @json_decode($query_sub['form_element'],TRUE);
	$l = 0;
	foreach ($data_main[0]['fieldGroup'] as $col){

		$sub[] = array(
			"id" =>  "".$i.''.$l."",
			"sort" =>  "".$col['sort']."",
			"key" => "".$col['key']."",
			"label" => "".$col['templateOptions']['label'].""
		);

		$l++;

	}

	$data[] = array(
		"id" =>  "".$q['id']."",
		"name" => "".$q['detail']."",
		"detail" => $sub,

	);

	

	$i++;
}
// $token = "2ffa459adcc37176dbf93a82addf61dc";
// $auth = "Authenticator=>".$token."".date("Ymd");
// if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($data);

// }
?>
