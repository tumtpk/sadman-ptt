<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');


$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if ($type=='type') {

	$name = isset($_GET['name']) ?  $_GET['name'] : (isset($_POST['name']) ? $_POST['name'] : '');
	$detail = isset($_GET['detail']) ?  $_GET['detail'] : (isset($_POST['detail']) ? $_POST['detail'] : '');

	$sql = "INSERT INTO `equipment_type`(`name`, `detail`) VALUES ('".$name."','".$detail."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='serialnumber') {

	$equipment_id = isset($_GET['equipment_id']) ?  $_GET['equipment_id'] : (isset($_POST['equipment_id']) ? $_POST['equipment_id'] : '');
	$serial_number = isset($_GET['serial_number']) ?  $_GET['serial_number'] : (isset($_POST['serial_number']) ? $_POST['serial_number'] : '');

	$sql = "INSERT INTO `equipment_sn`(`id_main`, `serial_number`) VALUES ('".$equipment_id."','".$serial_number."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='view_equipment') {

	$query = "SELECT * FROM equipment ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$equipment_sn = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `equipment_sn` WHERE id_main = '".$row['id']."'")->queryOne();
		$equipment_sn_dis = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `equipment_sn` WHERE id_main = '".$row['id']."' AND status = 1")->queryOne();

		$type_qu = Yii::$app->db->createCommand("SELECT * FROM `equipment_type` WHERE id = '".$row['type']."'")->queryOne();

		$detail = substr($row['detail'],0,50)."...";

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id'],
			'name' => $row['name'],
			'type' => $type_qu['name'],
			'brand' => $row['brand'],
			'model' => $row['model'],
			//'detail' => $detail,
			'count' => $equipment_sn['count'],
			'dis' => $equipment_sn_dis['count'],
			'link' => '<a href="index.php?r=equipment/equipment-views&id='.$row['id'].'"><span class="tag tag-blue" style="cursor: pointer;">รายละเอียดเพิ่มเติม</span></a> <a href="index.php?r=equipment/update&id='.$row['id'].'"><span class="tag tag-default mt-1" style="cursor: pointer;">แก้ไขข้อมูลอุปกรณ์</span></a>'
		);

		$i++;
	}

	echo json_encode($resultArray);
}

