<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DescModal */

$this->title = 'Update Desc Modal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Desc Modals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="desc-modal-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
