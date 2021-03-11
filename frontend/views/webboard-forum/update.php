<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardForum */

$this->title = 'Update Webboard Forum: ' . $model->forum_id;
$this->params['breadcrumbs'][] = ['label' => 'Webboard Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->forum_id, 'url' => ['view', 'id' => $model->forum_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webboard-forum-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