if ($type=='view_equipment_sn') {

	$id_sn = isset($_GET['id']) ?  $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');

	$query = "SELECT * FROM equipment_sn WHERE id_main = '".$id_sn."' ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {


		$equipment = Yii::$app->db->createCommand("SELECT * FROM `equipment` WHERE id = '".$row['id_main']."'")->queryOne();
		$disbursement = Yii::$app->db->createCommand("SELECT * FROM equipment_sn,`equipment_disbursement` WHERE equipment_sn.id = equipment_disbursement.id_sub AND equipment_sn.id = '".$row['id']."' AND equipment_sn.key_auth = equipment_disbursement.key_auth_dis")->queryOne();
		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$disbursement['unit_id']."'")->queryOne();

		if ($row['status']==1) {
			$unit_id = $unit['unit_name'];
		}else{
			$unit_id = "ยังไม่เบิกจ่าย";
		}

		if ($row['status']==1) {
			$date_time = DateThai($disbursement['date_time']);
		}else{
			$date_time = "";
		}

		if (!empty($disbursement['status'])) {

			if ($disbursement['equipment_approve_status'] == 0) {
				$status = 'รอการอนุมัติ';
			}else{
				$status = 'อยู่ในระหว่างการเบิกจ่าย';
			}

			if ($disbursement['unit_id'] == $_SESSION['unit_id']) {
				$link = '<a href="javascript:void(0)" data-toggle="modal" class="del-data-in-modal" data-target="#deldisbursement" data-id-disbursement="'.$disbursement['id_disbursement'].'" data-id="'.$row['id'].'" data-sn="'.$row['serial_number'].'" data-unit="'.$unit['unit_name'].'" data-user="'.$disbursement['user_disbursement'].'"><span class="tag tag-default" style="cursor: pointer;">เบิกจ่าย</span></a><a href="index.php?r=equipment/equipment-detail&id='.$row['id'].'" data-id="'.$row['id'].'"><span class="tag tag-green-new" style="cursor: pointer;">รายละเอียด</span></a>
					<a class="btn-default dropdown-toggle">
					<i class="icon-settings"></i>
					</a>';
			}else{
				$link = '<a href="javascript:void(0)" data-toggle="modal" data-target="#alert-permission"><span class="tag tag-skyblue-new" style="cursor: pointer;">ส่งคืน</span></a><a href="index.php?r=equipment/equipment-detail&id='.$row['id'].'" data-id="'.$row['id'].'"><span class="tag tag-green-new" style="cursor: pointer;">รายละเอียด</span></a>
					<a class="btn-default dropdown-toggle">
					<i class="icon-settings"></i>
					</a>';
			}
			

		}else{
			if ($row['status']==0) {

				$status = '';
				$link = '<a href="javascript:void(0)" data-toggle="modal" class="add-data-in-modal" data-target="#adddisbursement" data-id="'.$row['id'].'" data-sn="'.$row['serial_number'].'"><span class="tag tag-blue" style="cursor: pointer;">เบิกจ่าย</span></a><a href="index.php?r=equipment/equipment-detail&id='.$row['id'].'" data-id="'.$row['id'].'"><span class="tag tag-green-new" style="cursor: pointer;">รายละเอียด</span></a>
				<button type="button" class="btn-skyblue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="icon-settings"></i>
				</button>
				<div class="dropdown-menu">
				<a href="javascript:void(0)" data-toggle="modal" class="dropdown-item update-data-in-modal" data-target="#update" data-id="'.$row['id'].'" data-sn="'.$row['serial_number'].'">แก้ไขสถานะ</a>
				<a href="javascript:void(0)" data-toggle="modal" class="dropdown-item delete-data-in-modal" data-target="#delete" data-id="'.$row['id'].'">ลบ</a>
				</div>
				';

			}elseif ($row['status']==2) {

				$status = '<b style="color: #C15357;">ชำรุด/เสียหาย</b>';
				$link = '<span class="tag tag-default">เบิกจ่าย</span><a href="index.php?r=equipment/equipment-detail&id='.$row['id'].'" data-id="'.$row['id'].'"><span class="tag tag-green-new" style="cursor: pointer;">รายละเอียด</span></a>
				<button type="button" class="btn-skyblue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="icon-settings"></i>
				</button>
				<div class="dropdown-menu">
				<a href="javascript:void(0)" data-toggle="modal" class="dropdown-item update-data-in-modal" data-target="#update" data-id="'.$row['id'].'" data-sn="'.$row['serial_number'].'">แก้ไขสถานะ</a>
				<a href="javascript:void(0)" data-toggle="modal" class="dropdown-item delete-data-in-modal" data-target="#delete" data-id="'.$row['id'].'">ลบ</a>
				</div>';

			}elseif ($row['status']==3) {

				$status = '<b style="color: #C15357;">ส่งซ่อม</b>';
				$link = '<span class="tag tag-default">เบิกจ่าย</span><a href="index.php?r=equipment/equipment-detail&id='.$row['id'].'" data-id="'.$row['id'].'"><span class="tag tag-green-new" style="cursor: pointer;">รายละเอียด</span></a>
				<button type="button" class="btn-skyblue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="icon-settings"></i>
				</button>
				<div class="dropdown-menu">
				<a href="javascript:void(0)" data-toggle="modal" class="dropdown-item update-data-in-modal" data-target="#update" data-id="'.$row['id'].'" data-sn="'.$row['serial_number'].'">แก้ไขสถานะ</a>
				<a href="javascript:void(0)" data-toggle="modal" class="dropdown-item delete-data-in-modal" data-target="#delete" data-id="'.$row['id'].'">ลบ</a>
				</div>';
			}
			
		}

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id'],
			'id_main' => $row['id_main'],
			'dis_id' => $disbursement['id_disbursement'],
			'equipment_main' => $equipment['name'],
			'serial_number' => $row['serial_number'],
			'unit_id' => $unit_id,
			'date_time' => $date_time,
			'status' => $status,
			'link' => $link

		);

		$i++;
	}
	echo json_encode($resultArray);
}

