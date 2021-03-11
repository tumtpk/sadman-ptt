<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswer */

$this->title = 'Update Webboard Answer: ' . $model->answer_id;
$this->params['breadcrumbs'][] = ['label' => 'Webboard Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->answer_id, 'url' => ['view', 'id' => $model->answer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webboard-answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
