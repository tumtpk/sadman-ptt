<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DescModal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="desc-modal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'rows'=>'3']) ?>

    <?php //= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'status')->radioList([0 => 'เปิดใช้งาน', 1 => 'ปิดใช้งาน'])->label(false) ?>

    <?= $form->field($model, 'user_create')->hiddenInput(['value' => $_SESSION['user_id'] ])->label(false); ?>

    <div class="form-group text-center">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
