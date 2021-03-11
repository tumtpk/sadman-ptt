<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\WebboardForum */

$this->title = $model->forum_id;
$this->params['breadcrumbs'][] = ['label' => 'Webboard Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webboard-forum-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->forum_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->forum_id], [
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
            'forum_id',
            'forum_name',
            [
                'attribute'=>'forum_date_create',
                'format'=>'raw',
                'value' => function($model, $key)
                {
                    if(!empty($model->forum_date_create))
                    {
                        return DateThaiTime($model->forum_date_create);
                    }
                },
            ],
            [
                'attribute'=>'forum_user_create',
                'format'=>'raw',
                'value' => function($model, $key)
                {
                    if(!empty($model->forum_user_create))
                    {
                         $query = Users::find()
                        ->select('id,name')
                        ->where("id = " . $model->forum_user_create)->one();
                        return $query->name;
                    }
                },
            ],
        ],
    ]) ?>

</div>
