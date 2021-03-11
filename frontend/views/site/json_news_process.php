<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');


if ($type=='boxstat') {

	$today_sum = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '16'")->queryAll();
	$notify_sum = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '17'")->queryAll();

	$date_now = date('Y-m-d');
	$today = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '16' AND data_json LIKE '%\"date_record\":\"".$date_now."%'")->queryAll();
	$notify = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '17' AND data_json LIKE '%\"date_record\":\"".$date_now."%'")->queryAll();
	$today_to_unit = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id IN ('16','17') AND data_json LIKE '%unit-send-news%'")->queryAll();
	$send_to_unit = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id IN ('16','17') AND data_json NOT LIKE '%unit-send-news%'")->queryAll();

	$countAll = count($today_sum)+count($notify_sum);
	$today_sum = count($today_sum);
	$notify_sum = count($notify_sum);
	$send_to_unit = count($send_to_unit);
	$today_to_unit = count($today_to_unit);
	$today_sum_per = ($today_sum/$countAll)*100;
	$sumNotify_per = ($notify_sum/$countAll)*100;
	$toUnit_per = ($today_to_unit/$countAll)*100;



	$data['countAll'] = $countAll;
	$data['sumToDay'] = $today_sum;
	$data['sumNotify'] = $notify_sum;
	$data['toUnit'] = $today_to_unit;
	$data['sumToDay_per'] = number_format($today_sum_per, 2, '.', '').'%';
	$data['sumNotify_per'] = number_format($sumNotify_per, 2, '.', '').'%';
	$data['toUnit_per'] = number_format($toUnit_per, 2, '.', '').'%';



}

if ($type=='newstoday') {

	$date_now = date('Y-m-d');
	$today = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '16' AND data_json LIKE '%\"date_record\":\"".$date_now."%'")->queryAll();
	$i=1;
	$data = array();
	foreach ($today as $td) { 
		$show = '';
		$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE id = '".$td['form_id']."'")->queryOne();
		$data_main = @json_decode($query['form_element'],TRUE);

		$data_object = @json_decode($td['data_json'],TRUE);
		$dta = $data_object[0];
		$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step FROM eform_template,approve_template WHERE eform_template.id = '".$td['eform_id']."' AND eform_template.approve_type = approve_template.id")->queryScalar();
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

		if(!empty($dta['unit-send-news'])){
			$att_group = implode(",",$dta['unit-send-news']);
			$unit = getList($att_group,'unit','unit_id','unit_name');
		}else{
			$unit = "-";
		}

		$data[] = array(
			"no" => "".$i."",
			"detail" => "".$show."",
			"tounit" => "".$unit."",
			"link" => "".$td['id'].""
		);

		$i++;
	}


}

if ($type=='newsnotify') {

	$date_now = date('Y-m-d');
	$today = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '17' AND data_json LIKE '%\"date_record\":\"".$date_now."%' ")->queryAll();
	$i=1;
	$data = array();
	foreach ($today as $td) { 
		$show = '';
		$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE id = '".$td['form_id']."'")->queryOne();
		$data_main = @json_decode($query['form_element'],TRUE);

		$data_object = @json_decode($td['data_json'],TRUE);
		$dta = $data_object[0];
		$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step FROM eform_template,approve_template WHERE eform_template.id = '".$td['eform_id']."' AND eform_template.approve_type = approve_template.id")->queryScalar();
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

		if(!empty($dta['unit-send-news'])){
			$att_group = implode(",",$dta['unit-send-news']);
			$unit = getList($att_group,'unit','unit_id','unit_name');
		}else{
			$unit = "-";
		}

		$data[] = array(
			"no" => "".$i."",
			"detail" => "".$show."",
			"tounit" => "".$unit."",
			"link" => "".$td['id'].""
		);

		$i++;
	}


}

// $token = "2ffa459adcc37176dbf93a82addf61dc";
// $auth = "Authenticator=>".$token."".date("Ymd");
// if(isset($_GET['auth']) && $_GET['auth'] == $auth){
echo $someJSON = json_encode($data);
// }
?>