<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\QuestionAndAnswerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-and-answer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'qa_questions') ?>
        </div>
         <div class="col-md-6">
             <?= $form->field($model, 'qa_answer') ?>
         </div>
     </div>
     <div class="row">
         <div class="col-md-6">
             <?= $form->field($model, 'qa_date_create')->input('date',['maxlength' => true]) ?>
         </div>
         <div class="col-md-6">
         <?=$form->field($model, 'qa_status')->dropDownList([1 => 'เปิดการใช้งาน', 0 => 'ปิดการใช้งาน']); ?>
         </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
