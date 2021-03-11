<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$id = $_GET['id'];

$today = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE id = '".$id."' ")->queryAll();
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

	$history = array();

	foreach ($dta['history'] as $hit) {
		$users = Yii::$app->db->createCommand("SELECT * FROM `users` WHERE name = '".$hit['user_view']."'")->queryOne();
		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$users['unit_id']."'")->queryOne();

		$history[] = array(
			"date_time" => "".$hit['date_time']."",
			"user_view" => "".$hit['user_view']."",
			"unit_name" => "".$hit['unit_name']."",
			"action" => "".$hit['action']."",
			"img_user" => "../../frontend/web/uploads/".$users['images']."",
			"date_thai" => "".dateThai($hit['date_time']).""
		);
	}

	$i++;
}
	
	//var_dump($history);

 	echo $someJSON = json_encode($history);



?>