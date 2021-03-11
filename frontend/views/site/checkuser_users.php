<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

?>

<?php if ($type=='1'):?>
<?php
	$web = Yii::$app->db->createCommand("SELECT * FROM `user_website_usaged` WHERE user_id = '".$_SESSION['user_id']."'  ORDER BY create_date DESC LIMIT 5 ")->queryAll(); 
	$count = 0;
	$resultArray = array();

	foreach ($web as $w){
		$count ++;

		$resultArray[] = array(
			'url_website' => $w['url_website'],
			'create_date' => $w['create_date'],
		);
	}

	if(isset($_SESSION['user_id'])){
		echo json_encode($resultArray);
	}
?>
<?php endif;?>

<?php if ($type=='2'):?>
<?php
	$use = Yii::$app->db->createCommand("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE username = '".$_SESSION['user_id']."'")->queryScalar(); 
	$count = 0;
	$resultArray = array();

		$resultArray[sum] = $use;
			

	if(isset($_SESSION['user_id'])){
		echo json_encode($resultArray);
	}
?>
<?php endif;?>