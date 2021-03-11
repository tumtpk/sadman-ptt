<?php
include '../conn_sql/conn.php';
header("Content-Type: application/json; charset=UTF-8");
$date_m = date("m");
$date_y = date("Y");
$months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$monthlys = array();
foreach ($months as $value) {

	$sum_month_type_1 = $conn->query("SELECT COUNT(log_id) AS sum FROM `user_log_usaged` WHERE MONTH(log_date) = '" . $value . "' AND log_date LIKE '".$date_y."-%'")->fetch_assoc();

	$monthlys[] = (int)$sum_month_type_1['sum'];


}
	// echo "'data1'".$monthlys;
	echo $someJSON = json_encode($monthlys);
?>