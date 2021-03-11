<?php  
use app\models\Setting;
$this->title = 'Timeline';

$url_kibana =  $Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value;
$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
$index =  $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;

$elasticsearch_username =  $Setting = Setting::find()->where(['setting_name' => 'elasticsearch_username'])->one()->setting_value;
$elasticsearch_password =  $Setting = Setting::find()->where(['setting_name' => 'elasticsearch_password'])->one()->setting_value;

$id = '';
if(isset($_POST['id'])) $query = $_POST['id'];

// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url_elasticsearch.'/'.$index.'/_doc/'.$id.'?pretty');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_USERPWD, $elasticsearch_username . ':' . $elasticsearch_password);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
?>