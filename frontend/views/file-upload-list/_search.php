<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FileUploadListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-upload-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?//= $form->field($model, 'id') ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'bucket') ?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'text_extract') ?>
         </div>

    </div>

    <div class="row">
         

    </div>

    <?//= $form->field($model, 'file_name') ?>

    <?//= $form->field($model, 'form_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('สืบค้น', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
