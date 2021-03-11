<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserLogUsagedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-log-usaged-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'log_id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'log_date') ?>

    <?= $form->field($model, 'remark') ?>

    <?= $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
