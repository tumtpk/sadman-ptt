<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRoleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-role-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">

        <?//= $form->field($model, 'id') ?>

        <div class="col-md-6">
            <?= $form->field($model, 'role')->label("สิทธิ์การเข้าใช้งาน") ?>
        </div>

        <?//= $form->field($model, 'allow_access_main') ?>

        <?//= $form->field($model, 'allow_access_sub') ?>

        <div class="form-group col-md-12">
            <?= Html::submitButton(Yii::t('app', 'สืบค้น'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'ล้างค่า'), ['class' => 'btn btn-outline-secondary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
