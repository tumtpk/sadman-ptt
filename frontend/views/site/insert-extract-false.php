<?php
use app\models\FileUploadList;

    header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
    header('Content-Type: application/json');
    

$extract = FileUploadList::findOne($_POST['file_id']);
$extract->text_extract = $_POST['text'];
$extract->status_text_extract = 2;
$extract->save();
//if($customer->save()) echo 'Data saved';
//else echo 'Data save fail'; */


?>