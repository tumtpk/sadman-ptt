<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if($type=='get_amphures'){
	$amphures = Yii::$app->db->createCommand("SELECT * FROM `amphures` WHERE province_id = '".$_GET['province_id']."'")->queryAll();
	echo '<option value="">
			เลือกอำเภอ
			</option>';
	foreach ($amphures as $amp) {
		$selected = '';
		if ($_GET['idselect']!='') {
			$selected = ($_GET['idselect']==$amp['id']) ? 'selected' : '';
		}
		echo '<option value="'.$amp['name_th'].'" data-id="'.$amp['id'].'" data-code="'.$amp['code'].'" '.$selected.'>
			'.$amp['name_th'].'
			</option>';
	}
}


if($type=='get_districts'){
	// echo "SELECT * FROM `districts` WHERE amphure_id = '".$_GET['amphure_id']."'";
	$districts = Yii::$app->db->createCommand("SELECT * FROM `districts` WHERE amphure_id = '".$_GET['amphure_id']."'")->queryAll();
	echo '<option value="">
			เลือกตำบล
			</option>';
	foreach ($districts as $dis) {
		$selected = '';
		if ($_GET['idselect']!='') {
			$selected = ($_GET['idselect']==$dis['id']) ? 'selected' : '';
		}
		// echo $_GET['idselect']." - ".$dis['id'];
		echo '<option value="'.$dis['name_th'].'" data-id="'.$dis['id'].'" data-code="'.$dis['zip_code'].'" '.$selected.'>
			'.$dis['name_th'].'
			</option>';
	}
}
?>