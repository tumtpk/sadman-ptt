<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

$data_array = array();
if($type=='all'){
	$unit_data = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE lat != '' AND lon != ''")->queryAll();
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