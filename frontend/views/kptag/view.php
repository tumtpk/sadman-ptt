<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Kptag */

$this->title = $model->idkp_tag;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kptags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kptag-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idkp_tag], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idkp_tag], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idkp_tag',
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
