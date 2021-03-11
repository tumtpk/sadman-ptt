<?
    use app\models\Pages;
    use app\models\Setting;
    $id = isset($_GET['id']) ? $_GET['id'] : '1';

    $customer_iframe = Pages::find()->where(['id' => $id])->one()->iframe;
    $customer_name = Pages::find()->where(['id' => $id])->one()->page_name;

    $customer_iframe = str_replace('{url_kibana}',$Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value,$customer_iframe);

echo '<h2>'.$customer_name.'</h2>';   
echo $customer_iframe;
?>
