<?php
include('../conn_sql/conn.php');
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
$PHP_SELF = explode("/", $_SERVER['PHP_SELF']);
$_URL = $protocol.$_SERVER['HTTP_HOST']."/".$PHP_SELF[1]."/textx";

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');
$key_images = isset($_GET['key_images']) ?  $_GET['key_images'] : (isset($_POST['key_images']) ? $_POST['key_images'] : '');
?>

<?php if ($type=='insert'){
	$file_name = $_POST['file_name'];
	$key_images = $_POST['key_images'];
	$file_type = $_POST['file_type'];
	$date_create = $_POST['date_create'];
	$query = "
	INSERT INTO webboard_images_files (file_name,file_type, key_images, date_create)
	VALUES ('".$file_name."','".$file_type."', '".$key_images."','".$date_create."')
	";

	$result = $conn->query($query)or die($conn->error);
	$last_id = $conn->insert_id;
	// echo $last_id;
}?>


<?php if ($type=='show'){
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
	header('Content-Type: application/json');
	$query = "SELECT * FROM webboard_images_files WHERE key_images = '$key_images' ORDER BY id DESC";
	$result = $conn->query($query)or die($conn->error);
	$number_of_rows = $result->num_rows;
	$count = 0;
	$resultArray = array();
	while($row = $result->fetch_assoc()) {
		$count ++;
		$resultArray[] = array(
			'file_name' => $row['file_name'],
			'file_id' => $row['id']
		);
	} 

	echo json_encode($resultArray);
} ?>


<?php
if ($type == "delete") {
	if(isset($_POST["img_id"]))
	{
		echo $_POST["img_name"];
		$file_path = 'images/' . $_POST["img_name"];
		if(unlink($file_path))
		{
			$query = "DELETE FROM images WHERE id = '".$_POST["img_id"]."'";
			$result = $conn->query($query)or die($conn->error);
		}
	}
}
?>

