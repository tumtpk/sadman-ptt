<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลหน่วยงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="unit-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card" id="check-height">
                        <div class="card-body ribbon">
                         <p>
                            <?= Html::a('แก้ไข', ['update', 'id' => $model->unit_id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('ยกเลิก', ['disable', 'id' => $model->unit_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'ต้องการปิดการใช้งานใช่หรือไม่?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'unit_id',
                                'unit_name',
                                'unit_detail',
                                'address',
                                'province',
                                [
                                    'attribute'=>'have_active',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {

                                        $user = Yii::$app->db->createCommand("SELECT * FROM users WHERE unit_id = '".$model->unit_id."' AND role = '2'")->queryAll();
                                        $show = '';
                                        foreach ($user as $value) {
                                            $show .= '<a href="#" onclick="window.open(\'index.php?r=users/view&id='.$value['id'].'\', \'blank\');">'.$value['name'].'</a>, ';
                                        }
                                        $show_all = substr_replace($show, "", -2);
                                        return (empty($show_all)) ? 'ไม่มีผู้ดูแลหน่วย' : $show_all;

                                    },
                                ],
                                [
                                    'label'=>'ผู้ใช้งานทั้งหมด',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {

                                        return '<a onclick="window.open(\'index.php?r=users/index&unitid='.$model->unit_id.'\');" href="#">'.$cusers = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `users` WHERE unit_id = '".$model->unit_id."'")->queryScalar().'</a> คน';
                                    },
                                ],
                                [
                                    'label'=>'สิทธิ์การเข้าถึงแบบฟอร์ม',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {
                                        $eform_template = Yii::$app->db->createCommand("SELECT * FROM eform_template WHERE unit_id LIKE '%\"".$model->unit_id."\"%' AND disable = '0'")->queryAll();
                                        $showeform_template = '';
                                        foreach ($eform_template as $value) {
                                            $showeform_template .= '- <a href="#" onclick="window.open(\'index.php?r=site/pages&view=eform_template&form_id='.$value['id'].'\', \'blank\');">'.$value['detail'].'</a><br>';
                                        }
                                        $show_all_eform = substr_replace($showeform_template, "", -4);

                                        return (empty($show_all_eform)) ? 'ไม่มีแบบฟอร์มที่เข้าถึงได้' : $show_all_eform;

                                    },
                                ],
                                [
                                    'label'=>'จำนวนข้อมูลที่บันทึกทั้งหมด',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {
                                        $eform_data = Yii::$app->db->createCommand("SELECT COUNT(eform_data.id) FROM eform,eform_data WHERE eform.unit_id = '".$model->unit_id."' AND eform.id = eform_data.eform_id")->queryScalar(); 
                                        return number_format($eform_data).' รายการ';
                                    },
                                ],
                                [
                                    'label'=>'จำกัดผู้แลหน่วย',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {
                                        return $model->admin_limit.' คน';
                                    },
                                ],
                                [
                                    'label'=>'จำกัดจำนวนผู้ใช้งาน',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {
                                        return $model->user_limit.' คน';
                                    },
                                ],
                                [
                                    'label'=>'จำกัดจำนวนสายข่าว',
                                    'format'=>'raw',
                                    'value' => function($model)
                                    {
                                        return $model->undercover_limit.' คน';
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <link
                data-require="leaflet@0.7.3"
                data-semver="0.7.3"
                rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css"
                />
                <script
                data-require="leaflet@0.7.3"
                data-semver="0.7.3"
                src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"
                ></script>
                <div id="mapshow" style="border-radius: 5px;
                width: 100%;
                height: 650px;
                margin-top: 11px;"></div>    
                <script>

                    var mymap = L.map('mapshow').setView([<?=$model->lat;?>, <?=$model->lon;?>], 10);

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                        maxZoom: 17,
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1
                    }).addTo(mymap);

                    L.marker([<?=$model->lat;?>, <?=$model->lon;?>],{
                      icon: new L.Icon({
                        iconAnchor: [12, 26],
                        iconUrl: '/textx/upload_file/marker/icon_marker.png',
                    })
                  }).addTo(mymap)
                    .bindPopup("<b>พิกัด (<?=$model->lat;?>, <?=$model->lon;?>)</b>").openPopup();

                    var popup = L.popup();


                </script>
            </div>
        </div>

    </div>
</div>

</div>
