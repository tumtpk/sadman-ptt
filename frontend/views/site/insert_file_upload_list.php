<?php $type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : ''); ?>

<?php if ($type=='insert'){
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	$bucket = $_GET['namebucket'];
	$file_name = $_GET['namefile'];
	$form_id = $_GET['form_id'];
	$sql = "INSERT INTO file_upload_list (bucket,file_name, status, form_id) VALUES ('".$bucket."','".$file_name."', '0', '".$form_id."')";
	$query = Yii::$app->db->createCommand($sql);
	if ($query->execute()) {
		$output['status'] = 1;
	}else{
		$output['status'] = 0;
	}
	echo json_encode($output);
} ?>


<?php if ($type=='show'){
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	$query = "SELECT * FROM file_upload_list WHERE form_id = '".$_GET['form_id']."' ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$resultArray = array();
	foreach ($result as $row) {
		$count ++;
		$resultArray[] = array(
			'file_id' => $row['id'],
			'file_name' => $row['file_name'],
			'bucket' => $row['bucket']
		);
	}

	echo json_encode($resultArray);
} ?>

<?php
if ($type == "delete") {
	if(isset($_GET["file_id"]))
	{
		$query = "DELETE FROM file_upload_list WHERE id = '".$_GET["file_id"]."'";
		$result = Yii::$app->db->createCommand($query)->execute();
	}
}
?>

<?php
if ($type == "insert_eform") {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	if(isset($_POST["form_id"]))
	{
		$query = "
		INSERT INTO `eform_data`(`form_id`, `eform_id`, `data_json`) 
		VALUES ('".$_POST["form_id"]."','".$_POST["eform_id"]."','[".$_POST["data_json"]."]')";
		$result = Yii::$app->db->createCommand($query)->execute();
		$id = Yii::$app->db->getLastInsertID();
		$last_id = array("id_sql_eform"=>$id);
		$na = array_merge($_POST["data_object"],$last_id);


		$manager = new MongoDB\Driver\Manager("mongodb://freeman:abcd1234@database:27017");
		$bulk = new MongoDB\Driver\BulkWrite();
		$bulk->insert($na);
		$writeConcern = new MongoDB\Driver\writeConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
		$result = $manager->executeBulkWrite('textx.eform_data', $bulk);

		if ($result) {
			$output['status'] = 1;
			$output['id_sql_eform'] = $id;
		}else{
			$output['status'] = 0;
		}

		echo json_encode($output);

	}
}

if ($type == "update_eform") {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	if(isset($_POST["id_sql_eform"]))
	{
		$id_sql_eform = array("id_sql_eform"=>$_POST["id_sql_eform"]);
		$insert_new = array_merge($_POST["data_object"],$id_sql_eform);

		$query = "
		UPDATE `eform_data` SET data_json='[".$_POST["data_json"]."]' WHERE id = '".$_POST["id_sql_eform"]."'";
		$result = Yii::$app->db->createCommand($query);
		if ($result->execute()) {
			$manager = new MongoDB\Driver\Manager("mongodb://freeman:abcd1234@database:27017");
			$bulk = new MongoDB\Driver\BulkWrite();
			$bulk->delete(['id_sql_eform' => $_POST["id_sql_eform"]]);
			$bulk->insert($insert_new);
			$writeConcern = new MongoDB\Driver\writeConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
			$result = $manager->executeBulkWrite('textx.eform_data', $bulk);

			if ($result) {
				$output['status'] = 1;
			}else{
				$output['status'] = 0;
			}

			echo json_encode($output);
		}
	}
}


if ($type == "delete_eform") {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	if(isset($_GET["id_sql_eform"]))
	{
		$id_sql_eform = $_GET["id_sql_eform"];
		$result = Yii::$app->db->createCommand("DELETE FROM `eform_data` WHERE id = '$id_sql_eform'");
		if ($result->execute()) {
			$manager = new MongoDB\Driver\Manager("mongodb://freeman:abcd1234@database:27017");
			$bulk = new MongoDB\Driver\BulkWrite();
			$bulk->delete(['id_sql_eform' => $id_sql_eform]);
			$writeConcern = new MongoDB\Driver\writeConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
			$result = $manager->executeBulkWrite('textx.eform_data', $bulk);

			if ($result) {
				$output['status'] = 1;
			}else{
				$output['status'] = 0;
			}

			echo json_encode($output);
		}
	}
}


