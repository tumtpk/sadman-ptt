<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserWebsiteUsaged */

$this->title = 'Create User Website Usaged';
$this->params['breadcrumbs'][] = ['label' => 'User Website Usageds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-website-usaged-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
