<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if ($type=='card-stat') {

	$equipment_all = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment`")->queryScalar();
	$equipment_type = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_type`")->queryScalar();
	$equipment_disbursement = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_disbursement`")->queryScalar();
	$disbursement = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_disbursement` WHERE date_time !=''")->queryScalar();
	$not_repatriate = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_disbursement` WHERE date_time_repatriate IS NULL ")->queryScalar();
	$repatriate = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_disbursement` WHERE date_time_repatriate IS NOT NULL ")->queryScalar();

		$resultArray = array(
			'equipment_all' => "".number_format($equipment_all)."",
			'equipment_type' => "".number_format($equipment_type)."",
			'equipment_disbursement' => "".number_format($equipment_disbursement)."",
			'disbursement' => "".number_format($disbursement)."",
			'not_repatriate' => "".number_format($not_repatriate)."",
			'repatriate' => "".number_format($repatriate)."",

		);


	echo json_encode($resultArray);

}

if ($type=='type') {

	$query = "SELECT equipment_type.name AS name,COUNT(*) AS sum FROM `equipment`,`equipment_type` WHERE equipment.type = equipment_type.id GROUP BY equipment.type";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {
		$count ++;

		$resultArray[]
		 = array(
			'value' => $row['sum'],
			'name' => $row['name'],
		);


		$i++;
	}

	echo json_encode($resultArray);

}

if ($type=='equipment-stat') {

	$equipment_all = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_sn`")->queryScalar();
	$equipment_dis = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_sn` WHERE status = 1")->queryScalar();
	$equipment_damaged = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_sn` WHERE status = 2")->queryScalar();
	$equipment_repair = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `equipment_sn` WHERE status = 3")->queryScalar();
	

		$resultArray = array(
			'equipment_all' => "".number_format($equipment_all)."",
			'equipment_dis' => "".number_format($equipment_dis)."",
			'equipment_damaged' => "".number_format($equipment_damaged)."",
			'equipment_repair' => "".number_format($equipment_repair)."",

		);


	echo json_encode($resultArray);

}


if ($type=='topten-equipment') {

	$query = "SELECT equipment_sn.id_main AS id, equipment_sn.serial_number AS name, COUNT(*) AS sum FROM `equipment_disbursement`,`equipment_sn` WHERE equipment_disbursement.id_sub = equipment_sn.id GROUP BY equipment_sn.serial_number ORDER BY sum DESC LIMIT 10";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {
		$equipment = Yii::$app->db->createCommand("SELECT * FROM `equipment` WHERE id = '".$row['id']."'")->queryOne();
		$count ++;

		$resultArray[] = array(
			'no' => "".$i."",
			'id_main' => $row['id'],
			'equipment_name' => $equipment['name'].'-'.$row['name'],
			'serial_number' => $row['name'],
			'sum' => number_format($row['sum']),
		);


		$i++;
	}

	echo json_encode($resultArray);

}

if ($type=='topten-unit') {

	$query = "SELECT unit_id AS unit, COUNT(*) AS sum FROM `equipment_disbursement` GROUP BY unit_id ORDER BY sum DESC LIMIT 10";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {
		$count ++;

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit']."'")->queryOne();

		$resultArray[] = array(
			'no' => "".$i."",
			'name' => $unit['unit_name'],
			'sum' => number_format($row['sum']),
		);

		$i++;
	}

	echo json_encode($resultArray);

}

if ($type=='count-year') {

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
		$query = Yii::$app->db->createCommand("SELECT COUNT(*) AS sum FROM `equipment_disbursement` WHERE date_time LIKE '".$date_y."-".$value."-%'")->queryOne();
		$data[] = array(
			"months" => $months_detail[$value],
			"sum"=>(int)$query['sum']
		);

	 }

	echo json_encode($data);

}
?>