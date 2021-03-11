<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DescModalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="desc-modal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">

        <?php //= $form->field($model, 'id') ?>

        <div class="col-md-3">
            <?= $form->field($model, 'topic') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'description') ?>
        </div>

        <div class="col-md-3" style="margin-top: 2.4rem!important;">
            <?php $model->status = (!empty($model->status)) ? $model->status : ''; ?>
            <?= $form->field($model, 'status')->radioList([''=>'ทั้งหมด',0 => 'เปิดใช้งาน', 1 => 'ปิดใช้งาน'])->label(false) ?>
        </div>

        <div class="form-group col-md-3" style="margin-top: 1.9rem!important;">
            <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary loadmapsearch']) ?>
            <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
