<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use frontend\models\InvasionlistSearch;
use common\models\Kptag;
use common\models\Procedure;

/* @var $this yii\web\View */
/* @var $model common\models\Kptag */

$this->title = $model->name_kp;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'จุดที่บุกรุก'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$searchModel = new InvasionlistSearch();
$data = $searchModel->filter($model->idkp_tag);
?>

<style>
    .card-header {
        padding: 20px 20px 10px 20px !important;
    }
</style>
<div class="kptag-view">
    <div class="row clearfix">
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="card-body ribbon">
                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
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
                                ],
                            ]) ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>รายการบุกรุก</h3>
                </div>
                <div class="card-body ribbon">
                    <div class="row">
                        <div class="col-md-12">
                            <?= GridView::widget([
                                'dataProvider' => $data,
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'ระยะท่อ',
                                        'attribute' => 'kp_id',
                                        'value' => function ($model) {
                                            $kp = Kptag::find()->where(['idkp_tag' => $model->kp_id])->one();
                                            return $kp->SP_KP;
                                        }
                                    ],
                                    'detail',
                                    [
                                        'label' => 'ขั้นตอน',
                                        'attribute' => 'procedure_id',
                                        'value' => function ($model) {
                                            $severity = Procedure::find()->where(['idprocedure' => $model->procedure_id])->one();
                                            return $severity->procedureName;
                                        }
                                    ],
                                    // [
                                    //     'class' => 'yii\grid\ActionColumn',
                                    //     // 'header' => 'Action',
                                    //     // 'template' => '{view}'
                                    // ],
                                ],
                            ]); ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>