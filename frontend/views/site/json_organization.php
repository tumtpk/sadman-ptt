<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if ($type=='organization_type') {

	$data = array();  
	$organization = Yii::$app->db->createCommand("SELECT organization_type.id AS id_organization_type, organization_type.type AS name_organization_type, organization_type.marker_color AS marker_color FROM organization_type,organization WHERE organization.type = organization_type.id GROUP BY organization_type.id ")->queryAll();
	foreach ($organization as $value) {
		$query = Yii::$app->db->createCommand("SELECT COUNT(id) AS sum FROM `organization` WHERE type = '".$value['id_organization_type']."'")->queryOne();
		$data[] = array(
            "type" => $value['name_organization_type'],
			"marker_color" => $value['marker_color'],
			"id" => $value['id_organization_type'],
			"sum"=>(int)$query['sum']
		);
	 }

}

if ($type=='provinces') {

	
	$data = array();
	$organization = Yii::$app->db->createCommand("SELECT provinces.id AS id_provinces, provinces.name_th AS name_th FROM provinces,organization WHERE organization.province = provinces.id GROUP BY provinces.id ")->queryAll();
	foreach ($organization as $value) {
		$query = Yii::$app->db->createCommand("SELECT COUNT(id) AS sum FROM `organization` WHERE province = '".$value['id_provinces']."'")->queryOne();
		$data[] = array(
            "name" => $value['name_th'],
            "id" => $value['id_provinces'],
			"sum"=>(int)$query['sum']
		);
	 }
}


if($type=='all'){

	$data = array();
	$unit_data = Yii::$app->db->createCommand("SELECT * FROM `organization` WHERE coor_lat != '' AND coor_lon != ''")->queryAll();
	foreach ($unit_data as $value) {
		$type = Yii::$app->db->createCommand("SELECT * FROM `organization_type` WHERE id = '".$value['type']."'")->queryOne();
		$district = Yii::$app->db->createCommand("SELECT * FROM `districts` WHERE id = '".$value['district']."'")->queryOne();
		$amphure = Yii::$app->db->createCommand("SELECT * FROM `amphures` WHERE id = '".$value['amphure']."'")->queryOne();
		$province = Yii::$app->db->createCommand("SELECT * FROM `provinces` WHERE id = '".$value['province']."'")->queryOne();
		$data[] = array(
			"id" => $value['id'],
			"name" => $value['name'],
            "detail" => $value['unit_name'],
			"type"=> $type['type'],
			"marker_color" => $type['marker_color'],
            "address" => $value['address'],
			"village"=> $value['village'],
			"district" => $district['name_th'],
            "amphure" => $amphure['name_th'],
			"province"=> $province['name_th'],
			"lat" => floatval($value['coor_lat']),
            "lon" => floatval($value['coor_lon'])
			
		);
	}

}

if ($type=='Terrorist_type') {

	$data = array();
	$userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `eform_data` WHERE form_id = '21'")->queryScalar();
	$Terrorist_type = Yii::$app->db->createCommand("SELECT * FROM `Terrorist_type`")->queryAll();
	foreach ($Terrorist_type as $value) {
		$b = Yii::$app->db->createCommand("SELECT COUNT(id) AS sum FROM `eform_data` WHERE form_id = '21' AND data_json LIKE '%\"Terrorist_type\":\"".$value['type']."%'")->queryOne();
		$percent = ($b['sum']/$userAll) * 100;


		$data[] = array(
            "name" => $value['type'],
            "id" => $value['id'],
			"count"=>(int)$percent,
			"sum"=>(int)$userAll,
		);
	 }
}



$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($data);
}



?>


