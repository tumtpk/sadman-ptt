<?php
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
$PHP_SELF = $_SERVER['REQUEST_URI'];
$timeoutseconds = 600; //ตั้งเวลาสำหรับเช็คคนออนไลน์ เป็นวินาที 300= 5 นาที
# End Configuration - DO NOT EDIT BEHIND THIS LINE !!!
###############################################

$timestamp=time();
$timeout=$timestamp-$timeoutseconds;

// เมื่อมีการโหลดเวบเพจขึ้นมา จะกำหนดให้เก็บค่า IP ของคนเยี่ยมชม และเวลาที่โหลดหน้าเวบเพจ ลงในฐานข้อมูลทันที
$insert_useronline = Yii::$app->db->createCommand("INSERT INTO user_online (`user_id`, `timestamp`, `ip`, `file`) VALUES ('".$_SESSION['user_id']."','$timestamp','$REMOTE_ADDR','$PHP_SELF')")->execute();

//หลังจากนั้นเช็คว่า คนเยี่ยมชมหมายเลข IP ใด เกินกำหนดเวลาที่ตั้งไว้แล้ว ให้ลบออกฐานข้อมูล
$delete_useronline = Yii::$app->db->createCommand("DELETE FROM user_online WHERE timestamp<$timeout")->execute();

//ให้นับจำนวนเรคคอร์ดในตารางทั้งหมด ที่มี IP ต่างกัน ว่ามีเท่าไหร่ โดย IP เดียวกันให้นับเป็นคนเดียว

// $show_useronline = Yii::$app->db->createCommand("SELECT DISTINCT ip FROM user_online WHERE file='$PHP_SELF'")->queryScalar();
$show_useronline = Yii::$app->db->createCommand("SELECT COUNT(DISTINCT user_id) FROM user_online")->queryScalar();

//Show Useronline
if ($show_useronline==1) {
echo"$show_useronline User online";
} else {
echo"$show_useronline Users online";
}

?>