if ($type=='add-disbursement') {

	$id_main = isset($_GET['id_main']) ?  $_GET['id_main'] : (isset($_POST['id_main']) ? $_POST['id_main'] : '');
	$id_sub = isset($_GET['id_sub']) ?  $_GET['id_sub'] : (isset($_POST['id_sub']) ? $_POST['id_sub'] : '');
	$unit_id = isset($_GET['unit_id']) ?  $_GET['unit_id'] : (isset($_POST['unit_id']) ? $_POST['unit_id'] : '');
	$user_disbursement = isset($_GET['user_disbursement']) ?  $_GET['user_disbursement'] : (isset($_POST['user_disbursement']) ? $_POST['user_disbursement'] : '');
	$date_data = isset($_GET['date_data']) ?  $_GET['date_data'] : (isset($_POST['date_data']) ? $_POST['date_data'] : '');
	$date_data_end = isset($_GET['date_data_end']) ?  $_GET['date_data_end'] : (isset($_POST['date_data_end']) ? $_POST['date_data_end'] : '');
	$remark = isset($_GET['remark']) ?  $_GET['remark'] : (isset($_POST['remark']) ? $_POST['remark'] : '');
	$random = rand();

	$yy = date('Y')+543;
	$year = $yy;
	$md = date('md');

	$maxQuery = Yii::$app->db->createCommand("Select Max(SUBSTRING(key_auth_dis,9,12)) as MaxID from equipment_disbursement WHERE key_auth_dis LIKE '".$year.$md."%'")->queryOne();
	$count = $maxQuery['MaxID'];

	if($count==''){ 
		$id = $year.$md.""."001";
	}else{
		$id = $year.$md."".sprintf("%03d",$count+1);
	}
	$auth = $id;


	$sql = "INSERT INTO `equipment_disbursement`(`id_main`, `id_sub`, `unit_id`, `user_disbursement`, `key_auth_dis`, `date_time`, `date_time_end`, `remark`) VALUES ('".$id_main."','".$id_sub."','".$unit_id."','".$user_disbursement."','".$auth."','".$date_data."','".$date_data_end."','".$remark."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {

		$sql_update = "UPDATE `equipment_sn` SET `key_auth`= '".$auth."',`status`= 1 WHERE id = '".$id_sub."'";
		$query = Yii::$app->db->createCommand($sql_update)->execute();
		$output['status'] = 1;

	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='del-disbursement') {
	$id_disbursement = isset($_GET['id_disbursement']) ?  $_GET['id_disbursement'] : (isset($_POST['id_disbursement']) ? $_POST['id_disbursement'] : '');
	$id_main = isset($_GET['id_main']) ?  $_GET['id_main'] : (isset($_POST['id_main']) ? $_POST['id_main'] : '');
	$id_sub = isset($_GET['id_sub']) ?  $_GET['id_sub'] : (isset($_POST['id_sub']) ? $_POST['id_sub'] : '');
	$unit_id = isset($_GET['unit_id']) ?  $_GET['unit_id'] : (isset($_POST['unit_id']) ? $_POST['unit_id'] : '');
	$date_data = isset($_GET['date_data']) ?  $_GET['date_data'] : (isset($_POST['date_data']) ? $_POST['date_data'] : '');
	$remark = isset($_GET['remark']) ?  $_GET['remark'] : (isset($_POST['remark']) ? $_POST['remark'] : '');

	$sql = "UPDATE `equipment_disbursement` SET `date_time_repatriate`= '".$date_data."',remark_repatriate = '".$remark."' WHERE id_disbursement = '".$id_disbursement."'";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {

		$sql_update = "UPDATE `equipment_sn` SET `key_auth`= '',`status`= 0 WHERE id = '".$id_sub."'";
		$query = Yii::$app->db->createCommand($sql_update)->execute();
		$output['status'] = 1;

	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='view_equipment_disbursement_main') {
	$id_main = isset($_GET['id']) ?  $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');

	$query = "SELECT * FROM equipment_disbursement WHERE id_main = '".$id_main."' ORDER BY id_disbursement DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit_id']."'")->queryOne();

		$sn = Yii::$app->db->createCommand("SELECT * FROM `equipment_sn` WHERE id = '".$row['id_sub']."'")->queryOne();

		if (!empty($row['date_time'])) {
			$date_time = DateThai($row['date_time']);
		}else{
			$date_time = "";
		}

		$detail = "หมายเลขการเบิกจ่าย : ".$row['key_auth_dis']."<br>หมายเลขเครื่อง : ".$sn['serial_number']."<br>หน่วยที่เบิกจ่าย : ".$unit['unit_name']."<br>ผู้เบิกจ่าย : ".$row['user_disbursement']."<br>เวลาที่เบิกจ่าย : ".$date_time."";
		

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'detail' => $detail

		);

		$i++;
	}

	echo json_encode($resultArray);
}

