<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Invasionlist */

$this->title = 'Update Invasionlist: ' . $model->idinvasionlist;
$this->params['breadcrumbs'][] = ['label' => 'Invasionlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idinvasionlist, 'url' => ['view', 'id' => $model->idinvasionlist]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="invasionlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
