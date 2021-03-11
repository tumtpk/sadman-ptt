<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');
$unitid = isset($_GET['unitid']) ?  $_GET['unitid'] : (isset($_POST['unitid']) ? $_POST['unitid'] : ''); 

if($type=='show' && $unitid!=''){
	$data = array();
	$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE disable = '0' ORDER BY id")->queryAll();
	$i=1;
	foreach($query as $q){
		$unit_id = str_replace("[","",$q['unit_id']);
		$unit_id = str_replace("]","",$unit_id);
		$unit_id = str_replace('"',"",$unit_id);
		$pieces_unit_id = explode(",", $unit_id);
		$checked = (in_array($unitid, $pieces_unit_id)) ? 'checked' : '';
		$data[] = array(
			"id" =>  "".$q['id']."",
			"type" => "".$q['type']."",
			"form_element" => "".$q['form_element']."",
			"version" => "".$q['version']."",
			"detail" => "".$q['detail']."",
			"unit_id" => "".$q['unit_id']."",
			"pieces_unit_id" => $pieces_unit_id,
			"checked" => $checked,
		);

		$i++;
	}

}


if($type=='update_data' && $unitid!=''){

	$data = array();
	for ($x = 0; $x < count($_POST['eform_id_check']); $x++) {


		$unit_id = str_replace("[","",$_POST['unit_id'][$_POST['eform_id_check'][$x]]);
		$unit_id = str_replace("]","",$unit_id);
		$unit_id_remove = str_replace('"',"",$unit_id);
		$pieces_unit_id = explode(",", $unit_id_remove);

		// if(in_array($unitid, $pieces_unit_id)){
		// 	$unit_id_new = '['.$unit_id.']';
		// }else{
		// 	$unit_id_new = (empty($unit_id)) ? '["'.$unitid.'"]' : '['.$unit_id.',"'.$unitid.'"]';
		// }
		
		// $checked = (in_array($_POST['eform_id_check'][$x], $_POST['checkbox_eform'])) ? $unit_id : '0';

		if (count($_POST['checkbox_eform'])>0) {
			if (in_array($_POST['eform_id_check'][$x], $_POST['checkbox_eform'])) {
				if(in_array($unitid, $pieces_unit_id)){
					$new_array = '['.$unit_id.']';
				}else{
					$new_array = (empty($unit_id)) ? '["'.$unitid.'"]' : '['.$unit_id.',"'.$unitid.'"]';
				}
			}else{
				if (count($pieces_unit_id)>1) {
					$array = array_diff($pieces_unit_id, [$unitid]);
					$new_array = implode('","',$array);
					$new_array = '["'.$new_array.'"]';
				}else{
					$new_array = "";
				}
			}
		}else{
			if (count($pieces_unit_id)>1) {
				$array = array_diff($pieces_unit_id, [$unitid]);
				$new_array = implode('","',$array);
				$new_array = '["'.$new_array.'"]';
			}else{
				$new_array = "";
			}

		}

		// $data[] = array(
		// 	"id" =>  "".$_POST['eform_id_check'][$x]."",
		// 	"new_array" => "".$new_array."",
		// );

		$query = Yii::$app->db->createCommand("UPDATE eform_template SET unit_id = '".$new_array."' WHERE id = '".$_POST['eform_id_check'][$x]."'")->execute();

		if(($x+1)==count($_POST['eform_id_check'])){
			$data['output'] = 1;
		}else{
			$data['output'] = 0;
		}
	}

	// var_dump($data['output']);
	echo json_encode($data);

}

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){

	echo $someJSON = json_encode($data);

}
?>


