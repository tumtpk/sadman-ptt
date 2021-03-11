<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserLogUsaged */

$this->title = 'Update User Log Usaged: ' . $model->log_id;
$this->params['breadcrumbs'][] = ['label' => 'User Log Usageds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->log_id, 'url' => ['view', 'id' => $model->log_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-log-usaged-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
