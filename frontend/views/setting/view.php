<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = $model->setting_name;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="setting-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ล้างค่า', ['delete', 'id' => $model->id], [
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
            'id',
            'setting_name',
            'setting_value',
            // 'setting_status',
            [
                'attribute'=>'setting_status',
                'format'=>'raw',
                'value' => function($model, $key)
                {
                    if($model->setting_status=='1')
                    {
                        return 'เปิดการใช้งาน';
                    }else{
                        return 'ปิดการใช้งาน';
                    }
                },
            ],
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