if ($type == "check_status_stay_informed") {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	$query = Yii::$app->db->createCommand("SELECT * FROM `eform_template`")->queryAll();
	$resultArray = array();

	foreach ($query as $row) {

		$total_stay_informed = 0;
		$total_evaluate_news = 0;
		$sql = "SELECT * FROM `eform_data` WHERE form_id = '".$row['id']."'";
		$query = Yii::$app->db->createCommand($sql)->queryAll();
		foreach ($query as $value) {
			$data = @json_decode($value['data_json'],TRUE);
			$val_eform = $data[0];
			if ($val_eform['stay_informed']=='0') {
				$total_stay_informed = $total_stay_informed + 1;
			}

			if ($val_eform['evaluate_news']=='-') {
				$total_evaluate_news = $total_evaluate_news + 1;
			}
		}

		$count ++;
		$resultArray[] = array(
			'form_id' => $row['id'],
			'detail' => $row['detail'],
			'total_stay_informed' => $total_stay_informed,
			'total_evaluate_news' => $total_evaluate_news,
		);
	}

	echo json_encode($resultArray);
}


if ($type == "upload_file_marker") {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	if(isset($_FILES["file_marker"]["name"])){
		$file_name = $_FILES["file_marker"]["name"];
		$tmp_name = $_FILES["file_marker"]['tmp_name'];
		$file_array = explode(".", $file_name);
		$file_extension = end($file_array);
		$namefile = explode(".", $_POST['namefile']);
		$namefile = $namefile[0]. '.' . $file_extension;
		$location = '../../marker_eform/' . $namefile;
		if($_POST['oldfilemarker']!=''){
			$oldfilemarker = explode("/", $_POST['oldfilemarker']);
			if (file_exists('../../marker_eform/' . $oldfilemarker[5])){
				unlink('../../marker_eform/' . $oldfilemarker[5]);
			}
		}
		if(move_uploaded_file($tmp_name, $location)){
			$output['status'] = 1;
		}else{
			$output['status'] = 0;
		}

		echo json_encode($output);
	}
}

if ($type == "delete_file_marker") {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	if (isset($_POST['namefiledel'])) {
		if (file_exists('../../marker_eform/' . $_POST['namefiledel'])){
			unlink('../../marker_eform/' . $_POST['namefiledel']);
			$output['status'] = 1;
		}else{
			$output['status'] = 0;
		}
		echo json_encode($output);
	}
}

if ($type == "couterfileall") {
	$where = ($_SESSION['user_role']=='1') ? "" : "WHERE unit_id = '".$_SESSION['unit_id']."'";
	//echo "SELECT COUNT(*) FROM file_upload_list $where";
	$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list $where")->queryScalar();
	$output['couterfile'] = $count;
	echo json_encode($output);
}

if ($type == "couterfilestatus1") {
	$where = ($_SESSION['user_role']=='1') ? "" : "AND unit_id = '".$_SESSION['unit_id']."'";
	$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE status = '1' $where")->queryScalar();
	$output['couterfile'] = $count;
	echo json_encode($output);
}

if ($type == "couterfilestatus0") {
	$where = ($_SESSION['user_role']=='1') ? "" : "AND unit_id = '".$_SESSION['unit_id']."'";
	$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE status_text_extract = '1' $where")->queryScalar();
	$output['couterfile'] = $count;
	echo json_encode($output);
}

if ($type == "couterfilestatus2") {
	$where = ($_SESSION['user_role']=='1') ? "" : "AND unit_id = '".$_SESSION['unit_id']."'";
	$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE status = '1' AND status_text_extract = '2' $where")->queryScalar();
	$output['couterfile'] = $count;
	echo json_encode($output);
}
?>


<?php
if ($type == "filetypebucket") {
	$where = ($_SESSION['user_role']=='1') ? "" : "AND unit_id = '".$_SESSION['unit_id']."'";
	$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE bucket = '".$_GET['bucket']."' $where")->queryScalar();
	$output['couterfile'] = $count;
	echo json_encode($output);
}
?>

<?php
if ($type == "filetypebucket_lastupdate") {
	$where = ($_SESSION['user_role']=='1') ? "" : "AND unit_id = '".$_SESSION['unit_id']."'";
	$check = Yii::$app->db->createCommand("SELECT * FROM file_upload_list WHERE bucket = '".$_GET['bucket']."' $where ORDER BY date_upload DESC")->queryOne();
	$output['date_upload'] = (!empty($check['date_upload'])) ? DateThaiTime($check['date_upload']) : '';
	echo json_encode($output);
}
?>


