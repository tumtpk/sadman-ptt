<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswerReply */

$this->title = 'Create Webboard Answer Reply';
$this->params['breadcrumbs'][] = ['label' => 'Webboard Answer Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-answer-reply-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
