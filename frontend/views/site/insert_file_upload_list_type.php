<?php if (isset($_SESSION['user_id'])): ?>

	<?php $type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : ''); 
		$where = ($_SESSION['user_role']=='1') ? "" : "AND unit_id = '".$_GET['unitid']."'";
	?>

	<?php if ($type=='insert'){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
		header('Content-Type: application/json');
		$bucket = $_GET['namebucket'];
		$file_name = $_GET['namefile'];
		$form_id = $_GET['form_id'];
		$unit_id = $_GET['unitid'];
		$usercreate = $_GET['usercreate'];
		$namefileold = $_GET['namefileold'];
		$status_upload = $_GET['status_upload'];
		$eform_data_id = (isset($_GET['eform_data_id'])) ? $_GET['eform_data_id'] : '';
		$sql = "INSERT INTO file_upload_list (bucket,file_name, status, form_id,origin_file_name,unit_id,user_create,status_upload,eform_data_id) VALUES ('".$bucket."','".$file_name."', '1', '".$form_id."','".$namefileold."','".$unit_id."','".$usercreate."','".$status_upload."','".$eform_data_id."')";
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
		$query = "SELECT * FROM file_upload_list WHERE form_id = '".$_GET['form_id']."' $where ORDER BY id DESC";
		$result = Yii::$app->db->createCommand($query)->queryAll();
		$count = 0;
		$resultArray = array();
		foreach ($result as $row) {
			$count ++;
			$users = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$row['user_create']."'")->queryOne();

			$status_upload = ($row['status_upload']=='1') ? '<a href="index.php?r=eform-data/view&id='.$row['eform_data_id'].'" target="_blank">ไฟล์จากข้อมูลที่บันทึก</a>' : 'ไฟล์จากแฟ้มข้อมูล';
		// $text_extract = ($row['status_text_extract']!='2') ? '<div class="btn-group"><button class="btn btn-primary btn-sm extractText" data-file_id="'.$row['id'].'" data-file_name="'.$row['file_name'].'" data-bucket="'.$row['bucket'].'" data-toggle="modal" data-target="#myModal" type="button">Extract</button> <a class="btn btn-secondary btn-sm" href="index.php?r=file-upload-list%2Fview&amp;id='.$row['id'].'" title="view"><i class="fa fa-eye"></i></a> <button class="btn save-btn btn-danger deldata btn-sm" data-file-id="'.$row['id'].'" data-name-file="'.$row['file_name'].'" data-name-bucket="'.$row['bucket'].'"><i class="fa fa-trash"></i></button></div>' : '<div class="btn-group"><button class="btn btn-light btn-sm" disabled>Extract</button> <a class="btn btn-secondary btn-sm" href="index.php?r=file-upload-list%2Fview&amp;id='.$row['id'].'" title="view" target="_blank"><i class="fa fa-eye"></i></a> <button class="btn save-btn btn-danger deldata btn-sm" data-file-id="'.$row['id'].'" data-name-file="'.$row['file_name'].'" data-name-bucket="'.$row['bucket'].'"><i class="fa fa-trash"></i></button></div>';
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

	<?php if ($type=='showlistdata'){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
		header('Content-Type: application/json');
		$query = "SELECT * FROM file_upload_list WHERE eform_data_id = '".$_GET['eform_data_id']."' ORDER BY id DESC";
		$result = Yii::$app->db->createCommand($query)->queryAll();
		$count = 0;
		$resultArray = array();
		foreach ($result as $row) {
			$count ++;
			$users = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$row['user_create']."'")->queryOne();
			$status_upload = ($row['status_upload']=='1') ? 'ไฟล์จากข้อมูลที่บันทึก' : 'ไฟล์จากแฟ้มข้อมูล';
			$resultArray[] = array(
				'no' => $count,
				'file_id' => $row['id'],
				'file_name' => $row['file_name'],
				'bucket' => $row['bucket'],
				'text_extract' => $row['text_extract'],
				'origin_file_name' => $row['origin_file_name'],
				'unit_id' => $row['unit_id'],
				'user_create_id' => $row['user_create'],
				'user_create' => $users['name'],
				'status_upload' => $status_upload,
				'button' => '<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">Extract</button> <a class="btn btn-success btn-sm" href="index.php?r=file-upload-list%2Fview&amp;id='.$row['id'].'" title="view">View</a> <a class="btn btn-danger btn-sm" href="/textx/frontend/web/index.php?r=file-upload-list%2Fdelete&amp;id='.$row['id'].'" data-confirm="Are you sure you want to delete this item?" data-method="post">Delete</a>',
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

	if ($type == "couterfileall") {
		$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE form_id = '".$_GET['form_id']."' $where")->queryScalar();
		$output['couterfile'] = $count;
		echo json_encode($output);
	}

	if ($type == "couterfilestatus1") {
		$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE status = '1' AND form_id = '".$_GET['form_id']."' $where")->queryScalar();
		$output['couterfile'] = $count;
		echo json_encode($output);
	}

	if ($type == "couterfilestatus0") {
		$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE status_text_extract = '1' AND form_id = '".$_GET['form_id']."' $where")->queryScalar();
		$output['couterfile'] = $count;
		echo json_encode($output);
	}

	if ($type == "couterfilestatus2") {
		$count = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE status = '1' AND form_id = '".$_GET['form_id']."' $where AND status_text_extract = '2'")->queryScalar();
		$output['couterfile'] = $count;
		echo json_encode($output);
	}
	?>


	<?php
		if ($type == "getdata_org") {
		$query = Yii::$app->db->createCommand("SELECT * FROM organization WHERE id = '".$_POST['org_id']."'")->queryOne();
		echo json_encode($query);
	}
	?>

	<?php endif ?>

	

	