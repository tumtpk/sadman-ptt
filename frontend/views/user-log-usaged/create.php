<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserLogUsaged */

$this->title = 'Create User Log Usaged';
$this->params['breadcrumbs'][] = ['label' => 'User Log Usageds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-log-usaged-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
