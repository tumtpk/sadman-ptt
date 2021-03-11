<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CarouselText */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'สไลด์ข่าวหน้าเข้าสู่ระบบ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="carousel-text-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
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
                            'name',
                            'detail',
                            //'images:ntext',
                            [
                                'attribute'=>'images',
                                'value'=>'/textx/frontend/web/uploads/'.$model->images,
                                'format' => ['image',['width'=>'200','height'=>'200']],
                            ],
                            //'slot',
                            'create_time',
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
    </div>
</div> 
