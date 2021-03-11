<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DropdownModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dropdown-model-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
				<div class="card-body ribbon">
        <div class="row" style="width:550px;">
            <div class="col-6">
            <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6">
            <?= $form->field($model, '_id')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    
    
    
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>