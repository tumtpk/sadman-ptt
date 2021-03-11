<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\KptagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จุดที่บุกรุก');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kptag-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">

                    <p>
                        <?= Html::a(Yii::t('app', 'เพิ่มจุดบุกรุก'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php
                    echo $this->render('_search', ['model' => $searchModel]);
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'idkp_tag',
                            'SP_KP',
                            'name_kp',
                            'UTM_Indian_N',
                            'UTM_Indian_E',
                            'UTM_WGS84_N',
                            'UTM_WGS84_E',
                            'GEO_WGS84_Lat',
                            'GEO_WGS84_Long',
                            'GEO_WGS84_2_Lat',
                            'GEO_WGS84_2_Long',
                            'remark',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>