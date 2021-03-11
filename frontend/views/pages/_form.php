<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'page_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'iframe')->textArea(['maxlength' => true,'rows'=>6]) ?>

            <?=$form->field($model, 'status')->dropDownList([1 => 'เปิดการใช้งาน', 0 => 'ปิดการใช้งาน']); ?>
            
            <?= $form->field($model, 'user_create')->hiddenInput(['value' => $_SESSION['user_id'] ])->label(false); ?>

        </div>            
    </div>
            <div class="form-group">
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            </div>

    <?php ActiveForm::end(); ?>

</div>
