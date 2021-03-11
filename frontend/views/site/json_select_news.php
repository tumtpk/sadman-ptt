<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$date_search = isset($_GET['date_search']) ?  $_GET['date_search'] : (isset($_POST['date_search']) ? $_POST['date_search'] : '');

$text_search = isset($_GET['text_search']) ?  $_GET['text_search'] : (isset($_POST['text_search']) ? $_POST['text_search'] : '');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

$id_array = isset($_GET['id_array']) ?  $_GET['id_array'] : (isset($_POST['id_array']) ? $_POST['id_array'] : '');


if($type=='now'){
	$date_now = date('Y-m-d');
	$query = Yii::$app->db->createCommand("SELECT eform_data.form_id , eform_data.id, eform_data.data_json FROM `eform_data`,`eform_template` WHERE eform_data.form_id = eform_template.id AND eform_template.type IN ('2','4') AND eform_data.data_json LIKE '%\"date_record\":\"".$date_now."%'")->queryAll();

	$showdata = getdata($query);
}

if($type=='search_value'){

	if (!empty($date_search) && empty($text_search)) {
		$WHERE = "AND eform_data.data_json LIKE '%\"date_record\":\"".$date_search."%'";
	}else{
		$WHERE = "AND eform_data.data_json LIKE '%\"date_record\":\"".$date_search."%' AND eform_data.data_json LIKE '%".$text_search."%'";
	}
	$query = Yii::$app->db->createCommand("SELECT eform_data.form_id , eform_data.id, eform_data.data_json FROM `eform_data`,`eform_template` WHERE eform_data.form_id = eform_template.id AND eform_template.type IN ('2','4') $WHERE")->queryAll();
	$showdata = getdata($query);
}

if($type=='showdata'){
	$id_news = implode(",",$id_array);
	$id_news = str_replace(",","','",$id_news);
	$query = Yii::$app->db->createCommand("SELECT eform_data.form_id , eform_data.id, eform_data.data_json FROM `eform_data`,`eform_template` WHERE eform_data.form_id = eform_template.id AND eform_template.type IN ('2','4') AND eform_data.id IN ('".$id_news."')")->queryAll();
	$showdata = getdata($query);
}


function getdata($array_data)
{
	$data = array();
	$i = 1;
	foreach ($array_data as $cols){

		$show = '';
		$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE id = '".$cols['form_id']."'")->queryOne();
		$data_main = @json_decode($query['form_element'],TRUE);

		$data_object = @json_decode($cols['data_json'],TRUE);
		$dta = $data_object[0];

		$approve_template = Yii::$app->db->createCommand("SELECT approve_template.step FROM eform,eform_template,approve_template WHERE eform.id = '".$cols['eform_id']."' AND eform.form_id = '".$cols['form_id']."' AND eform.form_id = eform_template.id AND eform_template.approve_type = approve_template.id")->queryScalar();
		$object_approve_template = @json_decode($approve_template,TRUE);

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
			if (!empty($dta['request_information'])) {
				if(count($dta['request_information'])>0){
					$n_request_information = count($dta['request_information'])-1;
					$text_request_information = '<span class="badge badge-dark"><b>ข้อมูลที่ต้องการเพิ่มเติม </b></span> : <span class="badge badge-light text-dark" style="">'.$dta['request_information'][$n_request_information]['detail'].'</span>';
				}
			}
			$status = '<span class="tag tag-danger" style="    background-color: #db2828 !important;">ยังไม่ได้รับการอนุมัติ</span> <br>'.$text_request_information;
			$select_approve = 'ยังไม่ได้รับการอนุมัติ';
		}


		$data[] = array(
			"no" => "".$i."",
			"id" => $cols['id'],
			"data" => $show,
			"form_id"=> $dta['form_id'],
			"eform_id"=> $dta['eform_id'],
			"eform_version"=> $dta['eform_version'],
			"user_create_name"=> $dta['user_create_name'].' ('.$dta['unit_name'].')',
			"unit_name"=> $dta['unit_name'],
			"date_record"=> DateThai($dta['date_record']),

		);
		$i++;
	}

	return $data;

}


$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($showdata);
}
?>