<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UndercoverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (isset($_GET['unitid'])) {
    $UnitName = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$_GET['unitid']."'")->queryOne();
    $this->title = 'ข้อมูลสายข่าวในหน่วยงาน : '.$UnitName['unit_name'];
}else{
    if ($_SESSION['user_role']=='2') {
        echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
    }
    $this->title = 'ข้อมูลส่ายข่าว';
}


$this->params['breadcrumbs'][] = $this->title;
$day_now = date('Y-m-d');
?>
<div class="undercover-index">

<div class="row clearfix">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body ribbon">
                <p>
                <?php if (isset($_GET['unitid'])): ?>
                        <?php if ($_SESSION['user_role']==1): ?>
                            <?= Html::a('เพิ่มสายข่าวในหน่วย', ['create_undercover','unitid'=>$_GET['unitid'],'unitname'=>$UnitName['unit_name']], ['class' => 'btn btn-success']) ?>
                            <?php else: ?>
                                <?= Html::a('เพิ่มสายข่าวในหน่วย', ['create_undercover'], ['class' => 'btn btn-success']) ?>
                            <?php endif ?>
                            <?php else: ?>
                                <?= Html::a('เพิ่มผู้ใช้งานระบบ', ['create'], ['class' => 'btn btn-success']) ?>
                            <?php endif ?>
                        </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'undercover_number',
            'name',
            // 'unitid',
            [
                'attribute'=>'unitid',
                'format'=>'raw',    
                'value' => function($model, $key, $index)
                {
                    if(!empty($model->unitid))
                    {
                        $unit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$model->unitid."'")->queryOne();
                        return $unit['unit_name'];
                    }
                },
            ],
            // 'images:ntext',
            //'status',
            [
                'attribute'=>'status',
                'label'=>'สิทธิ์การเข้าใช้งานระบบ',
                'format'=>'raw',
                'value' => function($model, $key, $index)
                {

                    if ($model->status=='1') {
                        return 'เปิด';
                    }else{
                        return 'ปิด';
                    }


                },
            // 'visible' => $_SESSION['user_role']=='1' ? true : false
            ],
            //'email:email',
            //'address:ntext',
            //'phone',

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-eye"></i>',
                        ['users/view', 'id' => $model->id],['title' => 'View','class'=>'btn btn-light']
                    );
                },
                'update' => function ($url, $model, $key) {

                    return Html::a('<i class="fas fa-pencil-alt"></i>',
                        ['users/update', 'id' => $model->id],['title' => 'Update','class'=>'btn btn-light']
// ['target'=>'_blank', 'title' => 'Update']
                    );
                },
                'delete' => function ($url, $model, $key) {
                    if($_SESSION['user_role']=='2' && $model->role=='2'){
                        return false;
                    }else if($model->role=='1'){
                        return false;
                    }else{
                        return  Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app', 'ต้องการยกเลิกผู้ใช้งานใช่หรือไม่?'),'method' => 'post','title'=>'Delete'],'class'=>'btn btn-light']);
                    }

                },

                ],
                'options'=> ['style'=>'width:20%;'],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
            </div>
        </div>
    </div>

</div>
