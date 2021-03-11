<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Severity */

$this->title = 'Create Severity';
$this->params['breadcrumbs'][] = ['label' => 'Severities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="severity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