if ($type=='view_equipment_disbursement_sub') {
	$sub_id = isset($_GET['id']) ?  $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');

	$query = "SELECT * FROM equipment_disbursement WHERE id_sub = '".$sub_id."' ORDER BY date_time DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit_id']."'")->queryOne();

		$sn = Yii::$app->db->createCommand("SELECT * FROM `equipment_sn` WHERE id = '".$row['id_sub']."'")->queryOne();

		if (!empty($row['date_time'])) {
			$date_time = DateThai($row['date_time']);
		}else{
			$date_time = "";
		}

		$detail = "หมายเลขการเบิกจ่าย : ".$row['key_auth_dis']."<br>หมายเลขเครื่อง : ".$sn['serial_number']."<br>หน่วยที่เบิกจ่าย : ".$unit['unit_name']."<br>ผู้เบิกจ่าย : ".$row['user_disbursement']."<br>เวลาที่เบิกจ่าย : ".$date_time."";
		

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'detail' => $detail

		);

		$i++;
	}

	echo json_encode($resultArray);
}


if ($type=='view_equipment_disbursement') {
	$disbursement_id = isset($_GET['id']) ?  $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');

	$query = "SELECT * FROM equipment_disbursement WHERE id_sub = '".$disbursement_id."' ORDER BY id_disbursement DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit_id']."'")->queryOne();

		if (!empty($row['date_time'])) {
			$date_time = DateThai($row['date_time']);
		}else{
			$date_time = "";
		}

		if (!empty($row['remark'])) {
			$remark = $row['remark'];
		}else{
			$remark = "-";
		}

		if (!empty($row['date_time_repatriate'])) {
			$date_time_repatriate = DateThai($row['date_time_repatriate']);
		}else{
			$date_time_repatriate = '<span class="tag tag-default">ยังไม่ส่งคืน</span>';
		}

		if (!empty($row['remark_repatriate'])) {
			$remark_repatriate = $row['remark_repatriate'];
		}else{
			$remark_repatriate = "-";
		}

		if (!empty($row['date_time_repatriate'])) {
			$link = '<span class="tag tag-default">รายงานเบิกจ่าย</span><a href="index.php?r=equipment/equipment-disremark&id='.$row['id_disbursement'].'"><span class="tag tag-green-new" style="cursor: pointer;">เพิ่มเติม</span></a>';
		}else{
			$link = '<a href="javascript:void(0)" data-toggle="modal" class="disremark-in-modal" data-target="#disremark" data-id="'.$row['id_disbursement'].'" data-id-main="'.$row['id_main'].'" data-id-sub="'.$row['id_sub'].'" data-user-name="'.$unit['unit_name'].'" data-user-dis="'.$row['user_disbursement'].'"><span class="tag tag-blue" style="cursor: pointer;">รายงานเบิกจ่าย</span></a><a href="index.php?r=equipment/equipment-disremark&id='.$row['id_disbursement'].'"><span class="tag tag-green-new" style="cursor: pointer;">เพิ่มเติม</span></a>';
		}

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id_disbursement'],
			'id_main' => $row['id_main'],
			'id_sub' => $row['id_sub'],
			"unit_name" => $unit['unit_name'],
			'user_disbursement' => $row['user_disbursement'],
			'key_auth_dis' => $row['key_auth_dis'],
			'date_time' => $date_time,
			'remark' => $remark,
			'date_time_repatriate' => $date_time_repatriate,
			'remark_repatriate' => $remark_repatriate,
			'link' => $link
			
		);

		$i++;
	}

	echo json_encode($resultArray);
}

