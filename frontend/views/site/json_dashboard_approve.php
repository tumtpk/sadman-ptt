<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$_SESSION['unit_id']."'")->queryOne();

$data = array();

if ($type=='showdataall') {
	$query = Yii::$app->db->createCommand("SELECT eform_data.form_id AS eform_data_form_id, eform_data.id AS eform_data_id, eform_data.eform_id AS eform_data_eform_id, eform_data.data_json AS eform_data_data_json FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%' ORDER BY eform_data.date_time")->queryAll();
	$i = 1;
	foreach ($query as $cols){

		$show = '';
		$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE id = '".$cols['eform_data_form_id']."'")->queryOne();
		$data_main = @json_decode($query['form_element'],TRUE);

		$data_object = @json_decode($cols['eform_data_data_json'],TRUE);
		$dta = $data_object[0];

		$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step AS step_template , eform_template.detail AS edetail FROM eform_template,approve_template WHERE eform_template.id = '".$cols['eform_data_form_id']."' AND eform_template.approve_type = approve_template.id")->queryOne();
		$object_approve_template = @json_decode($approve_template['step_template'],TRUE);

		$count_row = 1;
		foreach ($data_main[0]['fieldGroup'] as $col){

			if ($count_row<=3) {

			if ($col['type']=='select') {
				if ($col['templateOptions']['model']!=null) {
					$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".$dta[$col['key']]."<br>";
				}else{
					$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".$dta[$col['key']]."<br>";
				}
			}else if ($col['type']=='input') {
				if ($col['templateOptions']['type']=='date'){
					$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".DateThai($dta[$col['key']])."<br>";
				}else if ($col['templateOptions']['type']=='radio'){
					$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".$dta[$col['key']]."<br>";
				}else if ($col['templateOptions']['type']=='checkbox'){
					if(count($dta[$col['key']])>0){
						$show_checkbox ='';
						foreach ($dta[$col['key']] as $value) {
							$show_checkbox .= $value.", ";
						}
						$show .=  "<b>".$col['templateOptions']['placeholder']."</b> : ".rtrim($show_checkbox, ", ")."<br>";
					}
				}else{
					$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".$dta[$col['key']]."<br>";
				}
			}else if ($col['type']=='latlong') {
				$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".$dta['latitude'].", ".$dta['longitude']."<br>";
			}else if ($col['type']=='address') {
				$nameaddress = $col["key"];
				$nameaddress_no = $nameaddress."_no";
				$nameaddress_mooban = $nameaddress."_mooban";
				$nameaddress_tombon = $nameaddress."_tombon";
				$nameaddress_amphoe = $nameaddress."_amphoe";
				$nameaddress_province = $nameaddress."_province";
				$show .= "<b>".$col['templateOptions']['placeholder']."</b> : เลขที่ ".$dta[$nameaddress_no]." หมู่บ้าน .".$dta[$nameaddress_mooban]." ต.".$dta[$nameaddress_tombon]." อ.".$dta[$nameaddress_amphoe]." จ.".$dta[$nameaddress_province]."<br>";
			}else{
				$show .= "<b>".$col['templateOptions']['placeholder']."</b> : ".$dta[$col['key']]."<br>";
			}

			}
			$count_row++;
		}

		$user = Yii::$app->db->createCommand("SELECT * FROM `users` WHERE id = '".$dta['user_create_id']."'")->queryOne();
		$show .= "<b>ผู้บันทึก</b> : ".$dta['user_create_name']." (".$dta['unit_name'].")<br>";
		$check_status = array('<span style="color: #dc3545;"><b>ข้อมูลยังไม่ได้รับการตรวจสอบ</b></span>','<span style="color: #28a745;"><b>รับทราบข้อมูลแล้ว</b></span>','<span style="color: #e28f00;"><b>ไม่อนุญาตให้เผยแพร่ข้อมูล</b></span>');
		// $show .= "<b>Form Version</b> : ".$dta['eform_version']."<br>";

		// if($dta['approve']==''){
		// 	$show .= "<b>สถานะ</b> : ".$check_status[0];
		// }else{
		// 	$show .= "<b>สถานะ</b> : <br>";
		// 	foreach ($dta['approve'] as $value) {
		// 		$show .= "วันที่".$object_approve_template[0][$value['step']]." : ".DateThaiTime($value['date_time'])."<br>
		// 		ผู้".$object_approve_template[0][$value['step']]." : ".$value['user_approve']."";

		// 		if (!empty($value['unit_name'])){

		// 			$show .= "
		// 			<br>
		// 			หน่วยที่".$object_approve_template[0][$value['step']]." : ".$value['unit_name']."<br><br>";
		// 		}

		// 	}
		// }
		

		$n = (!empty($dta['approve'])) ? count($dta['approve']) : 0;
		$ii = $n-1;

		if ($dta['approve'] != '') {
			if (count($dta['approve'])==count($object_approve_template[0])) {
				$status = '<span class="tag tag-success">ได้รับการอนุมัติข่าวแล้ว</span>';
				$select_approve = 'ได้รับการอนุมัติข่าวแล้ว';
			}else{
				$text_status = $object_approve_template[0][$dta['approve'][$ii]['step']];
				$status = '<span class="tag tag-warning">'.$text_status.'</span>';
				$select_approve = $text_status;
			}

		}else{
			$text_request_information = '';
			if (!empty($dta['request_information'])){
			if(count($dta['request_information'])>0){
				$n_request_information = count($dta['request_information'])-1;
				$text_request_information = (strlen ($dta['request_information'][$n_request_information]['detail']) > 80) ? iconv_substr($dta['request_information'][$n_request_information]['detail'], 0,80, "UTF-8"). "....":$dta['request_information'][$n_request_information]['detail'];
				$text_request_information = '<span class="badge badge-dark"><b>ข้อมูลที่ต้องการเพิ่มเติม </b></span> : <span class="badge badge-light text-dark" style="">'.$text_request_information.'</span>';
				$select_approve = 'ข้อมูลที่ต้องการเพิ่มเติม';
			}else{
				$select_approve = 'ยังไม่ได้รับการอนุมัติ';
			}

			}else{
				$select_approve = 'ยังไม่ได้รับการอนุมัติ';
			}
			$status = '<span class="tag tag-danger" style="    background-color: #db2828 !important;">ยังไม่ได้รับการอนุมัติ</span> <br>'.$text_request_information;
			
		}


		$data[] = array(
			"no" => "".$i."",
			"data" => $show,
			"eform_detail"=> $approve_template['edetail'],
			"form_id"=> $dta['form_id'],
			"eform_id"=> $dta['eform_id'],
			"eform_version"=> $dta['eform_version'],
			"user_create_name"=> $dta['user_create_name'].' ('.$dta['unit_name'].')',
			"unit_name"=> $dta['unit_name'],
			"date_record"=> $dta['date_record'],
			"approve"=> $status,
			"select_approve"=> $select_approve,
			"link"=> '<a class="btn btn-light btn-sm" href="index.php?r=eform-data/approve_status&id='.$cols['eform_data_id'].'" style="white-space: nowrap;"><i class="fas fa-eye"></i> รายละเอียด</a>'
		);
		$i++;
	}

}


