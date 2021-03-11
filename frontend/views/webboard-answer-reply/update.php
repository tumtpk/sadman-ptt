<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswerReply */

$this->title = 'Update Webboard Answer Reply: ' . $model->answer_reply_id;
$this->params['breadcrumbs'][] = ['label' => 'Webboard Answer Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->answer_reply_id, 'url' => ['view', 'id' => $model->answer_reply_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webboard-answer-reply-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