if ($type=='update-equipment-sn') {
	$id_sn = isset($_GET['id_sn']) ?  $_GET['id_sn'] : (isset($_POST['id_sn']) ? $_POST['id_sn'] : '');
	$status = isset($_GET['status']) ?  $_GET['status'] : (isset($_POST['status']) ? $_POST['status'] : '');
	$sql = "UPDATE `equipment_sn` SET `status` = '".$status."' WHERE id = '".$id_sn."'";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='delete-disbursement-sn') {
	$id_sn = isset($_GET['id_sn']) ?  $_GET['id_sn'] : (isset($_POST['id_sn']) ? $_POST['id_sn'] : '');
	$sql = "DELETE FROM `equipment_sn` WHERE id = '".$id_sn."'";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$sql_delete = "DELETE FROM `equipment_disbursement` WHERE id_sub = '".$id_sn."'";
		$query = Yii::$app->db->createCommand($sql_delete)->execute();
		$output['status'] = 1;

	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='add-disremark') {

	$id_main = isset($_GET['id_main']) ?  $_GET['id_main'] : (isset($_POST['id_main']) ? $_POST['id_main'] : '');
	$id_sub = isset($_GET['id_sub']) ?  $_GET['id_sub'] : (isset($_POST['id_sub']) ? $_POST['id_sub'] : '');
	$disremark_id = isset($_GET['disremark_id']) ?  $_GET['disremark_id'] : (isset($_POST['disremark_id']) ? $_POST['disremark_id'] : '');
	$remark = isset($_GET['remark']) ?  $_GET['remark'] : (isset($_POST['remark']) ? $_POST['remark'] : '');
	$date_create = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `equipment_disremark`(`id_main`, `id_sub`, `id_disbursement`, `disbursement_status`,`date_create`) VALUES ('".$id_main."','".$id_sub."','".$disremark_id."','".$remark."','".$date_create."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='view-disremark') {

	$id_main = isset($_GET['id_main']) ?  $_GET['id_main'] : (isset($_POST['id_main']) ? $_POST['id_main'] : '');
	$id_sub = isset($_GET['id_sub']) ?  $_GET['id_sub'] : (isset($_POST['id_sub']) ? $_POST['id_sub'] : '');
	$disremark_id = isset($_GET['disremark_id']) ?  $_GET['disremark_id'] : (isset($_POST['disremark_id']) ? $_POST['disremark_id'] : '');

	$query = "SELECT * FROM equipment_disremark WHERE id_disbursement = '".$disremark_id."' ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id_main' => $row['id_main'],
			'id_sub' => $row['id_sub'],
			'id_disbursement' => $row['id_disbursement'],
			'disbursement_status' => $row['disbursement_status'],
			'date_create' => DateThaiTime($row['date_create']),
		);

		$i++;

	}

	echo json_encode($resultArray);

}

