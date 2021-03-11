<?php
use app\models\Setting;
$this->title = 'get Type';

$url_kibana =  $Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value;
$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
$index =  $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;

$elasticsearch_username =  $Setting = Setting::find()->where(['setting_name' => 'elasticsearch_username'])->one()->setting_value;
$elasticsearch_password =  $Setting = Setting::find()->where(['setting_name' => 'elasticsearch_password'])->one()->setting_value;


$ch = curl_init();

$column = isset($_GET['column']) ? $_GET['column'] : 'xxx'; 
$url = $url_elasticsearch.'/'.$index.'/_search?pretty';
//echo $url;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_POSTFIELDS, "\n{\n  \"size\": 0,\n  \"aggs\": {\n    \"type\": {\n      \"terms\": {\n        \"field\": \"".$column."\"\n      }\n    }\n  }\n}\n");
curl_setopt($ch, CURLOPT_USERPWD, $elasticsearch_username . ':' . $elasticsearch_password);
$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
echo ($result);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
?>