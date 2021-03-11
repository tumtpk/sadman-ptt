<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Setting;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//include('../../function/function-redis.php');
//if($redis->EXISTS('url_node')==0)  $redis->set('url_node','http://192.168.1.37:3100/');
//echo '|'.$redis->get('url_node').'|';


    
    //header('Content-Type: application/json');
    /*$Setting = Setting::find()
    ->where(['setting_status' => 1])
    ->orderBy('id')
    ->all();

    foreach($Setting as $s){
        $redis->set($s->setting_name,$s->setting_value);
    }
   */
$this->title = 'ตั้งค่า'; //echo $redis->get('name');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('เพิ่มค่า Setting', ['create'], ['class' => 'btn btn-success']) ?>
                        
                        <!-- <a href="index.php?r=site/pages&view=setting" class="btn btn-warning">JSON</a> -->

                        
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        #'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            #'id',
                            'setting_name',
                            // 'setting_value',
                            [
                                'attribute' => 'setting_value',
                                'headerOptions' => ['style' => 'width:40%'],
                            ],
                        # 'setting_status',
                            [
                                'attribute'=>'setting_status',
                                'headerOptions' => ['style' => 'width:20%'],
                                'header'=>'สถานะ',
                                'filter' => ['1'=>'enable', '0'=>'disable'],
                                'format'=>'raw',    
                                'value' => function($model, $key, $index)
                                {   
                                    if($model->setting_status == '1')
                                    {
                                        return 'เปิดการใช้งาน';
                                    }
                                    else
                                    {   
                                        return 'ปิดการใช้งาน';
                                    }
                                },
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>


                </div>
            </div>
        </div>
    </div>
</div>