if ($type=='equipment-approve') {

	$unit_id = isset($_GET['unit_id']) ?  $_GET['unit_id'] : (isset($_POST['unit_id']) ? $_POST['unit_id'] : '');
	// $query = "SELECT * FROM equipment_disbursement WHERE unit_id = '".$unit_id."' ORDER BY id_disbursement DESC";
	$query = "SELECT * FROM equipment_disbursement ORDER BY id_disbursement DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit_id']."'")->queryOne();

		if (!empty($row['date_time'])) {
			$date_time = DateThai($row['date_time']);
		}else{
			$date_time = "";
		}

		if (!empty($row['remark'])) {
			$remark = $row['remark'];
		}else{
			$remark = "-";
		}

		if (!empty($row['date_time_repatriate'])) {
			$date_time_repatriate = DateThai($row['date_time_repatriate']);
		}else{
			$date_time_repatriate = '<span class="tag tag-default">ยังไม่ส่งคืน</span>';
		}

		if (!empty($row['remark_repatriate'])) {
			$remark_repatriate = $row['remark_repatriate'];
		}else{
			$remark_repatriate = "-";
		}

		if ($row['date_time_end']!='0000-00-00') {
			$start_date = strtotime($row['date_time']); 
			$end_date = strtotime($row['date_time_end']); 
			$calculate_sum = ($end_date - $start_date)/60/60/24;
			$calculate_day = $calculate_sum.' วัน';
		}else{
			$calculate_day = 'ไม่กำหนดวันเบิกจ่าย';
		}


		if ($row['equipment_approve_status']==2) {
			$equipment_approve_status = "<b><i class='fe fe-check-circle approve-y'></i> ถูกต้อง</b><p class='mt-2'>".$row['equipment_approve_remark']."</p>";
			$link = '<span class="tag tag-default">ตรวจสอบการเบิกจ่าย</span>';
		}elseif($row['equipment_approve_status']==3){
			$equipment_approve_status = "<b><i class='fe fe-alert-circle approve-n'></i> ไม่ถูกต้อง</b><p class='mt-2'>".$row['equipment_approve_remark']."</p>";
			$link = '<span class="tag tag-default">ตรวจสอบการเบิกจ่าย</span>';
		}elseif($row['equipment_approve_status']==0){
			$equipment_approve_status = "ยังไม่ตรวจสอบ";
			$link = '<a href="javascript:void(0)" data-toggle="modal" class="approve-in-modal" data-target="#approve" data-id="'.$row['id_disbursement'].'" data-id-main="'.$row['id_main'].'" data-id-sub="'.$row['id_sub'].'" data-user-name="'.$unit['unit_name'].'" data-user-dis="'.$row['user_disbursement'].'" data-approve-status="'.$row['equipment_approve_status'].'" data-approve-remark="'.$row['equipment_approve_remark'].'"><span class="tag tag-blue" style="cursor: pointer;">ตรวจสอบการเบิกจ่าย</span></a>';
		}

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id_disbursement'],
			'id_main' => $row['id_main'],
			'id_sub' => $row['id_sub'],
			'unit_name' => $unit['unit_name'],
			'user_disbursement' => $row['user_disbursement'],
			'key_auth_dis' => $row['key_auth_dis'],
			'date_time' => $date_time,
			'calculate_day' => $calculate_day,
			'remark' => $remark,
			'date_time_repatriate' => $date_time_repatriate,
			'remark_repatriate' => $remark_repatriate,
			'equipment_approve_status' => $row['equipment_approve_status'],
			'equipment_approve_detail' => $equipment_approve_status,
			'equipment_approve_remark' => $row['equipment_approve_remark'],
			'link' => $link
			
		);

		$i++;
	}

	echo json_encode($resultArray);

}
if ($type=='update-equipment-approve') {

	$disremark_id = isset($_GET['disremark_id']) ?  $_GET['disremark_id'] : (isset($_POST['disremark_id']) ? $_POST['disremark_id'] : '');
	$statuss = isset($_GET['status']) ?  $_GET['status'] : (isset($_POST['status']) ? $_POST['status'] : '');
	$remark = isset($_GET['remark']) ?  $_GET['remark'] : (isset($_POST['remark']) ? $_POST['remark'] : '');
	$id_sub = isset($_GET['id_sub']) ?  $_GET['id_sub'] : (isset($_POST['id_sub']) ? $_POST['id_sub'] : '');

	if ($statuss==2) {
		$sql = "UPDATE `equipment_disbursement` SET `equipment_approve_status` = '".$statuss."', `equipment_approve_remark` = '".$remark."' WHERE id_disbursement = '".$disremark_id."'";
	}elseif ($statuss==3) {
		$sql = "UPDATE `equipment_disbursement` SET `equipment_approve_status` = '".$statuss."', `equipment_approve_remark` = '".$remark."' WHERE id_disbursement = '".$disremark_id."'";

		$sql_update = "UPDATE `equipment_sn` SET `key_auth`= null,`status`= 0 WHERE id = '".$id_sub."'";
		$query = Yii::$app->db->createCommand($sql_update)->execute();

	}

	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='view_equipment_report') {
	$unit_id = isset($_GET['unit_id']) ?  $_GET['unit_id'] : (isset($_POST['unit_id']) ? $_POST['unit_id'] : '');

	$query = "SELECT * FROM equipment_disbursement WHERE unit_id = '".$unit_id."' ORDER BY id_disbursement DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit_id']."'")->queryOne();

		if (!empty($row['date_time'])) {
			$date_time = DateThai($row['date_time']);
		}else{
			$date_time = "";
		}

		if (!empty($row['remark'])) {
			$remark = $row['remark'];
		}else{
			$remark = "-";
		}

		if (!empty($row['date_time_repatriate'])) {
			$date_time_repatriate = DateThai($row['date_time_repatriate']);
		}else{
			$date_time_repatriate = '<span class="tag tag-default">ยังไม่ส่งคืน</span>';
		}

		if (!empty($row['remark_repatriate'])) {
			$remark_repatriate = $row['remark_repatriate'];
		}else{
			$remark_repatriate = "-";
		}

		if (!empty($row['date_time_repatriate'])) {
			$link = '<span class="tag tag-default">รายงานเบิกจ่ายประจำวัน</span><a href="index.php?r=equipment/equipment-disremark&id='.$row['id_disbursement'].'"><span class="tag tag-green-new" style="cursor: pointer;">ข้อมูลเพิ่มเติม</span></a>';
		}else{
			$link = '<a href="javascript:void(0)" data-toggle="modal" class="disremark-in-modal" data-target="#disremark" data-id="'.$row['id_disbursement'].'" data-id-main="'.$row['id_main'].'" data-id-sub="'.$row['id_sub'].'" data-user-name="'.$unit['unit_name'].'" data-user-dis="'.$row['user_disbursement'].'"><span class="tag tag-blue" style="cursor: pointer;">รายงานเบิกจ่ายประจำวัน</span></a><a href="index.php?r=equipment/equipment-disremark&id='.$row['id_disbursement'].'"><span class="tag tag-green-new" style="cursor: pointer;">ข้อมูลเพิ่มเติม</span></a>';
		}

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id_disbursement'],
			'id_main' => $row['id_main'],
			'id_sub' => $row['id_sub'],
			"unit_name" => $unit['unit_name'],
			'user_disbursement' => $row['user_disbursement'],
			'key_auth_dis' => $row['key_auth_dis'],
			'date_time' => $date_time,
			'remark' => $remark,
			'date_time_repatriate' => $date_time_repatriate,
			'remark_repatriate' => $remark_repatriate,
			'link' => $link
			
		);

		$i++;
	}

	echo json_encode($resultArray);
}

