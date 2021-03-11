<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NewsValues */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-values-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'news_val_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'news_val_detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_create_update')->hiddenInput(['maxlength' => true,'value'=>$_SESSION['user_id']])->label(false); ?>

    <div class="form-group text-center">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
