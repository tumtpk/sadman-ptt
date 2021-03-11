<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswer */

$this->title = 'Create Webboard Answer';
$this->params['breadcrumbs'][] = ['label' => 'Webboard Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
