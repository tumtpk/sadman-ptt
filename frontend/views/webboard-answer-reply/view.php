<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswerReply */

$this->title = $model->answer_reply_id;
$this->params['breadcrumbs'][] = ['label' => 'Webboard Answer Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webboard-answer-reply-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->answer_reply_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->answer_reply_id], [
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
            'answer_reply_id',
            'answer_reply_detail:ntext',
            'answer_reply_date_create',
            'answer_reply_user_create',
            'answer_id',
            'topic_id',
            'status_del',
            'key_images_or_file',
        ],
    ]) ?>

</div>
