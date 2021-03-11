<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Severity */

$this->title = 'Update Severity: ' . $model->idseverity;
$this->params['breadcrumbs'][] = ['label' => 'Severities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idseverity, 'url' => ['view', 'id' => $model->idseverity]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="severity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
