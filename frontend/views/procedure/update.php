<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Procedure */

$this->title = 'Update Procedure: ' . $model->idprocedure;
$this->params['breadcrumbs'][] = ['label' => 'Procedures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idprocedure, 'url' => ['view', 'id' => $model->idprocedure]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procedure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
