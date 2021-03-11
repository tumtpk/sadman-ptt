<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');
$userid = isset($_GET['userid']) ?  $_GET['userid'] : (isset($_POST['userid']) ? $_POST['userid'] : '');
$data = array();
$data_all = array();
$eform_data = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE data_json LIKE '%\"unit-send-news\":[%".$_SESSION['unit_id']."\"%' AND form_id IN ('16','17') ORDER BY date_time DESC")->queryAll();

foreach ($eform_data as $ed) {
	$data_edata = @json_decode($ed['data_json'],TRUE);
	$val_eform = $data_edata[0];
	
	$show = '';
	$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE id = '".$ed['form_id']."'")->queryOne();
	$data_main = @json_decode($query['form_element'],TRUE);

	$data_object = @json_decode($ed['data_json'],TRUE);
	$dta = $data_object[0];
	$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step FROM eform_template,approve_template WHERE eform_template.id = '".$ed['eform_id']."' AND eform_template.approve_type = approve_template.id")->queryScalar();
	$object_approve_template = @json_decode($approve_template,TRUE);

	$count_row = 1;
	foreach ($data_main[0]['fieldGroup'] as $col){

		if ($count_row<=1) {

			if ($col['type']=='select') {
				if ($col['templateOptions']['model']!=null) {
					$show .= $col['templateOptions']['placeholder']." : ".$dta[$col['key']]."<br>";
				}else{
					$show .= $col['templateOptions']['placeholder']." : ".$dta[$col['key']]."<br>";
				}
			}else if ($col['type']=='input') {
				if ($col['templateOptions']['type']=='date'){
					$show .= $col['templateOptions']['placeholder']." : ".DateThai($dta[$col['key']])."<br>";
				}else if ($col['templateOptions']['type']=='radio'){
					$show .= $col['templateOptions']['placeholder']." : ".$dta[$col['key']]."<br>";
				}else if ($col['templateOptions']['type']=='checkbox'){
					if(count($dta[$col['key']])>0){
						$show_checkbox ='';
						foreach ($dta[$col['key']] as $value) {
							$show_checkbox .= $value.", ";
						}
						$show .=  $col['templateOptions']['placeholder']." : ".rtrim($show_checkbox, ", ")."<br>";
					}
				}else{
					$show .= $col['templateOptions']['placeholder']." : ".$dta[$col['key']]."<br>";
				}
			}else if ($col['type']=='latlong') {
				$show .= $col['templateOptions']['placeholder']." : ".$dta['latitude'].", ".$dta['longitude']."<br>";
			}else if ($col['type']=='address') {
				$nameaddress = $col["key"];
				$nameaddress_no = $nameaddress."_no";
				$nameaddress_mooban = $nameaddress."_mooban";
				$nameaddress_tombon = $nameaddress."_tombon";
				$nameaddress_amphoe = $nameaddress."_amphoe";
				$nameaddress_province = $nameaddress."_province";
				$show .= $col['templateOptions']['placeholder']." : เลขที่ ".$dta[$nameaddress_no]." หมู่บ้าน .".$dta[$nameaddress_mooban]." ต.".$dta[$nameaddress_tombon]." อ.".$dta[$nameaddress_amphoe]." จ.".$dta[$nameaddress_province]."<br>";
			}else{
				$show .= $col['templateOptions']['placeholder']." : ".$dta[$col['key']]."<br>";
			}

		}
		$count_row++;
	}

	$check_accept = 0;
	if ($_SESSION['user_role']=='1'){
		$check_accept = 0;
	}else{
		$check_accept = (in_array($_SESSION['unit_id'], $val_eform['unit-send-news'])) ? 1:0;
	}

	if ($check_accept>0) {
		
		$data_all[] = array(
			"id" => "".$ed['id']."",
			"name" => "".$show."",
		);

		if(!empty($val_eform['unit_accept_news'])){
			$searchedValue = $_SESSION['user_id']; 
			$neededObject = array_filter(
				$val_eform['unit_accept_news'],
				function ($e) use ($searchedValue) {
					return $e['user_accept_id'] == $searchedValue;
				}
			);
			if (count($neededObject)>0) {
				$data[] = array(
					"id" => "".$ed['id']."",
					"name" => "".$show."",
				);
			}
			
		}

	}

}


function compare_objects($obj_a, $obj_b) {
	return $obj_a["id"] - $obj_b["id"];
}
$diff = array_udiff($data_all, $data, 'compare_objects');

$data_obj = array(); 
foreach ($diff  as $di ) {
	$data_obj[] = array(
		'id' => "".$di['id']."",
		'name' => "".$di['name']."",
	);
}

$token = "asdasdqe2ewsdtRFDWRQKFLmf36ddasdasdasdas";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($data_obj);

}

?>