<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Kptag */

$this->title = $model->name_kp;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'จุดที่บุกรุก'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kptag-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <img src="https://www.w3schools.com/images/w3schools_green.jpg" alt="" class="img-view">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>