<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserWebsiteUsaged */

$this->title = 'Update User Website Usaged: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Website Usageds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-website-usaged-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
