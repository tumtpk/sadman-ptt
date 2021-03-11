<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');



	$data = [];
// $token = "2ffa459adcc37176dbf93a82addf61dc";
// $auth = "Authenticator=>".$token."".date("Ymd");
// if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($data);
// }

?>