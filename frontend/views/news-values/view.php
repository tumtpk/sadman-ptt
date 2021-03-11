<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\NewsValues */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'News Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="news-values-view">

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
            'news_val_name',
            'news_val_detail',
            // 'user_create_update',
            [
                'attribute'=>'user_create_update',
                'format'=>'raw',
                'value' => function($model, $key)
                {
                    if(!empty($model->user_create_update))
                    {
                         $query = Users::find()
                        ->select('id,name')
                        ->where("id = " . $model->user_create_update)->one();
                        return $query->name;
                    }
                },
            ],
        ],
    ]) ?>

</div>
