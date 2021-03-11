<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SecretLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="secret-level-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'level')->textInput(['maxlength' => true]) ?>

              
                <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

              
                <?=$form->field($model, 'status')->dropDownList(['1' => 'เปิดการใช้งาน', '0' => 'ปิดการใช้งาน']); ?>
            </div>
        </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
            </div>

    <?php ActiveForm::end(); ?>

</div>
