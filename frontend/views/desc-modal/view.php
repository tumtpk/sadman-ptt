<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DescModal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Desc Modals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="desc-modal-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'topic',
            'description',
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
            [
                        'attribute'=>'status',
                        'format'=>'raw',
                        'value' => function($model)
                        {
                            if($model->status=='0')
                            {
                                return '<a href="#" data-toggle="tooltip" data-placement="top" title="เปิดการใช้งาน!"><i class="fa fa-circle text_sussess_a6ca16"></i></a>';
                            }else{
                                return '<a href="#" data-toggle="tooltip" data-placement="top" title="ปิดการใช้งาน!"><i class="fa fa-circle text_danger_dc3545"></i></a>';
                            }
                        },
                    ],
        ],
    ]) ?>

</div>
