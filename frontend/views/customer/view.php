<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->cus_serial_number;
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('แกไข้', ['update', 'id' => $model->cus_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('ลบ', ['delete', 'id' => $model->cus_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'cus_id',
                    'cus_serial_number',
                    'cus_key',
                    'cus_basic',
                     // 'user_create',
                     [
                        'attribute' => 'user_create',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!empty($model->user_create)) {
                                $data1 = Yii::$app->db->createCommand("SELECT name FROM users WHERE id ='".$model->user_create."'")->queryOne();
                                    return $data1['name'];
                                }
                                    },
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
