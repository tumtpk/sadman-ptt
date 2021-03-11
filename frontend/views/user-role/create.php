<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */

$this->title = Yii::t('app', 'เพิ่มข้อมูลสิทธิ์การเข้าถึง');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
