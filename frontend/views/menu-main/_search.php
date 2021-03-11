<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenuMainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-main-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?//= $form->field($model, 'id') ?>

    <?= $form->field($model, 'm_name') ?>

    <?//= $form->field($model, 'm_link') ?>

    <?//= $form->field($model, 'm_role') ?>

    <?//= $form->field($model, 'm_status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'สืบค้น'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'ล้างค่า'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
