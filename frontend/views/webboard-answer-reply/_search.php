<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardAnswerReplySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webboard-answer-reply-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'answer_reply_id') ?>

    <?= $form->field($model, 'answer_reply_detail') ?>

    <?= $form->field($model, 'answer_reply_date_create') ?>

    <?= $form->field($model, 'answer_reply_user_create') ?>

    <?= $form->field($model, 'answer_id') ?>

    <?php // echo $form->field($model, 'topic_id') ?>

    <?php // echo $form->field($model, 'status_del') ?>

    <?php // echo $form->field($model, 'key_images_or_file') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
