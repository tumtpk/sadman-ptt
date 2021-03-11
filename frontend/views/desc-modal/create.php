<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DescModal */

$this->title = 'Create Desc Modal';
$this->params['breadcrumbs'][] = ['label' => 'Desc Modals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desc-modal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
