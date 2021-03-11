<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');
// include('../conn_sql/conn.php');

$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
$PHP_SELF = explode("/", $_SERVER['PHP_SELF']);
$_URL = $protocol.$_SERVER['HTTP_HOST']."/".$PHP_SELF[1];

$id = isset($_GET['id']) ?  $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

if (!empty($id)) {

	
	$sql = ($type=='1') ?  "SELECT * FROM `user_role` WHERE id = '$id'" : "SELECT * FROM `user_group` WHERE id = '$id'";
	$checked = Yii::$app->db->createCommand($sql)->queryOne(); 

	$allow_access_main = $checked['allow_access_main'];
	$allow_access_main = str_replace('"', '', $allow_access_main);
	$allow_access_main = str_replace('[', '', $allow_access_main);
	$allow_access_main = str_replace(']', '', $allow_access_main);
	$arraycheck_menumain = explode(",", $allow_access_main);


	$allow_access_sub = $checked['allow_access_sub'];
	$allow_access_sub = str_replace('"', '', $allow_access_sub);
	$allow_access_sub = str_replace('[', '', $allow_access_sub);
	$allow_access_sub = str_replace(']', '', $allow_access_sub);
	$arraycheck_menusub = explode(",", $allow_access_sub);
}

$sql = Yii::$app->db->createCommand("SELECT * FROM `menu_main` WHERE m_status = 'Y' ORDER BY m_sort ASC")->queryAll();
// $sql = "SELECT * FROM `menu_main` WHERE m_status = 'Y' ORDER BY m_sort ASC";

// $result = $conn->query($sql)or die($conn->error);

$resultArray = array();
foreach ($sql as $row) {
// while ($row = $result->fetch_assoc()) {

	if (empty($id)) {
		$checked_main = false;
	}else{
		$checked_main = (empty($id)) ? false : (in_array($row['id'], $arraycheck_menumain)) ? true : false;
	}

	

	$menu_sub = array();
	$array_menu_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' AND menu_id = '".$row['id']."' ORDER BY menu_id,submenu_sort ASC")->queryAll();
	// $array_menu_sub = $conn->query("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' AND menu_id = '".$row['id']."' ORDER BY menu_id,submenu_sort ASC")or die($conn->error);
	// while ($row_sub = $array_menu_sub->fetch_assoc()) {
	foreach ($array_menu_sub as $row_sub) {
		if (empty($id)) {
			$checked_sub = false;
		}else{
			$checked_sub = (in_array($row_sub['submenu_id'], $arraycheck_menusub)) ? true : false;
		}
		

		$menu_sub[] = array(
			"id" => "".$row_sub['submenu_id']."",
			"text" => "".$row_sub['submenu_name']."",
			"type" => "sub",
			"checked"=> $checked_sub,
			// "arraysub"=> "".$allow_access_sub."",
			// "spriteCssClass"=> "fa fa-circle"
		);
	}

	$resultArray[] = array(
		"id" => "".$row['id']."",
		"text" => "".$row['m_name']."",
		"expanded" => "true",
		// "spriteCssClass"=>"".$row['m_icon']."",
		"type"=> "main",
		"checked"=> $checked_main,
		"items" => $menu_sub,
		// "arraymain"=> "".$allow_access_main."",

	);
}

$someJSON = json_encode($resultArray);

if(isset($_GET['key']) && $_GET['key'] == 'sdsfgsfasa88765^8'){
	echo '[{

		"id": null, "text": "root", "spriteCssClass": "fa fa-bars", "expanded": "true",
		"items": '.$someJSON.'
      		}]'; //"imageUrl": "'.$_URL.'/kendo_treeview/menu.png"
      	}
      	?>