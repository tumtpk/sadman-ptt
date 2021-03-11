<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionAndAnswer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-and-answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'qa_questions')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'qa_answer')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?//= $form->field($model, 'qa_status')->textInput() ?>
            <?=$form->field($model, 'qa_status')->dropDownList([1 => 'เปิดการใช้งาน', 0 => 'ปิดการใช้งาน']); ?>
        </div>
        <div class="col-md-4">
            <?//= $form->field($model, 'qa_slot')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            
            <?= $form->field($model, 'qa_date_create')->hiddenInput(['maxlength' => true,"value"=>date("Y-m-d H:i:s")])->label(false); ?>
        </div>
    </div>

    <?= $form->field($model, 'user_create')->hiddenInput(['value' => $_SESSION['user_id'] ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
