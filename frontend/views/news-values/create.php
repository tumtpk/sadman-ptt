<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewsValues */

$this->title = 'Create News Values';
$this->params['breadcrumbs'][] = ['label' => 'News Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-values-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
