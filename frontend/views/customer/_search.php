<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'cus_serial_number') ?></div>
        <div class="col-md-4"><?= $form->field($model, 'cus_basic') ?></div>
        <div class="col-md-4">
            <div class="form-group" style="margin-top: 1.9rem!important;">
                <?= Html::submitButton('สืบค้น', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>


    

    <?php ActiveForm::end(); ?>

</div>
