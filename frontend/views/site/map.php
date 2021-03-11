<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

$data_array = array();
if($type=='all'){
    $unit_data = Yii::$app->db->createCommand("SELECT * FROM `organization` WHERE coor_lat != '' AND coor_lon != ''")->queryAll();
	foreach ($unit_data as $value) {
		$type = Yii::$app->db->createCommand("SELECT * FROM `organization_type` WHERE id = '".$value['type']."'")->queryOne();
		$district = Yii::$app->db->createCommand("SELECT * FROM `district` WHERE id = '".$value['district']."'")->queryOne();
		$amphure = Yii::$app->db->createCommand("SELECT * FROM `amphures` WHERE id = '".$value['amphure']."'")->queryOne();
		$province = Yii::$app->db->createCommand("SELECT * FROM `provinces` WHERE id = '".$value['province']."'")->queryOne();
		$data2[] = array(
			'name'=> "".$value['name']."",
			'detail'=> "".$value['unit_name']."",
			'type'=> "".$type['type']."",
			'marker_color'=> "".$type['marker_color']."",
			'address'=> "".$value['address']."",
			'village'=> "".$value['village']."",
			'district'=> "".$district['name_th']."",
			'amphure'=> "".$amphure['name_th']."",
			'province'=> "".$province['name_th']."",
			'lat'=> floatval($value['coor_lat']),
			'lon'=> floatval($value['coor_lon']),
		);
	}

}


if($type=='search'){

	if(!empty($_GET['unitname']) && empty($_GET['unitid'])){
		$sql = "SELECT * FROM `unit` WHERE lat != '' AND lon != '' AND unit_name LIKE '%".$_GET['unitname']."%'";
	}else if(empty($_GET['unitname']) && !empty($_GET['unitid'])){
		$sql = "SELECT * FROM `unit` WHERE lat != '' AND lon != '' AND unit_id = '".$_GET['unitid']."'";
	}else if(!empty($_GET['unitname']) && !empty($_GET['unitid'])){
		$sql = "SELECT * FROM `unit` WHERE lat != '' AND lon != '' AND unit_id = '".$_GET['unitid']."' AND unit_name LIKE '%".$_GET['unitname']."%'";
	}else{
		$sql = "SELECT * FROM `unit` WHERE lat != '' AND lon != ''";
	}


	$unit_data = Yii::$app->db->createCommand($sql)->queryAll();

	foreach ($unit_data as $value) {
		$data_array[] = array(
			'unit_id'=> "".$value['unit_id']."",
			'unit_name'=> "".$value['unit_name']."",
			'unit_detail'=> "".$value['unit_detail']."",
			'address'=> "".$value['address']."",
			'province'=> "".$value['province']."",
			'lat'=> floatval($value['lat']),
			'lon'=> floatval($value['lon']),
		);
	}
}

echo json_encode($data_array);
?>