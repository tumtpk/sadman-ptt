<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webboard-answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer_detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'answer_date_create')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer_user_create')->textInput() ?>

    <?= $form->field($model, 'topic_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_del')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key_images_or_file')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
