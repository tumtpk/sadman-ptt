<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardForum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webboard-forum-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'forum_name')->textInput(['maxlength' => true,'required'=>'required','oninvalid'=>'this.setCustomValidity(\'กรุณากรอกชื่อหมวดหมู่\')']) ?>

    <?= $form->field($model, 'forum_date_create')->hiddenInput(['maxlength' => true,'value'=>date("Y-m-d H:i:s")])->label(false); ?>

    <?= $form->field($model, 'forum_user_create')->hiddenInput(['maxlength' => true,'value'=>$_SESSION['user_id']])->label(false); ?>

    <div class="form-group text-center">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
