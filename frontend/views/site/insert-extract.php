<?
use app\models\FileUploadList;

    header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token');
    header('Content-Type: application/json');
    
//echo $_POST['file_id'].'<br>  |'.$_POST['text'];

//$db->createCommand()->execute();

#$customer = FileUploadList::findOne($_POST['file_id']);
#$customer->text_extract = htmlentities($_POST['text']);
#$customer->save();
//if($customer->save()) echo '{"status" : "success"}';
//else echo '{"status" : "fail"}';

#$sql = " UPDATE file_upload_list set text_extract = '".($_POST['text'])."'   where id = ".$_POST['file_id']."";
#echo $sql; 
#if(Yii::$app->db->createCommand($sql)) echo '{"status" : "success"}';
#else echo '{"status" : "fail"}';

$customer = FileUploadList::findOne($_POST['file_id']);
$customer->text_extract = $_POST['text'];
$customer->status_text_extract = 1;
$customer->save();
//if($customer->save()) echo 'Data saved';
//else echo 'Data save fail'; */


?>