if ($type=='countdataall') {
	$query_count = Yii::$app->db->createCommand("SELECT COUNT(eform_data.id) AS sum FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%'")->queryOne();
	$data['coutertype'] = $query_count['sum'];
}


if ($type=='countdataapprove') {
	$query = Yii::$app->db->createCommand("SELECT * FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%'")->queryAll();
	$num = 0;
	foreach ($query as $col){
		$data_main = @json_decode($col['data_json'],TRUE);

		$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step FROM eform_template,approve_template WHERE eform_template.id = '".$data_main[0]['form_id']."' AND eform_template.approve_type = approve_template.id")->queryScalar();
		$object_approve_template = @json_decode($approve_template,TRUE);

		if ($data_main[0]['approve']!='') {
			if (count($data_main[0]['approve'])==count($object_approve_template[0])) {
				$num = $num+1;
			}
		}
	}
	$data['coutertype'] = $num;

}

if ($type=='countdatanotapprove') {
	$query2 = Yii::$app->db->createCommand("SELECT * FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%'")->queryAll();
	$num2 = 0;
	foreach ($query2 as $col2){
		$data_main2 = @json_decode($col2['data_json'],TRUE);
		if ($data_main2[0]['approve']=='') {
			$num2 = $num2+1;
		}
	}

	$data['coutertype'] = $num2;
}

if ($type=='countdatarequest') {
	$checkdata = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `eform_data` WHERE data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%' AND data_json LIKE '%\"request_information\":%' AND data_json LIKE '%\"approve\":\"\"%' ORDER BY date_time DESC")->queryScalar();
	$data['coutertype'] = $checkdata;
}

if ($type=='persent') {
	$query_count = Yii::$app->db->createCommand("SELECT COUNT(eform_data.id) AS sum FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%'")->queryOne();
	$countdataall = $query_count['sum'];
	
	$query = Yii::$app->db->createCommand("SELECT * FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%'")->queryAll();
	$num = 0;
	foreach ($query as $col){
		$data_main = @json_decode($col['data_json'],TRUE);

		$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step FROM eform_template,approve_template WHERE eform_template.id = '".$data_main[0]['form_id']."' AND eform_template.approve_type = approve_template.id")->queryScalar();
		$object_approve_template = @json_decode($approve_template,TRUE);

		if ($data_main[0]['approve']!='') {
			if (count($data_main[0]['approve'])==count($object_approve_template[0])) {
				$num = $num+1;
			}
		}
	}
	$countdataapprove = $num;

	$query2 = Yii::$app->db->createCommand("SELECT * FROM `eform_data`,`eform_template`,`approve_template`  WHERE eform_data.form_id = eform_template.id AND eform_template.approve_type != '' AND eform_template.approve_type = approve_template.id AND eform_data.data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%'")->queryAll();
	$num2 = 0;
	foreach ($query2 as $col2){
		$data_main2 = @json_decode($col2['data_json'],TRUE);
		if ($data_main2[0]['approve']=='') {
			$num2 = $num2+1;
		}
	}

	$countdatanotapprove = $num2;

	$checkdata = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `eform_data` WHERE data_json LIKE '%\"unit_id\":\"".$_SESSION['unit_id']."\"%' AND data_json LIKE '%\"request_information\":%' AND data_json LIKE '%\"approve\":\"\"%' ORDER BY date_time DESC")->queryScalar();
	$countdatarequest = $checkdata;

	$per_countdataapprove = ($countdataapprove/$countdataall) * 100;
	$per_countdatanotapprove = ($countdatanotapprove/$countdataall) * 100;
	$per_countdatarequest = ($countdatarequest/$countdataall) * 100;

	$data['countdataall'] = $countdataall;
	$data['countdataapprove'] = $countdataapprove;
	$data['countdatanotapprove'] = $countdatanotapprove;
	$data['countdatarequest'] = $countdatarequest;
	$data['per_countdataapprove'] = number_format($per_countdataapprove, 2, '.', '').'%';
	$data['per_countdatanotapprove'] = number_format($per_countdatanotapprove, 2, '.', '').'%';
	$data['per_countdatarequest'] = number_format($per_countdatarequest, 2, '.', '').'%';
}

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($data);
}
?>