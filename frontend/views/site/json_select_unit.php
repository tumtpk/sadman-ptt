<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
header('Content-Type: application/json');

$type = isset($_GET['type']) ?  $_GET['type'] : (isset($_POST['type']) ? $_POST['type'] : '');

$get_page = isset($_GET['get_page']) ?  $_GET['get_page'] : (isset($_POST['get_page']) ? $_POST['get_page'] : '');

$text_search = isset($_GET['text_search']) ?  $_GET['text_search'] : (isset($_POST['text_search']) ? $_POST['text_search'] : '');

$id_array = isset($_GET['id_array']) ?  $_GET['id_array'] : (isset($_POST['id_array']) ? $_POST['id_array'] : '');

if($type=="pagi_search"){
$limit = '21';
$page = 1;
if($get_page > 1)
{
  $start = (($get_page - 1) * $limit);
  $page = $get_page;
}
else
{
  $start = 0;
}

$query = "
SELECT * FROM unit
";

if($text_search != '')
{
  $query .= '
  WHERE unit_name LIKE "%'.str_replace(' ', '%', $text_search).'%" OR unit_detail LIKE "%'.str_replace(' ', '%', $text_search).'%"
  ';
}

$query .= 'ORDER BY unit_name ASC ';


$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = Yii::$app->db->createCommand($query)->queryAll();
$total_data = count($statement);

$queryAll = Yii::$app->db->createCommand($filter_query)->queryAll();

$result = $queryAll;
$total_filter_data = count($queryAll);

$showdata = getdata($result);

}

if($type=='showdata_unitid'){
	$id_unit = implode(",",$id_array);
	$id_unit = str_replace(",","','",$id_unit);
	$query = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id IN ('".$id_unit."')")->queryAll();
	$showdata = getdata($query);
}

function getdata($array_data)
{
	$data = array();
	$i = 1;
	foreach ($array_data as $col){
		$data[] = array(
		"no" => "".$i."",
		"unit_id" => $col['unit_id'],
		"unit_name"=> $col['unit_name'],
		"unit_detail"=> $col['unit_detail']
	);
	$i++;
	}
	return $data;
}

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
if(isset($_GET['auth']) && $_GET['auth'] == $auth){
	echo $someJSON = json_encode($showdata);
}
?>