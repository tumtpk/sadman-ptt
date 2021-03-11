<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Kptag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kptag-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'SP_KP')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'name_kp')->textInput(['maxlength' => true]) ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'UTM_Indian_N')->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'UTM_Indian_E')->textInput() ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'UTM_WGS84_N')->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'UTM_WGS84_E')->textInput() ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'GEO_WGS84_Lat')->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'GEO_WGS84_Long')->textInput() ?></div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'GEO_WGS84_2_Lat')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'GEO_WGS84_2_Long')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?></div>
    </div>

</div>




<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>