<?php if ($type=='showdatatable'){
	$where = ($_SESSION['user_role']=='1') ? "" : "WHERE unit_id = '".$_SESSION['unit_id']."'";
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	$query = "SELECT * FROM file_upload_list $where ORDER BY id DESC";
	$result = Yii::$app->db->createCommand($query)->queryAll();
	$count = 0;
	$resultArray = array();
	foreach ($result as $row) {
		$count ++;
		$users = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$row['user_create']."'")->queryOne();
		if($_SESSION['user_role']=='1'){
			$sql_form = "SELECT id, detail, version FROM `eform_template` WHERE id = '".$row['form_id']."'";
		}else{
			$sql_form = "SELECT id, detail, version FROM eform_template WHERE id = '".$row['form_id']."' AND unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
		}
		$eform_template = Yii::$app->db->createCommand($sql_form)->queryOne();

		$status_upload = ($row['status_upload']=='1') ? '<a href="index.php?r=eform-data/view&id='.$row['eform_data_id'].'" target="_blank">จากข้อมูลที่บันทึก</a><br> '.$eform_template['detail'].'' : 'จากแฟ้มข้อมูล<br> '.$eform_template['detail'].'';
		$text1 = (!empty($row['text_extract'])) ? $row['text_extract'] : '';
		$new_str = preg_replace('~[\\\\/:*?"<>|]~', ' ', $text1);

		$text_extract = '<div class="btn-group"><button class="btn btn-primary btn-sm extractText" data-file_id="'.$row['id'].'" data-file_name="'.$row['file_name'].'" data-bucket="'.$row['bucket'].'" data-text_extract="'.$new_str.'" data-toggle="modal" data-target="#myModal" type="button" style="white-space: nowrap;">ประมวลผล</button> <a class="btn btn-secondary btn-sm" href="index.php?r=file-upload-list%2Fview&amp;id='.$row['id'].'" title="view"><i class="fa fa-eye"></i></a> <button class="btn save-btn btn-danger deldata btn-sm" data-file-id="'.$row['id'].'" data-name-file="'.$row['file_name'].'" data-name-bucket="'.$row['bucket'].'"><i class="fa fa-trash"></i></button></div>';
		$link_file = '<a href="#" class="openfile" data-file_id="'.$row['id'].'" data-file_name="'.$row['file_name'].'" data-bucket="'.$row['bucket'].'">'.$row['file_name'].'</a>';
		$text_extract_row = (strlen ($row['text_extract']) > 180) ? iconv_substr($row['text_extract'], 0,180, "UTF-8"). "....":$row['text_extract'];
		$text_extract_row = ($text_extract_row!='null') ? $text_extract_row : '';

		$resultArray[] = array(
			'no' => $count,
			'file_id' => $row['id'],
			'file_name' => $link_file,
			'bucket' => $row['bucket'],
			'text_extract' => $text_extract_row,
			'origin_file_name' => $row['origin_file_name'],
			'unit_id' => $row['unit_id'],
			'user_create_id' => $row['user_create'],
			'user_create' => $users['name'],
			'status_upload' => $status_upload,
			'button' => $text_extract,
		);
	}

	echo json_encode($resultArray);
} ?>


<?php
if ($type == "checkfiletypeall") {
	if($_SESSION['user_role']!='1'){
		$sql = "SELECT id, detail, version FROM eform_template";
		$WHERE_ANOTHER_SEARCH = "AND unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
		$WHERE_ANOTHER = "WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
		$WHERE_ANOTHER = "WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
		$WHERE_UNIT = "AND unit_id = '".$_SESSION['unit_id']."'";
		$GROUP = "GROUP BY id";
	}else{
		$sql = "SELECT id, detail, version FROM `eform_template`";
		$WHERE_ANOTHER_SEARCH = "";
		$WHERE_ANOTHER = "";
		$GROUP = "";
		$WHERE_UNIT = "";
	}

	$query = $sql;
	$query .= ' '.$WHERE_ANOTHER;
	$query .= ' '.$GROUP.' ORDER BY detail ASC ';
	$result = Yii::$app->db->createCommand($query)->queryAll();

	$resultArray = array();
	foreach ($result as $row) {
		$countfile = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE form_id = '".$row['id']."' $WHERE_UNIT")->queryScalar();
		$resultArray[] = array(
			'id' => $row['id'],
			'detail' => $row['detail'],
			'countfile' => number_format($countfile),
		);
	}


	echo json_encode($resultArray);
}
?>