if ($type=='view_equipment_report_all') {

	$query = "SELECT * FROM equipment_disbursement ORDER BY date_time DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$row['unit_id']."'")->queryOne();

		if (!empty($row['date_time'])) {
			$date_time = DateThai($row['date_time']);
		}else{
			$date_time = "";
		}

		if (!empty($row['date_time_end'])) {
			$date_time_end = DateThai($row['date_time_end']);
		}else{
			$date_time_end = "";
		}

		if (!empty($row['remark'])) {
			$remark = $row['remark'];
		}else{
			$remark = "-";
		}

		if (!empty($row['date_time_repatriate'])) {
			$date_time_repatriate = DateThai($row['date_time_repatriate']);
		}else{
			$date_time_repatriate = '<span class="tag tag-default">ยังไม่ส่งคืน</span>';
		}

		if (!empty($row['remark_repatriate'])) {
			$remark_repatriate = $row['remark_repatriate'];
		}else{
			$remark_repatriate = "-";
		}

		$link = '<a href="index.php?r=equipment/equipment-views&id='.$row['id_main'].'"><span class="tag tag-green-new" style="cursor: pointer;">รายละเอียดเพิ่มเติม</span></a>';

		$unit_dis = "<div>หน่วยที่เบิกจ่าย : ".$unit['unit_name']."</div><div class='report-dis-mt'>ผู้เบิกจ่าย : ".$row['user_disbursement']."</div><div class='report-dis-mt'>วันที่เบิกจ่าย : ".$date_time."</div><div>วันที่ส่งคืน : ".$date_time_end."</div>";

		if ($row['date_time_end']!='0000-00-00') {
			$start_date = strtotime($row['date_time']); 
			$end_date = strtotime($row['date_time_end']); 
			$calculate_sum = ($end_date - $start_date)/60/60/24;
			$calculate_day = $calculate_sum;

			$date_now = date('Y-m-d');
			$start_date_dis = strtotime($date_now); 
			$end_date_dis = strtotime($row['date_time_end']); 
			$calculate_sum_dis = ($end_date_dis - $start_date_dis)/60/60/24;

			if ($calculate_sum_dis <= 0) {
				$calculate_sum_disbursement = '<b><i class="fe fe-alert-circle approve-n"></i> เลยกำหนดส่งคืน</b>';
			}else{
				$calculate_sum_disbursement = 'วันคงเหลือ '.$calculate_sum_dis.'  วัน';
			}

			$calculate_dis = $calculate_sum_disbursement;

			$calculate_detail = '<div>เบิกจ่าย '.$calculate_day.' วัน</div><div class="report-dis-mt">'.$calculate_dis.'</div>';

		}else{
			$calculate_day = 'ไม่กำหนดวันเบิกจ่าย';
			$calculate_dis = '';
			$calculate_detail = $calculate_day;
		}

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id_disbursement'],
			'id_main' => $row['id_main'],
			'id_sub' => $row['id_sub'],
			'unit_dis' => $unit_dis,
			'calculate_detail' => $calculate_detail,
			'key_auth_dis' => $row['key_auth_dis'],
			'link' => $link
			
		);

		$i++;
	}

	echo json_encode($resultArray);
}

?>