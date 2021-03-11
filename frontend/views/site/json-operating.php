<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');


if ($type=='view_operating_main') {

	$query = "SELECT * FROM operating_main ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {

		$detail = substr($row['detail'],0,200)."...";
		$remark = substr($row['remark'],0,100)."...";

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id'],
			'name' => $row['name'],
			'detail' => $row['detail'],
			'remark' => $row['remark'],
			'link' => '<a href="index.php?r=operating-main/view&id='.$row['id'].'"><span class="tag tag-blue operating-icon-box" style="cursor: pointer;"><i class="icon-magnifier"></i></span></a><a href="index.php?r=operating-main/update&id='.$row['id'].'"><span class="tag tag-default operating-icon-box" style="cursor: pointer;"><i class="icon-note"></i></span></a>'
		);

		$i++;
	}

	$token = "2ffa459adcc37176dbf93a82addf61dc";
	$auth = "Authenticator=>".$token."".date("Ymd");
	if(isset($_GET['auth']) && $_GET['auth'] == $auth){
		echo json_encode($resultArray);
	}
}

if ($type=='operating_counts') {

	$data = array();
	$operating_main = Yii::$app->db->createCommand("SELECT COUNT(*) AS sum FROM `operating_main`")->queryScalar();
	$operating_area = Yii::$app->db->createCommand("SELECT COUNT(*) AS sum FROM `operating_area`")->queryScalar();
	$operating_zone = Yii::$app->db->createCommand("SELECT COUNT(*) AS sum FROM `operating_zone`")->queryScalar();

	$data['main'] = number_format($operating_main);
	$data['area'] = number_format($operating_area);	
	$data['zone'] = number_format($operating_zone);


	$token = "2ffa459adcc37176dbf93a82addf61dc";
	$auth = "Authenticator=>".$token."".date("Ymd");
	if(isset($_GET['auth']) && $_GET['auth'] == $auth){
		echo $someJSON = json_encode($data);
	}
}

if ($type=='operating_add_zone') {

	$name = isset($_GET['name']) ?  $_GET['name'] : (isset($_POST['name']) ? $_POST['name'] : '');
	$detail = isset($_GET['detail']) ?  $_GET['detail'] : (isset($_POST['detail']) ? $_POST['detail'] : '');
	$remark = isset($_GET['remark']) ?  $_GET['remark'] : (isset($_POST['remark']) ? $_POST['remark'] : '');
	$date_create = date('Y-m-d');
	$user_create = $_SESSION['user_id'];

	$sql = "INSERT INTO `operating_zone`(`zone_name`, `detail`, `remark`, `date_create`, `user_create`) VALUES ('".$name."','".$detail."','".$remark."','".$date_create."','".$user_create."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='operating_add_area') {

	$zone_id = isset($_GET['zone_id']) ?  $_GET['zone_id'] : (isset($_POST['zone_id']) ? $_POST['zone_id'] : '');
	$name = isset($_GET['name']) ?  $_GET['name'] : (isset($_POST['name']) ? $_POST['name'] : '');
	$detail = isset($_GET['detail']) ?  $_GET['detail'] : (isset($_POST['detail']) ? $_POST['detail'] : '');
	$remark = isset($_GET['remark']) ?  $_GET['remark'] : (isset($_POST['remark']) ? $_POST['remark'] : '');
	$date_create = date('Y-m-d');
	$user_create = $_SESSION['user_id'];

	$sql = "INSERT INTO `operating_area`(`zone_id`, `area_name`, `area_detail`, `area_remark`, `date_create`, `user_create`) VALUES ('".$zone_id."','".$name."','".$detail."','".$remark."','".$date_create."','".$user_create."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);

}

if ($type=='view_operating_zone') {

	$query = "SELECT * FROM operating_zone ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$i = 1;
	$resultArray = array();
	foreach ($result as $row) {
		$operating_area = Yii::$app->db->createCommand("SELECT COUNT(*) AS count,area_id FROM `operating_area` WHERE zone_id = '".$row['id']."'")->queryOne();
		$operating_main = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `operating_main` WHERE zone_id = '".$row['id']."'")->queryOne();

		$count ++;
		$resultArray[] = array(
			'no' => "".$i."",
			'id' => $row['id'],
			'name' => $row['zone_name'],
			'detail' => $row['detail'],
			'remark' => $row['remark'],
			'count_area' => $operating_area['count'],
			'count_main' => $operating_main['count'],
			'link' => '<a href="index.php?r=operating-main/report-zone&id='.$row['id'].'"><span class="tag tag-blue operating-icon-box" style="cursor: pointer;"><i class="icon-magnifier"></i> รายละเอียดเพิ่มเติม</span></a>'
		);

		$i++;
	}

	$token = "2ffa459adcc37176dbf93a82addf61dc";
	$auth = "Authenticator=>".$token."".date("Ymd");
	if(isset($_GET['auth']) && $_GET['auth'] == $auth){
		echo json_encode($resultArray);
	}
}
?>